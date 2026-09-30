<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice->invoice_number }} — Website hosting renewal</title>
    <style>
        body { margin: 0; background: #e9eef3; color: #1a1a1a; font-family: "Times New Roman", Times, serif; }
        .toolbar { max-width: 820px; margin: 16px auto; display: flex; gap: 8px; justify-content: flex-end; }
        .toolbar a, .toolbar button { font-family: "Segoe UI", sans-serif; font-size: 14px; border: 1px solid #111; background: #111; color: #fff; border-radius: 4px; padding: 8px 14px; text-decoration: none; cursor: pointer; }
        .toolbar a.ghost { background: #fff; color: #111; }
        .sheet { max-width: 820px; margin: 0 auto 32px; background: #fff; padding: 48px 52px; box-shadow: 0 8px 30px rgba(0,0,0,.08); }
        .issuer { font-size: 15px; line-height: 1.45; }
        .issuer strong { font-size: 18px; }
        h1 { font-size: 22px; font-weight: 600; margin: 28px 0 18px; text-align: center; }
        .meta { margin: 0 0 8px; }
        .note { margin: 16px 0 22px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #222; padding: 8px 10px; vertical-align: top; text-align: left; }
        th { font-weight: 600; }
        .num { text-align: right; white-space: nowrap; }
        .total td { font-weight: 700; }
        .pay { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 28px; }
        .sign { margin-top: 36px; }
        .status { display: inline-block; margin-top: 8px; padding: 2px 8px; border: 1px solid #222; font-family: "Segoe UI", sans-serif; font-size: 12px; letter-spacing: .06em; text-transform: uppercase; }
        @media print {
            body { background: #fff; }
            .toolbar { display: none !important; }
            .sheet { box-shadow: none; margin: 0; max-width: none; padding: 0; }
            @page { size: A4; margin: 16mm; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <a class="ghost" href="{{ route('content-management.hosting.index') }}">Back</a>
        <button type="button" onclick="window.print()">Print</button>
        <button type="button" onclick="window.print()">Download PDF</button>
    </div>
    <article class="sheet">
        <div class="issuer">
            <strong>{{ $issuer['company'] }}</strong><br>
            {{ $issuer['address'] }}<br>
            Tel: {{ $issuer['phone'] }}<br>
            Email: {{ $issuer['email'] }}
        </div>
        <h1>Website hosting renewal Invoice</h1>
        <p class="meta"><strong>Invoice No.:</strong> {{ $invoice->invoice_number }}</p>
        <p class="meta"><strong>Billing To:</strong> {{ $billTo }}</p>
        <p class="meta"><strong>Status:</strong> <span class="status">{{ ucfirst($invoice->status) }}</span></p>
        <p class="note"><strong>Note:</strong> {{ $note }}</p>

        <p style="margin-bottom: 8px;"><strong>Service details</strong></p>
        <table>
            <thead>
                <tr>
                    <th style="width: 36px;">#</th>
                    <th>Service Description</th>
                    <th>Hosting Period</th>
                    <th class="num">Amount/Rwf</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        {{ $invoice->hosting_label }}
                        @if($invoice->hosting_usd)
                            <br><span style="font-size: 13px;">${{ rtrim(rtrim(number_format((float) $invoice->hosting_usd, 2), '0'), '.') }} hosting
                            @if($invoice->usd_to_rwf_rate)
                                at {{ number_format((float) $invoice->usd_to_rwf_rate) }} RWF per USD
                            @endif
                            </span>
                        @endif
                    </td>
                    <td>{{ $invoice->periodLabel() }}</td>
                    <td class="num">{{ $invoice->hostingAmountLabel() }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Annual Support Fees</td>
                    <td>—</td>
                    <td class="num">{{ $invoice->supportLabel() }}</td>
                </tr>
                <tr class="total">
                    <td colspan="3">Amount to Pay</td>
                    <td class="num">{{ $invoice->totalLabel() }}</td>
                </tr>
            </tbody>
        </table>

        <div class="pay">
            <div>
                <strong>2. Payment Methods:</strong>
                <p style="margin: 8px 0 0;"><strong>Bank Transfer</strong><br>
                    Account No: {{ $payment['bank_account'] }}, {{ $payment['bank_name'] }}<br>
                    Names: {{ $payment['bank_account_name'] }}</p>
            </div>
            <div>
                <p style="margin: 28px 0 0;"><strong>MoMo Pay</strong><br>
                    {{ $payment['momo_code'] }}<br>
                    {{ $payment['momo_name'] }}</p>
            </div>
        </div>

        <div class="sign">
            <p style="margin: 0;">Prepared by,</p>
            <p style="margin: 28px 0 0;"><strong>{{ $invoice->prepared_by }}</strong></p>
            <p style="margin: 4px 0 0;">Date: {{ $invoice->issued_on->format('j/F/Y') }}</p>
        </div>
    </article>
</body>
</html>
