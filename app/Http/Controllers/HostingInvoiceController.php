<?php

namespace App\Http\Controllers;

use App\Models\HostingInvoice;
use App\Models\HostingProfile;
use App\Services\HostingRenewal;
use Illuminate\Http\Request;

class HostingInvoiceController extends Controller
{
    public function index(HostingRenewal $renewal)
    {
        $renewal->sync();
        $profile = HostingProfile::current();
        $invoices = HostingInvoice::query()->orderByDesc('period_end')->orderByDesc('id')->get();
        $rate = $profile->usd_to_rwf_rate ? (float) $profile->usd_to_rwf_rate : null;
        $previewHosting = $rate ? $renewal->hostingRwf((float) $profile->annual_hosting_usd, $rate) : null;
        $previewTotal = $previewHosting === null ? null : $previewHosting + (int) $profile->annual_support_rwf;

        return view('content-management.hosting.index', compact(
            'profile',
            'invoices',
            'previewHosting',
            'previewTotal'
        ));
    }

    public function updateRate(Request $request, HostingRenewal $renewal)
    {
        $data = $request->validate([
            'usd_to_rwf_rate' => ['required', 'numeric', 'min:1', 'max:1000000'],
        ]);

        $renewal->applyRate((float) $data['usd_to_rwf_rate']);

        return redirect()
            ->route('content-management.hosting.index')
            ->with('success', 'Dollar rate saved. The active invoice total now includes hosting and support.');
    }

    public function markPaid(HostingInvoice $invoice, HostingRenewal $renewal)
    {
        abort_unless(auth()->user()?->isAdmin(), 403);

        if ($invoice->isPaid()) {
            return redirect()
                ->route('content-management.hosting.index')
                ->with('success', 'This invoice is already marked paid.');
        }

        if ($invoice->total_rwf === null) {
            return redirect()
                ->route('content-management.hosting.index')
                ->with('error', 'Enter the current dollar rate before confirming this invoice as paid.');
        }

        $renewal->markPaid($invoice);

        return redirect()
            ->route('content-management.hosting.index')
            ->with('success', 'Invoice '.$invoice->invoice_number.' is marked paid.');
    }

    public function show(HostingInvoice $invoice, HostingRenewal $renewal)
    {
        $renewal->sync();
        $invoice->refresh();
        $profile = HostingProfile::current();

        return view('content-management.hosting.invoice', [
            'invoice' => $invoice,
            'profile' => $profile,
            'issuer' => config('hosting.issuer'),
            'payment' => config('hosting.payment'),
            'billTo' => config('hosting.bill_to'),
            'note' => config('hosting.note'),
        ]);
    }
}
