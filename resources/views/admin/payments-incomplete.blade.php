@extends('admin.layouts.app')

@section('title', 'Incomplete Payments')
@section('page-title', '❌ Incomplete Payments')

@section('content')
    <div class="payments-summary">
        <div class="summary-card failed">
            <div class="summary-label">Total Failed Amount</div>
            <div class="summary-value">${{ number_format($incompletePayments->sum('amount'), 2) }}</div>
        </div>
        <div class="summary-card failed">
            <div class="summary-label">Number of Failed Transactions</div>
            <div class="summary-value">{{ $incompletePayments->count() }}</div>
        </div>
        <div class="summary-card failed">
            <div class="summary-label">Average Failed Amount</div>
            <div class="summary-value">
                @if($incompletePayments->count() > 0)
                    ${{ number_format($incompletePayments->avg('amount'), 2) }}
                @else
                    $0.00
                @endif
            </div>
        </div>
    </div>

    <div class="payments-card">
        <div class="alert-info">
            <strong>ℹ️ Note:</strong> These are payments that failed due to various reasons (insufficient funds, invalid card, etc.). You may want to reach out to these customers to help complete their purchase.
        </div>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Search by customer name, email, or course...">
        </div>

        @if ($incompletePayments->count() > 0)
            <div class="table-responsive">
                <table id="paymentsTable">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Course</th>
                            <th>Failed Amount</th>
                            <th>Card</th>
                            <th>Failed Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($incompletePayments as $payment)
                            <tr style="background: rgba(220, 53, 69, 0.03);">
                                <td><code>{{ substr($payment->stripe_payment_id, 0, 15) }}...</code></td>
                                <td><strong>{{ $payment->order->buyer_name }}</strong></td>
                                <td>{{ $payment->order->buyer_email }}</td>
                                <td>{{ $payment->order->course->title }}</td>
                                <td><strong style="color: #dc3545;">${{ number_format($payment->amount, 2) }}</strong></td>
                                <td>
                                    <span class="card-badge-failed">
                                        {{ strtoupper($payment->card_brand) }} •••• {{ $payment->card_last4 }}
                                    </span>
                                </td>
                                <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <span class="status-badge status-failed">Failed</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orderDetails', $payment->order->id) }}" class="action-btn">View Order</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-data">
                <p>✅ Great! No failed payments. All payments are successful!</p>
            </div>
        @endif
    </div>

    <style>
        .payments-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #dc3545;
            text-align: center;
        }

        .summary-card.failed {
            border-left-color: #dc3545;
        }

        .summary-label {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .summary-value {
            font-size: 2em;
            font-weight: bold;
            color: #dc3545;
        }

        .alert-info {
            background: #cfe2ff;
            border: 1px solid #b6d4fe;
            color: #084298;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .payments-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 25px;
        }

        .search-box {
            margin-bottom: 25px;
        }

        .search-box input {
            width: 100%;
            max-width: 400px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95em;
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
            background: rgba(220, 53, 69, 0.08) !important;
        }

        code {
            background: #f0f0f0;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85em;
        }

        .card-badge-failed {
            background: #f8d7da;
            color: #721c24;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
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
            color: #28a745;
            font-size: 1.1em;
        }

        @media (max-width: 768px) {
            .payments-summary {
                grid-template-columns: 1fr;
            }

            .search-box input {
                width: 100%;
                max-width: none;
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
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('paymentsTable');
        const rows = table ? table.getElementsByTagName('tbody')[0].getElementsByTagName('tr') : [];

        searchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            Array.from(rows).forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
@endsection
