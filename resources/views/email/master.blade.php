<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }
        .email-header {
            background: #FF9F43;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .email-header img {
            max-width: 120px;
        }
        .email-content {
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        .email-footer {
            background: #FF9F43;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            border-top: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            background: #FF9F43;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="email-container">
        
        <!-- Header Section -->
        <div class="email-header">
            <img src="{{ asset('path-to-your-logo.png') }}" alt="Site Logo">
            <h2>{{ config('app.name') }}</h2>
        </div>

        <!-- Content Section -->
        <div class="email-content">
            @yield('content')
        </div>

        <!-- Footer Section -->
        <div class="email-footer">
            <p>Thanks & Regards,</p>
            <p><strong>{{ config('app.name') }}</strong></p>
        </div>

    </div>

</body>
</html>
