<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you</title>
</head>
<body style="font-family: Georgia, serif; line-height: 1.6; color: #333; max-width: 560px; margin: 0 auto; padding: 24px;">
    <h1 style="font-size: 20px; margin-bottom: 16px;">Thank you, {{ $enquiry->names }}</h1>
    <p style="margin: 0 0 16px;">We have received your {{ $enquiryTypeLine }} and will get back to you as soon as we can.</p>

    <p style="margin: 24px 0;">
        <a href="{{ route('connect') }}" style="display: inline-block; background: #0048ff; color: #fff; text-decoration: none; padding: 12px 20px; border-radius: 6px; font-weight: bold; margin-right: 8px;">Book your stay</a>
        <a href="{{ route('contact') }}" style="display: inline-block; border: 2px solid #0048ff; color: #0048ff; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold;">Contact us</a>
    </p>

    <p style="font-size: 13px; color: #666;">If you did not submit this form, you can ignore this email.</p>
</body>
</html>
