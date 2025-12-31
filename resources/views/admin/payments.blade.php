@extends('admin.layouts.app')

@section('title', 'Payments Management')
@section('page-title', '💳 Payments')

@section('content')
    <div class="payment-tabs">
        <button class="tab-btn active" data-tab="all">All Payments ({{ $allPayments->count() }})</button>
        <button class="tab-btn" data-tab="completed">✅ Completed ({{ $completedPayments->count() }})</button>
        <button class="tab-btn" data-tab="failed">❌ Failed ({{ $failedPayments->count() }})</button>
    </div>

    <!-- All Payments Tab -->
    <div id="all" class="tab-content active">
        <div class="payment-card">
            <div class="card-title">All Transactions</div>

            @if ($allPayments->count() > 0)
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Order ID</th>
                                <th>Buyer Name</th>
                                <th>Course</th>
                                <th>Amount</th>
                                <th>Card</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allPayments as $payment)
                                <tr>
                                    <td><code>{{ substr($payment->stripe_payment_id, 0, 20) }}...</code></td>
                                    <td>#{{ $payment->order->id }}</td>
                                    <td>{{ $payment->order->buyer_name }}</td>
                                    <td>{{ $payment->order->course->title }}</td>
                                    <td><strong>${{ number_format($payment->amount, 2) }}</strong></td>
                                    <td>{{ strtoupper($payment->card_brand) }} **** {{ $payment->card_last4 }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $payment->status }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orderDetails', $payment->order->id) }}" class="action-btn">View Order</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="no-data">No payments found.</div>
            @endif
        </div>
    </div>

    <!-- Completed Payments Tab -->
    <div id="completed" class="tab-content">
        <div class="payment-card">
            <div class="card-title">✅ Completed Payments</div>

            @if ($completedPayments->count() > 0)
                <div class="summary">
                    <div class="summary-item">
                        <span class="summary-label">Total Completed Payments:</span>
                        <span class="summary-value">${{ number_format($completedPayments->sum('amount'), 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Number of Transactions:</span>
                        <span class="summary-value">{{ $completedPayments->count() }}</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Order ID</th>
                                <th>Buyer Name</th>
                                <th>Course</th>
                                <th>Amount</th>
                                <th>Card</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($completedPayments as $payment)
                                <tr>
                                    <td><code>{{ substr($payment->stripe_payment_id, 0, 20) }}...</code></td>
                                    <td>#{{ $payment->order->id }}</td>
                                    <td>{{ $payment->order->buyer_name }}</td>
                                    <td>{{ $payment->order->course->title }}</td>
                                    <td><strong>${{ number_format($payment->amount, 2) }}</strong></td>
                                    <td>{{ strtoupper($payment->card_brand) }} **** {{ $payment->card_last4 }}</td>
                                    <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orderDetails', $payment->order->id) }}" class="action-btn">View Order</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="no-data">No completed payments yet.</div>
            @endif
        </div>
    </div>

    <!-- Failed Payments Tab -->
    <div id="failed" class="tab-content">
        <div class="payment-card">
            <div class="card-title">❌ Failed Payments</div>

            @if ($failedPayments->count() > 0)
                <div class="summary">
                    <div class="summary-item">
                        <span class="summary-label">Total Failed Amount:</span>
                        <span class="summary-value" style="color: #dc3545;">${{ number_format($failedPayments->sum('amount'), 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Number of Failed Transactions:</span>
                        <span class="summary-value" style="color: #dc3545;">{{ $failedPayments->count() }}</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Order ID</th>
                                <th>Buyer Name</th>
                                <th>Course</th>
                                <th>Amount</th>
                                <th>Card</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($failedPayments as $payment)
                                <tr style="background: rgba(220, 53, 69, 0.05);">
                                    <td><code>{{ substr($payment->stripe_payment_id, 0, 20) }}...</code></td>
                                    <td>#{{ $payment->order->id }}</td>
                                    <td>{{ $payment->order->buyer_name }}</td>
                                    <td>{{ $payment->order->course->title }}</td>
                                    <td><strong>${{ number_format($payment->amount, 2) }}</strong></td>
                                    <td>{{ strtoupper($payment->card_brand) }} **** {{ $payment->card_last4 }}</td>
                                    <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orderDetails', $payment->order->id) }}" class="action-btn">View Order</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="no-data">No failed payments.</div>
            @endif
        </div>
    </div>

    <style>
        .payment-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 12px 20px;
            border: 2px solid #ddd;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }

        .tab-btn:hover {
            border-color: #667eea;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .payment-card {
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

        .summary {
            display: flex;
            gap: 30px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .summary-item {
            display: flex;
            flex-direction: column;
        }

        .summary-label {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 1.5em;
            font-weight: bold;
            color: #667eea;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e0e0e0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        tr:hover {
            background: #f8f9fa;
        }

        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 0.85em;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .status-succeeded {
            background: #d4edda;
            color: #155724;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .action-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
            font-weight: 600;
            font-size: 0.9em;
            transition: background 0.3s;
        }

        .action-btn:hover {
            background: #764ba2;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        @media (max-width: 768px) {
            .payment-tabs {
                flex-direction: column;
            }

            .tab-btn {
                width: 100%;
            }

            .summary {
                flex-direction: column;
                gap: 15px;
            }

            table {
                font-size: 0.9em;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>

    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all tabs and buttons
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.classList.remove('active');
                });
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active');
                });

                // Add active class to clicked button and corresponding tab
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>
@endsection
