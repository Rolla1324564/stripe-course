@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    
    <!-- Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                <div class="card-body p-5">
                    <h1 class="mb-2" style="color: #333; font-weight: 700;">
                        📊 Database Viewer
                    </h1>
                    <p class="text-muted mb-0">Real-time database monitoring & export</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <h6 class="card-title mb-3">📚 Courses</h6>
                    <h3 class="mb-0">{{ $stats['courses'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white">
                    <h6 class="card-title mb-3">👥 Users</h6>
                    <h3 class="mb-0">{{ $stats['users'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-white">
                    <h6 class="card-title mb-3">📦 Orders</h6>
                    <h3 class="mb-0">{{ $stats['orders'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="card-body text-white">
                    <h6 class="card-title mb-3">💰 Revenue</h6>
                    <h3 class="mb-0">₹{{ number_format($stats['total_revenue'], 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3" style="background: rgba(255,255,255,0.95);">
                <div class="card-body p-4">
                    <h5 class="mb-4">⬇️ Export Data</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="btn-group w-100" role="group">
                                <a href="/api/export/courses" class="btn btn-outline-primary" title="Download as JSON">
                                    📄 Courses (JSON)
                                </a>
                                <a href="/api/export/courses-csv" class="btn btn-outline-success" title="Download as CSV">
                                    📊 Courses (CSV)
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="btn-group w-100" role="group">
                                <a href="/api/export/orders" class="btn btn-outline-info" title="Download as JSON">
                                    📦 Orders (JSON)
                                </a>
                                <a href="/api/export/orders-csv" class="btn btn-outline-warning" title="Download as CSV">
                                    📊 Orders (CSV)
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="btn-group w-100" role="group">
                                <a href="/api/export/payments" class="btn btn-outline-danger" title="Download as JSON">
                                    💳 Payments (JSON)
                                </a>
                                <a href="/api/export/users" class="btn btn-outline-secondary" title="Download as JSON">
                                    👥 Users (JSON)
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="/api/export/all" class="btn btn-success w-100" title="Download everything">
                                ⭐ All Data (JSON)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Table -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3" style="background: rgba(255,255,255,0.95);">
                <div class="card-header bg-primary text-white rounded-top-3 border-0 p-4">
                    <h5 class="mb-0">📚 All Courses</h5>
                </div>
                <div class="card-body p-0">
                    @if($courses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                <tr>
                                    <td class="ps-4"><span class="badge bg-primary">{{ $course->id }}</span></td>
                                    <td>
                                        <strong>{{ $course->title }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">₹{{ number_format($course->price, 2) }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($course->description, 40) }}</small>
                                    </td>
                                    <td>
                                        <small class="text-secondary">{{ $course->created_at->format('d M Y') }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $courses->links() }}
                    </div>
                    @else
                    <div class="alert alert-info m-4 mb-0">No courses found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3" style="background: rgba(255,255,255,0.95);">
                <div class="card-header bg-info text-white rounded-top-3 border-0 p-4">
                    <h5 class="mb-0">📦 All Orders</h5>
                </div>
                <div class="card-body p-0">
                    @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>User</th>
                                    <th>Course</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td class="ps-4"><span class="badge bg-info">{{ $order->id }}</span></td>
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                    <td>{{ $order->course->title ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-success">₹{{ number_format($order->amount, 2) }}</span>
                                    </td>
                                    <td>
                                        @if($order->status === 'completed')
                                            <span class="badge bg-success">✓ Completed</span>
                                        @elseif($order->status === 'pending')
                                            <span class="badge bg-warning">⏳ Pending</span>
                                        @elseif($order->status === 'processing')
                                            <span class="badge bg-primary">⚙️ Processing</span>
                                        @else
                                            <span class="badge bg-danger">✗ {{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-secondary">{{ $order->created_at->format('d M Y') }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $orders->links() }}
                    </div>
                    @else
                    <div class="alert alert-info m-4 mb-0">No orders found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3" style="background: rgba(255,255,255,0.95);">
                <div class="card-header bg-success text-white rounded-top-3 border-0 p-4">
                    <h5 class="mb-0">💳 All Payments</h5>
                </div>
                <div class="card-body p-0">
                    @if($payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Order</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Transaction ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <td class="ps-4"><span class="badge bg-success">{{ $payment->id }}</span></td>
                                    <td>Order #{{ $payment->order->id }}</td>
                                    <td>
                                        <span class="badge bg-success">₹{{ number_format($payment->amount, 2) }}</span>
                                    </td>
                                    <td><span class="badge bg-light text-dark">{{ $payment->payment_method }}</span></td>
                                    <td>
                                        @if($payment->status === 'completed')
                                            <span class="badge bg-success">✓ Completed</span>
                                        @elseif($payment->status === 'pending')
                                            <span class="badge bg-warning">⏳ Pending</span>
                                        @else
                                            <span class="badge bg-danger">✗ {{ ucfirst($payment->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-monospace">{{ Str::limit($payment->transaction_id, 15) }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $payments->links() }}
                    </div>
                    @else
                    <div class="alert alert-info m-4 mb-0">No payments found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3" style="background: rgba(255,255,255,0.95);">
                <div class="card-header bg-danger text-white rounded-top-3 border-0 p-4">
                    <h5 class="mb-0">👥 All Users</h5>
                </div>
                <div class="card-body p-0">
                    @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="ps-4"><span class="badge bg-danger">{{ $user->id }}</span></td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>
                                        <small class="text-monospace">{{ $user->email }}</small>
                                    </td>
                                    <td>
                                        <small class="text-secondary">{{ $user->created_at->format('d M Y') }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $users->links() }}
                    </div>
                    @else
                    <div class="alert alert-info m-4 mb-0">No users found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3 bg-warning-light">
                <div class="card-body p-4">
                    <h6 class="mb-3">ℹ️ Quick Links</h6>
                    <ul class="list-unstyled mb-0">
                        <li>✓ All data is automatically synced from SQLite database</li>
                        <li>✓ Use export buttons to download data in JSON or CSV format</li>
                        <li>✓ Pagination shows 10 records per page</li>
                        <li>✓ Last updated: <strong>{{ now()->format('d M Y H:i:s') }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05) !important;
    }

    .rounded-3 {
        border-radius: 1rem !important;
    }

    .rounded-top-3 {
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
    }

    .text-monospace {
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
    }
</style>
@endsection
