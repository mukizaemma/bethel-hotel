<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $comment->createdBy->name }} Commented on {{ $comment->product->name }}</title>
</head>
<body>
    <h1>New Comment Notification</h1>

    <h2>{{ $details['greeting'] }}</h2>
    <p>{{ $details['body'] }}</p>
    <p>{{ $details['lastline'] }}</p>

    <p>
        <a href="#" target="_blank">Visit My Website</a>
    </p>

</body>
</html>
