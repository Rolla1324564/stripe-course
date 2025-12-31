<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-container {
            background: white;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
        }

        .success-icon {
            font-size: 4em;
            margin-bottom: 20px;
            animation: bounce 0.6s;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        h1 {
            color: #28a745;
            margin-bottom: 15px;
            font-size: 2em;
        }

        .message {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .order-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-weight: 600;
        }

        .detail-value {
            color: #333;
            font-weight: 500;
        }

        .payment-info {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .payment-info p {
            color: #2e7d32;
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
            background: #28a745;
            color: white;
        }

        .btn-primary:hover {
            background: #218838;
            transform: scale(1.02);
        }

        .btn-secondary {
            background: #667eea;
            color: white;
        }

        .btn-secondary:hover {
            background: #5568d3;
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
    <div class="success-container">
        <div class="success-icon">✅</div>
        
        <h1>Payment Successful!</h1>
        <p class="message">Thank you for your purchase. Your payment has been processed successfully.</p>

        <div class="order-details">
            <div class="detail-row">
                <span class="detail-label">Order ID:</span>
                <span class="detail-value">#{{ $order->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Course:</span>
                <span class="detail-value">{{ $order->course->title }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Amount Paid:</span>
                <span class="detail-value">${{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Purchase Type:</span>
                <span class="detail-value">{{ ucfirst($order->type) === 'Self' ? 'For Myself' : 'For Friend' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value" style="color: #28a745; font-weight: bold;">✓ Completed</span>
            </div>
        </div>

        @if($order->type === 'friend')
            <div class="payment-info">
                <p>📧 A confirmation email has been sent to:</p>
                <p><strong>{{ $order->receiver_email }}</strong></p>
            </div>
        @else
            <div class="payment-info">
                <p>📧 Confirmation has been sent to your email</p>
            </div>
        @endif

        @if($payment)
            <div class="order-details">
                <div class="detail-row">
                    <span class="detail-label">Payment ID:</span>
                    <span class="detail-value">{{ substr($payment->stripe_payment_id, 0, 10) }}...</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Card Last 4:</span>
                    <span class="detail-value">•••• {{ $payment->card_last4 }}</span>
                </div>
            </div>
        @endif

        <div class="buttons">
            <a href="{{ route('courses.index') }}" class="btn btn-primary">🏠 Back to Courses</a>
        </div>

        <div class="note">
            An email confirmation has been sent to the email address provided. Please check your inbox and spam folder.
        </div>
    </div>
</body>
</html>
