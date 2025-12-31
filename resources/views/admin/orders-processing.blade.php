@extends('admin.layouts.app')

@section('title', 'Processing Orders')
@section('page-title', '⚙️ Processing Orders')

@section('content')
    <div class="orders-summary">
        <div class="summary-card processing">
            <div class="summary-label">Processing Orders</div>
            <div class="summary-value">{{ $processingOrders->count() }}</div>
        </div>
        <div class="summary-card processing">
            <div class="summary-label">Total Processing Amount</div>
            <div class="summary-value">${{ number_format($processingOrders->sum('total_amount'), 2) }}</div>
        </div>
        <div class="summary-card processing">
            <div class="summary-label">Average Order Value</div>
            <div class="summary-value">
                @if($processingOrders->count() > 0)
                    ${{ number_format($processingOrders->avg('total_amount'), 2) }}
                @else
                    $0.00
                @endif
            </div>
        </div>
    </div>

    <div class="orders-card">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Search by buyer name, email, or course...">
        </div>

        @if ($processingOrders->count() > 0)
            <div class="table-responsive">
                <table id="ordersTable">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Buyer Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Order Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($processingOrders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>{{ $order->buyer_name }}</td>
                                <td>{{ $order->buyer_email }}</td>
                                <td>{{ $order->course->title }}</td>
                                <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                <td>
                                    <span class="payment-badge payment-{{ $order->payment->status ?? 'pending' }}">
                                        {{ ucfirst($order->payment->status ?? 'Pending') }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.orderDetails', $order->id) }}" class="action-btn">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-data">
                <p>✅ No processing orders!</p>
            </div>
        @endif
    </div>

    <style>
        .orders-summary {
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
            border-left: 4px solid #17a2b8;
            text-align: center;
        }

        .summary-card.processing {
            border-left-color: #17a2b8;
        }

        .summary-label {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .summary-value {
            font-size: 2em;
            font-weight: bold;
            color: #17a2b8;
        }

        .orders-card {
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

        .payment-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
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

        .action-btn {
            background: #17a2b8;
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
            background: #138496;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #28a745;
            font-size: 1.1em;
        }

        @media (max-width: 768px) {
            .orders-summary {
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
        const table = document.getElementById('ordersTable');
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
