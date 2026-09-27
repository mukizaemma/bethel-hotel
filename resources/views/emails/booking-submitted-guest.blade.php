<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking received</title>
</head>
<body style="font-family: Georgia, serif; line-height: 1.6; color: #333; max-width: 560px; margin: 0 auto; padding: 24px;">
    <h1 style="font-size: 20px;">Thank you, {{ $booking->names }}</h1>
    <p>We have received your booking request and will get back to you shortly.</p>
    @php
        $type = $booking->reservation_type ?? 'room';
    @endphp
    <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
        @if($type === 'room' && $booking->room)
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Room</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $booking->room->title }}</td></tr>
        @endif
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Check-in</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $booking->checkin_date?->format('Y-m-d') ?? '—' }}</td></tr>
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Check-out</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">{{ $booking->checkout_date?->format('Y-m-d') ?? '—' }}</td></tr>
        <tr><td style="padding: 6px 0; border-bottom: 1px solid #eee;"><strong>Guests</strong></td><td style="padding: 6px 0; border-bottom: 1px solid #eee;">Adults: {{ $booking->adults ?? '—' }}@if($booking->children !== null), children: {{ $booking->children }}@endif</td></tr>
    </table>
    <p style="font-size: 14px; color: #666;">If you need to reach us sooner, reply to this email or call the hotel.</p>
</body>
</html>
