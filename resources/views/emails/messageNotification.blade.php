<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Message Notification</title>
</head>
<body>
    <h1>New Message Notification</h1>

    <p>Hello,</p>
    <p>A new message was sent from the Centre ST Paul website:</p>

    <ul>
        <li><strong>Names:</strong> {{ $message->names }}</li>
        <li><strong>Email:</strong> {{ $message->email }}</li>
        <li><strong>Subject:</strong> {{ $message->subject }}</li>
        <li><strong>Message:</strong></li>
        <p>{{ $message->message }}</p>
    </ul>

    <p>Blessings,</p>
</body>

</html>
