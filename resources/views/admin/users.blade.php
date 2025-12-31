@extends('admin.layouts.app')

@section('title', 'Users Management')
@section('page-title', '👥 Users')

@section('content')
    <div class="users-card">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Search by name, email, or phone...">
        </div>

        @if ($users->count() > 0)
            <div class="table-responsive">
                <table id="usersTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>Total Orders</th>
                            <th>Total Spent</th>
                            <th>Last Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @php
                                $userOrders = $orders->where('buyer_email', $user->email);
                                $totalSpent = $userOrders->sum('total_amount');
                                $lastOrder = $userOrders->sortByDesc('created_at')->first();
                            @endphp
                            <tr>
                                <td><strong>{{ $user->buyer_name }}</strong></td>
                                <td>{{ $user->buyer_email }}</td>
                                <td>{{ $user->buyer_phone }}</td>
                                <td>{{ $user->buyer_country }}</td>
                                <td>
                                    <span class="badge badge-primary">{{ $userOrders->count() }}</span>
                                </td>
                                <td><strong>${{ number_format($totalSpent, 2) }}</strong></td>
                                <td>
                                    @if ($lastOrder)
                                        {{ $lastOrder->created_at->format('M d, Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="action-btn" onclick="showUserOrders('{{ $user->buyer_email }}')">View Orders</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-data">
                <p>No users found yet.</p>
            </div>
        @endif
    </div>

    <!-- Modal for User Orders -->
    <div id="userOrdersModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">User Orders</h2>
            <div id="modalBody"></div>
        </div>
    </div>

    <style>
        .users-card {
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

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .badge-primary {
            background: #d4edda;
            color: #155724;
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

        /* Modal Styles */
        .modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
            width: 90%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }

        .close:hover,
        .close:focus {
            color: #000;
        }

        #modalTitle {
            color: #667eea;
            margin-bottom: 20px;
        }

        .modal-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .modal-table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e0e0e0;
        }

        .modal-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        .modal-table tr:hover {
            background: #f8f9fa;
        }

        @media (max-width: 768px) {
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

            .modal-content {
                width: 95%;
                max-height: 90vh;
            }
        }
    </style>

    <script>
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('usersTable');
        const rows = table ? table.getElementsByTagName('tbody')[0].getElementsByTagName('tr') : [];

        searchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            Array.from(rows).forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        function showUserOrders(email) {
            const orders = @json($orders);
            const userOrders = orders.filter(order => order.buyer_email === email);
            
            let html = '<table class="modal-table"><thead><tr><th>Order ID</th><th>Course</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead><tbody>';
            
            userOrders.forEach(order => {
                const statusColor = order.status === 'completed' ? '#155724' : 
                                   order.status === 'pending' ? '#856404' : '#721c24';
                html += `
                    <tr>
                        <td>#${order.id}</td>
                        <td>${order.course.title}</td>
                        <td>$${order.total_amount.toFixed(2)}</td>
                        <td><span style="background: ${statusColor}20; color: ${statusColor}; padding: 6px 12px; border-radius: 20px; font-size: 0.85em; font-weight: 600;">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></td>
                        <td>${new Date(order.created_at).toLocaleDateString()}</td>
                    </tr>
                `;
            });
            
            html += '</tbody></table>';
            
            document.getElementById('modalTitle').textContent = `Orders for ${email}`;
            document.getElementById('modalBody').innerHTML = html;
            document.getElementById('userOrdersModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('userOrdersModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('userOrdersModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
@endsection
