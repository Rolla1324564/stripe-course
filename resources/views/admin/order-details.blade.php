<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 1.8em;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            padding: 8px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .container {
            padding: 40px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .back-link {
            margin-bottom: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 25px;
        }

        .card-title {
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 20px;
            color: #667eea;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .label {
            font-weight: 600;
            color: #666;
        }

        .value {
            color: #333;
            text-align: right;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
        }

        .payment-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
        }

        .payment-succeeded {
            background: #d4edda;
            color: #155724;
        }

        .payment-pending {
            background: #fff3cd;
            color: #856404;
        }

        .payment-failed {
            background: #f8d7da;
            color: #721c24;
        }

        .divider {
            border-bottom: 1px solid #eee;
            margin: 15px 0;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            flex: 1;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            font-size: 0.95em;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            transform: scale(1.02);
        }

        .btn-warning {
            background: #ffc107;
            color: #333;
        }

        .btn-warning:hover {
            background: #e0a800;
            transform: scale(1.02);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
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

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95em;
        }

        .status-info {
            background: #cfe2ff;
            border: 1px solid #b6d4fe;
            color: #084298;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .status-info p {
            margin: 0;
            font-size: 0.95em;
        }

        .course-info {
            display: flex;
            gap: 20px;
            align-items: start;
        }

        .course-thumbnail {
            width: 150px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .course-details h3 {
            margin-bottom: 10px;
            color: #667eea;
        }

        .course-details p {
            color: #666;
            font-size: 0.9em;
        }

        .payment-details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .payment-details p {
            margin-bottom: 8px;
            font-size: 0.9em;
        }

        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            .course-info {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 Order Details</h1>
        <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="container">
        <div class="back-link">
            <a href="{{ route('admin.dashboard') }}">← Back to Dashboard</a>
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="details-grid">
            <!-- Order Information -->
            <div class="card">
                <div class="card-title">📦 Order Information</div>

                <div class="info-row">
                    <span class="label">Order ID:</span>
                    <span class="value">#{{ $order->id }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Order Type:</span>
                    <span class="value">{{ ucfirst($order->type) }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Order Status:</span>
                    <span class="value">
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </span>
                </div>

                <div class="divider"></div>

                <div class="info-row">
                    <span class="label">Order Date:</span>
                    <span class="value">{{ $order->created_at->format('M d, Y H:i') }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Total Amount:</span>
                    <span class="value"><strong>${{ number_format($order->total_amount, 2) }}</strong></span>
                </div>
            </div>

            <!-- Course Information -->
            <div class="card">
                <div class="card-title">🎓 Course Details</div>

                <div class="course-info">
                    <img src="{{ $order->course->thumbnail }}" alt="{{ $order->course->title }}" class="course-thumbnail">
                    <div class="course-details">
                        <h3>{{ $order->course->title }}</h3>
                        <p><strong>Coach:</strong> {{ $order->course->coach_name }}</p>
                        <p><strong>Price:</strong> ${{ number_format($order->course->price, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Buyer Information -->
            <div class="card">
                <div class="card-title">👤 Buyer Information</div>

                <div class="info-row">
                    <span class="label">Name:</span>
                    <span class="value">{{ $order->buyer_name }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value">{{ $order->buyer_email }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Phone:</span>
                    <span class="value">{{ $order->buyer_phone }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Country:</span>
                    <span class="value">{{ $order->buyer_country }}</span>
                </div>
            </div>

            <!-- Receiver Information (if gift) -->
            @if ($order->type === 'friend')
                <div class="card">
                    <div class="card-title">🎁 Receiver Information</div>

                    <div class="info-row">
                        <span class="label">Name:</span>
                        <span class="value">{{ $order->receiver_name }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Email:</span>
                        <span class="value">{{ $order->receiver_email }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Phone:</span>
                        <span class="value">{{ $order->receiver_phone }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Country:</span>
                        <span class="value">{{ $order->receiver_country }}</span>
                    </div>
                </div>
            @endif

            <!-- Payment Information -->
            <div class="card">
                <div class="card-title">💳 Payment Information</div>

                @if ($order->payment)
                    <div class="info-row">
                        <span class="label">Payment Status:</span>
                        <span class="value">
                            <span class="payment-status payment-{{ $order->payment->status }}">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="label">Payment ID:</span>
                        <span class="value">{{ $order->payment->stripe_payment_id }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Amount Paid:</span>
                        <span class="value">${{ number_format($order->payment->amount, 2) }}</span>
                    </div>

                    <div class="divider"></div>

                    <div class="info-row">
                        <span class="label">Card Brand:</span>
                        <span class="value">{{ ucfirst($order->payment->card_brand) }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Card Last 4:</span>
                        <span class="value">**** **** **** {{ $order->payment->card_last4 }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Payment Date:</span>
                        <span class="value">{{ $order->payment->created_at->format('M d, Y H:i') }}</span>
                    </div>
                @else
                    <p style="color: #dc3545;">No payment information available</p>
                @endif
            </div>

            <!-- Status Update Form -->
            <div class="card full-width">
                <div class="card-title">✏️ Update Order Status</div>

                <form action="{{ route('admin.updateOrderStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="status">Order Status</label>
                        <select name="status" id="status" required>
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Pending - Awaiting Admin Review</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>⚙️ Processing - Admin Verified</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✅ Completed - Order Delivered</option>
                        </select>
                    </div>

                    <div class="status-info">
                        @if($order->status === 'pending')
                            <p><strong>Current:</strong> This order is waiting for admin review. Click "Update Status" to mark it as processing.</p>
                        @elseif($order->status === 'processing')
                            <p><strong>Current:</strong> This order has been verified and is being processed. Mark as completed when delivery is done.</p>
                        @elseif($order->status === 'completed')
                            <p><strong>Current:</strong> ✅ This order has been completed and delivered to the customer.</p>
                        @endif
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-success">Update Status</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
