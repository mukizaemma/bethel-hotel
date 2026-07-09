<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .message {
            font-size: 16px;
            line-height: 1.5;
            color: black;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #354e61;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .message-sm {
            font-size: 14px;
            line-height: 1.5;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <p class="message">
            {{ $details['greeting'] }}
        </p>

        <p class="message">
            {{ $details['body'] }}
        </p>

        <hr>
        <p class="message">
            {{ $details['lastline'] }}
        </p>

        <br>

    </div>
</body>

</html>
