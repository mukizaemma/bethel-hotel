<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New enquiry</title>
</head>
<body style="font-family: Georgia, serif; line-height: 1.6; color: #333; max-width: 560px; margin: 0 auto; padding: 24px;">
    <h1 style="font-size: 20px; margin-bottom: 16px;">{{ $adminTitle }}</h1>
    <p style="margin: 0 0 16px;">You have a new message from <strong>{{ $enquiry->names }}</strong>.</p>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Type</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $typeLabel }}</td></tr>
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Phone</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $enquiry->phone ?? '—' }}</td></tr>
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Email</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $enquiry->email ?? '—' }}</td></tr>
        @if(in_array($enquiry->enquiry_type ?? 'general', ['general', 'proposal', 'meetings', 'dining'], true))
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Subject</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $enquiry->subject }}</td></tr>
        @endif
        @if(($enquiry->enquiry_type ?? 'general') === 'room' && $enquiry->room)
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Room</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $enquiry->room->title }}</td></tr>
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Check-in</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $enquiry->checkin_date?->format('Y-m-d') }}</td></tr>
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Check-out</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $enquiry->checkout_date?->format('Y-m-d') }}</td></tr>
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Guests</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">Adults: {{ $enquiry->adults ?? '—' }}@if($enquiry->children !== null)
            , children: {{ $enquiry->children }}
        @endif</td></tr>
        @endif
    </table>

    @if(filled($enquiry->message))
    <p style="margin: 0 0 8px;"><strong>Message</strong></p>
    <p style="margin: 0 0 24px; white-space: pre-wrap;">{{ $enquiry->message }}</p>
    @endif

    <p style="margin: 24px 0;">
        <a href="{{ route('getMessages') }}" style="display: inline-block; background: #0048ff; color: #fff; text-decoration: none; padding: 12px 20px; border-radius: 6px; font-weight: bold;">Open enquiries in admin</a>
    </p>
    <p style="font-size: 13px; color: #666;">Reply to the guest from the admin panel once you are ready.</p>
</body>
</html>
