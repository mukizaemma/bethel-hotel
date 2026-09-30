<?php

namespace App\Console\Commands;

use App\Services\HostingRenewal;
use Illuminate\Console\Command;

class HostingRenewalsCommand extends Command
{
    protected $signature = 'hosting:renewals';

    protected $description = 'Expire unpaid hosting invoices after 1 August and email renewal reminders';

    public function handle(HostingRenewal $renewal): int
    {
        $sent = $renewal->sendDueReminders();
        $this->info('Hosting renewal reminders sent: '.$sent);

        return self::SUCCESS;
    }
}
