<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New booking</title>
</head>
<body style="font-family: Georgia, serif; line-height: 1.6; color: #333; max-width: 560px; margin: 0 auto; padding: 24px;">
    <h1 style="font-size: 20px;">New booking request</h1>
    <p><strong>{{ $booking->names }}</strong> — {{ $booking->email }} — {{ $booking->phone }}</p>
    @php
        $type = $booking->reservation_type ?? 'room';
    @endphp
    <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Type</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $type }}</td></tr>
        @if($type === 'room' && $booking->room)
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Room</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $booking->room->title }}</td></tr>
        @endif
        @if($type === 'facility' && $booking->facility)
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Facility</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $booking->facility->title }}</td></tr>
        @endif
        @if($type === 'tour_activity' && $booking->tourActivity)
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Activity</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $booking->tourActivity->title ?? '—' }}</td></tr>
        @endif
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Check-in / start</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $booking->checkin_date?->format('Y-m-d') ?? '—' }}</td></tr>
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Check-out / end</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $booking->checkout_date?->format('Y-m-d') ?? '—' }}</td></tr>
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Guests</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">Adults: {{ $booking->adults ?? '—' }}@if($booking->children !== null)
            , children: {{ $booking->children }}
        @endif</td></tr>
        @if(filled($booking->rooms))
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Rooms</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $booking->rooms }}</td></tr>
        @endif
        @if(filled($booking->total_amount))
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Total (estimate)</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ number_format((float) $booking->total_amount, 2) }}</td></tr>
        @endif
    </table>
    @if(filled($booking->message))
    <p style="margin: 0 0 8px;"><strong>Message</strong></p>
    <p style="margin: 0; white-space: pre-wrap;">{{ $booking->message }}</p>
    @endif
</body>
</html>
