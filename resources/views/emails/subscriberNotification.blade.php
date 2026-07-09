<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Subscriber Notification</title>
</head>
<body>
    <h1>New Subscriber Notification</h1>

    <p>Hello,</p>
    <p>A new subscriber has joined your mailing list. Here are the subscriber details:</p>

    <ul>
        <li><strong>Email:</strong> {{ $subscriber->email }}</li>
    </ul>

    <p>For More Details,</p>

    <p>
        <a href="https://Centre ST Paul.org/login" target="_blank">Login to the Admin to View Subscribers</a>
    </p>

</body>
</html>
