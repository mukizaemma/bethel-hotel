<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hosting renewal</title>
</head>
<body style="font-family: Georgia, serif; line-height: 1.6; color: #222; max-width: 560px; margin: 0 auto; padding: 24px;">
    <p style="margin: 0 0 8px; font-size: 13px; letter-spacing: 0.04em; text-transform: uppercase; color: #555;">{{ $issuer['company'] }}</p>
    <h1 style="font-size: 22px; margin: 0 0 16px;">Website hosting renewal</h1>

    @if($milestone === 'd30')
        <p>The website hosting for <strong>{{ $invoice->periodLabel() }}</strong> expires on <strong>{{ $invoice->period_end->format('j F Y') }}</strong>, 30 days from now.</p>
    @elseif($milestone === 'd15')
        <p>The website hosting for <strong>{{ $invoice->periodLabel() }}</strong> expires on <strong>{{ $invoice->period_end->format('j F Y') }}</strong>, 15 days from now.</p>
    @elseif($daysUntil < 0)
        <p>The hosting renewal date of <strong>{{ $invoice->period_end->format('j F Y') }}</strong> has passed and invoice <strong>{{ $invoice->invoice_number }}</strong> is still unpaid. The invoice stays <strong>expired</strong> until Ireme Technologies confirms payment.</p>
    @else
        <p>Today, <strong>{{ $invoice->period_end->format('j F Y') }}</strong>, is the hosting renewal date for invoice <strong>{{ $invoice->invoice_number }}</strong>. If it is still unpaid, the status is now <strong>expired</strong> until Ireme Technologies confirms payment.</p>
    @endif

    <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
        <tr>
            <td style="padding: 6px 0; border-bottom: 1px solid #e5e5e5;">Invoice</td>
            <td style="padding: 6px 0; border-bottom: 1px solid #e5e5e5;"><strong>{{ $invoice->invoice_number }}</strong></td>
        </tr>
        <tr>
            <td style="padding: 6px 0; border-bottom: 1px solid #e5e5e5;">Period</td>
            <td style="padding: 6px 0; border-bottom: 1px solid #e5e5e5;">{{ $invoice->periodLabel() }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 0; border-bottom: 1px solid #e5e5e5;">Amount to pay</td>
            <td style="padding: 6px 0; border-bottom: 1px solid #e5e5e5;"><strong>{{ $invoice->total_rwf === null ? 'Rate not set yet' : number_format($invoice->total_rwf).' RWF' }}</strong></td>
        </tr>
    </table>

    <p style="margin: 0 0 8px;"><strong>Payment</strong></p>
    <p style="margin: 0 0 4px;">Bank transfer: Account No. {{ $payment['bank_account'] }}, {{ $payment['bank_name'] }}, {{ $payment['bank_account_name'] }}</p>
    <p style="margin: 0 0 16px;">MoMo Pay: {{ $payment['momo_code'] }}, {{ $payment['momo_name'] }}</p>

    <p style="margin: 0 0 16px;">
        <a href="{{ $invoiceUrl }}" style="display: inline-block; background: #111; color: #fff; text-decoration: none; padding: 10px 16px;">Open the invoice</a>
    </p>
    <p style="font-size: 13px; color: #555;">{{ $issuer['company'] }} · {{ $issuer['phone'] }} · {{ $issuer['email'] }}</p>
</body>
</html>
