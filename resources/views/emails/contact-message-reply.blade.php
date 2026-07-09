<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message from {{ config('app.name') }}</title>
</head>
<body style="font-family: Georgia, serif; line-height: 1.6; color: #333; max-width: 560px; margin: 0 auto; padding: 24px;">
    @if(filled($enquiry->reply_subject))
        <h1 style="font-size: 20px; margin-bottom: 8px;">{{ $enquiry->reply_subject }}</h1>
        <p style="margin: 0 0 16px;">Hello {{ $enquiry->names }},</p>
    @else
        <h1 style="font-size: 20px; margin-bottom: 16px;">Hello {{ $enquiry->names }}</h1>
        <p style="margin: 0 0 16px;">Here is a reply regarding your recent enquiry:</p>
    @endif
    <div style="background: #f5f5f5; padding: 16px; border-radius: 8px; margin-bottom: 24px; white-space: pre-wrap;">{{ $enquiry->admin_reply }}</div>

    {{-- <p style="margin: 24px 0;">
        <a href="{{ route('connect') }}" style="display: inline-block; background: #0048ff; color: #fff; text-decoration: none; padding: 12px 20px; border-radius: 6px; font-weight: bold;">View availability &amp; book</a>
    </p>
    <p style="font-size: 13px; color: #666;">{{ config('app.name') }}</p> --}}
</body>
</html>
