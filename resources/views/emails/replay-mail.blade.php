<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['subject'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            background-color: #c96; /* Fashionistaa Haven's branding color */
            padding: 10px 0;
            border-radius: 10px 10px 0 0;
        }
        .email-header h1 {
            color: #fff;
            font-size: 24px;
            margin: 0;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
        }
        .email-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #aaa;
        }
        .button {
            display: inline-block;
            background-color: #c96;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>Fashionistaa Haven</h1>
    </div>
    <div class="email-body">
        <p>Dear Customer,</p>
        <p>{{ $data['replay'] }}</p>
        <a href="https://fashionistaahaven.com" class="button">Visit Our Store</a>
    </div>
    <div class="email-footer">
        <p>© {{ date('Y') }} Fashionistaa Haven. All rights reserved.</p>
    </div>
</div>
</body>
</html>

