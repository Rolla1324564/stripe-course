<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .cancel-container {
            background: white;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
        }

        .cancel-icon {
            font-size: 4em;
            margin-bottom: 20px;
        }

        h1 {
            color: #dc3545;
            margin-bottom: 15px;
            font-size: 2em;
        }

        .message {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .error-details {
            background: #f8d7da;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #dc3545;
        }

        .error-details p {
            color: #721c24;
            margin-bottom: 5px;
        }

        .buttons {
            display: flex;
            gap: 15px;
            flex-direction: column;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: scale(1.02);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: scale(1.02);
        }

        .note {
            color: #999;
            font-size: 0.9em;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="cancel-container">
        <div class="cancel-icon">❌</div>
        
        <h1>Payment Cancelled</h1>
        <p class="message">Your payment could not be processed. Please review your details and try again.</p>

        @if(session('error'))
            <div class="error-details">
                <p><strong>Error:</strong> {{ session('error') }}</p>
            </div>
        @endif

        <div class="note">
            💡 Make sure your card details are correct and you have sufficient balance. If the problem persists, please contact your bank.
        </div>

        <div class="buttons">
            <a href="{{ route('courses.index') }}" class="btn btn-primary">← Back to Courses</a>
        </div>
    </div>
</body>
</html>
