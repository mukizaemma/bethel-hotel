<?php

namespace App\Services;

use App\Mail\HostingRenewalMail;
use App\Models\HostingInvoice;
use App\Models\HostingProfile;
use App\Models\HostingReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HostingRenewal
{
    public function sync(): void
    {
        $this->refreshStatuses();
        $this->ensureUpcomingInvoice();
    }

    public function refreshStatuses(): void
    {
        HostingInvoice::query()
            ->where('status', '!=', 'paid')
            ->orderBy('id')
            ->each(function (HostingInvoice $invoice) {
                $next = $this->isPastExpiration($invoice) ? 'expired' : 'active';
                if ($invoice->status !== $next) {
                    $invoice->status = $next;
                    $invoice->save();
                }
            });
    }

    public function ensureUpcomingInvoice(): void
    {
        $hasFutureExpiration = HostingInvoice::query()
            ->whereDate('period_end', '>', today()->toDateString())
            ->exists();

        if ($hasFutureExpiration) {
            return;
        }

        $latest = HostingInvoice::query()->orderByDesc('period_end')->orderByDesc('id')->first();
        $start = $latest?->period_end?->copy() ?? $this->nextAugust(today());
        if (HostingInvoice::query()->whereDate('period_start', $start->toDateString())->exists()) {
            return;
        }

        $this->createInvoice(HostingProfile::current(), $start, $start->copy()->addYear());
    }

    public function applyRate(float $rate): void
    {
        $profile = HostingProfile::current();
        $profile->usd_to_rwf_rate = $rate;
        $profile->save();

        HostingInvoice::query()
            ->where('status', '!=', 'paid')
            ->whereNotNull('hosting_usd')
            ->each(function (HostingInvoice $invoice) use ($rate, $profile) {
                $invoice->usd_to_rwf_rate = $rate;
                $invoice->support_amount_rwf = (int) $profile->annual_support_rwf;
                $invoice->hosting_amount_rwf = $this->hostingRwf((float) $invoice->hosting_usd, $rate);
                $invoice->total_rwf = $invoice->hosting_amount_rwf + (int) $invoice->support_amount_rwf;
                $invoice->save();
            });
    }

    public function markPaid(HostingInvoice $invoice): void
    {
        $invoice->status = 'paid';
        $invoice->paid_at = now();
        $invoice->save();
    }

    public function hostingRwf(float $usd, float $rate): int
    {
        return (int) round($usd * $rate);
    }

    /**
     * Email the hotel 30 days before, 15 days before, and on the expiration day.
     */
    public function sendDueReminders(): int
    {
        $this->sync();
        $sent = 0;

        HostingInvoice::query()
            ->where('status', '!=', 'paid')
            ->orderBy('period_end')
            ->each(function (HostingInvoice $invoice) use (&$sent) {
                $daysUntil = $this->daysUntilExpiration($invoice);
                $milestone = $this->milestoneFor($daysUntil);
                if ($milestone === null || $this->alreadySent($invoice, $milestone)) {
                    return;
                }

                $email = HostingProfile::current()->notificationEmail();
                if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    Log::warning('Hosting renewal reminder skipped: no notification email.', [
                        'invoice' => $invoice->invoice_number,
                    ]);

                    return;
                }

                $delivered = SiteNotificationMail::sendToGuest(
                    $email,
                    new HostingRenewalMail($invoice, $milestone, $daysUntil)
                );

                if (! $delivered) {
                    return;
                }

                HostingReminder::query()->create([
                    'hosting_invoice_id' => $invoice->id,
                    'milestone' => $milestone,
                    'sent_at' => now(),
                ]);
                $sent++;
            });

        return $sent;
    }

    public function daysUntilExpiration(HostingInvoice $invoice): int
    {
        $end = $invoice->period_end->copy()->startOfDay();
        $today = today()->startOfDay();
        $days = $today->diff($end)->days;

        return $today->gt($end) ? -1 * (int) $days : (int) $days;
    }

    public function milestoneFor(int $daysUntil): ?string
    {
        if ($daysUntil <= 30 && $daysUntil > 15) {
            return 'd30';
        }
        if ($daysUntil <= 15 && $daysUntil > 0) {
            return 'd15';
        }
        if ($daysUntil <= 0) {
            return 'd0';
        }

        return null;
    }

    protected function alreadySent(HostingInvoice $invoice, string $milestone): bool
    {
        return $invoice->reminders()->where('milestone', $milestone)->exists();
    }

    protected function isPastExpiration(HostingInvoice $invoice): bool
    {
        return $invoice->period_end->copy()->startOfDay()->lte(today()->startOfDay());
    }

    protected function createInvoice(HostingProfile $profile, Carbon $start, Carbon $end): HostingInvoice
    {
        $rate = $profile->usd_to_rwf_rate ? (float) $profile->usd_to_rwf_rate : null;
        $usd = (float) $profile->annual_hosting_usd;
        $support = (int) $profile->annual_support_rwf;
        $hostingRwf = $rate ? $this->hostingRwf($usd, $rate) : null;

        return HostingInvoice::query()->create([
            'invoice_number' => $this->nextInvoiceNumber($start),
            'period_start' => $start->toDateString(),
            'period_end' => $end->toDateString(),
            'hosting_label' => 'Domain renewal, hosting & SSL services renewal',
            'hosting_usd' => $usd,
            'hosting_amount_rwf' => $hostingRwf,
            'support_amount_rwf' => $support,
            'usd_to_rwf_rate' => $rate,
            'total_rwf' => $hostingRwf === null ? null : $hostingRwf + $support,
            'status' => $end->copy()->startOfDay()->lte(today()->startOfDay()) ? 'expired' : 'active',
            'issued_on' => $start->toDateString(),
            'prepared_by' => (string) config('hosting.issuer.prepared_by'),
        ]);
    }

    protected function nextInvoiceNumber(Carbon $periodStart): string
    {
        $max = 0;
        foreach (HostingInvoice::query()->pluck('invoice_number') as $number) {
            if (preg_match('/WH-(\d+)/', (string) $number, $matches)) {
                $max = max($max, (int) $matches[1]);
            }
        }

        return sprintf('IREME/BH005/WH-%03d/%d', $max + 1, $periodStart->year);
    }

    protected function nextAugust(Carbon $from): Carbon
    {
        $august = $from->copy()->startOfDay()->month(8)->day(1);
        if ($from->copy()->startOfDay()->gt($august)) {
            $august->addYear();
        }

        return $august;
    }
}
