<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New review</title>
</head>
<body style="font-family: Georgia, serif; line-height: 1.6; color: #333; max-width: 560px; margin: 0 auto; padding: 24px;">
    <h1 style="font-size: 20px;">New guest review (pending approval)</h1>
    <p><strong>{{ $review->names }}</strong> — {{ $review->email }}</p>
    <p>Rating: {{ $review->rating }} / 5</p>
    <p style="white-space: pre-wrap;">{{ $review->testimony }}</p>
</body>
</html>
