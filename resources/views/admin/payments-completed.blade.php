@extends('admin.layouts.app')

@section('title', 'Complete Payments')
@section('page-title', '✅ Complete Payments')

@section('content')
    <div class="payments-summary">
        <div class="summary-card">
            <div class="summary-label">Total Completed Payments</div>
            <div class="summary-value">${{ number_format($completedPayments->sum('amount'), 2) }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Number of Transactions</div>
            <div class="summary-value">{{ $completedPayments->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Average Transaction</div>
            <div class="summary-value">
                @if($completedPayments->count() > 0)
                    ${{ number_format($completedPayments->avg('amount'), 2) }}
                @else
                    $0.00
                @endif
            </div>
        </div>
    </div>

    <div class="payments-card">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Search by customer name, email, or course...">
        </div>

        @if ($completedPayments->count() > 0)
            <div class="table-responsive">
                <table id="paymentsTable">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
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
                                <td><code>{{ substr($payment->stripe_payment_id, 0, 15) }}...</code></td>
                                <td><strong>{{ $payment->order->buyer_name }}</strong></td>
                                <td>{{ $payment->order->buyer_email }}</td>
                                <td>{{ $payment->order->course->title }}</td>
                                <td><strong style="color: #28a745;">${{ number_format($payment->amount, 2) }}</strong></td>
                                <td>
                                    <span class="card-badge">
                                        {{ strtoupper($payment->card_brand) }} •••• {{ $payment->card_last4 }}
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
            <div class="no-data">
                <p>No completed payments yet.</p>
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
            border-left: 4px solid #28a745;
            text-align: center;
        }

        .summary-label {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .summary-value {
            font-size: 2em;
            font-weight: bold;
            color: #28a745;
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
            background: #f8f9fa;
        }

        code {
            background: #f0f0f0;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85em;
        }

        .card-badge {
            background: #d4edda;
            color: #155724;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85em;
            font-weight: 600;
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
