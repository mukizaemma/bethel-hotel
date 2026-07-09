<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Comment Notification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
    <p style="font-size: 18px; font-weight: bold;">Hello,</p>
    <p style="font-size: 16px;">{{ $comment->names }} has shared a comment on your blog post.</p>

    <h2 style="color: #ad3303;">Comment Details:</h2>
    <ul style="list-style-type: none; padding: 0;">
        <li style="margin: 10px 0;"><strong>Names:</strong> {{ $comment->names }}</li>
        <li style="margin: 10px 0;"><strong>Email:</strong> {{ $comment->email }}</li>
        <li style="margin: 10px 0;"><strong>Comment:</strong></li>
        <li style="margin: 10px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">{{ $comment->comment }}</li>
    </ul>

    <p style="margin-top: 20px;">
        <a href="https://www.Centre ST Paul.org/login" target="_blank" style="background-color: #0048ff; color: #ffffff; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">Confirm or Reject</a>
    </p>
</body>

</html>
