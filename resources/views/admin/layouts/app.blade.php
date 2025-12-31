<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Stripe Course Platform</title>
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

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
        }

        .sidebar-header h2 {
            font-size: 1.5em;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 0.85em;
            opacity: 0.9;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
            font-weight: 500;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.25);
            border-left: 4px solid #fff;
            padding-left: 16px;
        }

        .sidebar-menu .icon {
            margin-right: 12px;
            font-size: 1.2em;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            list-style: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .dropdown-menu.show {
            max-height: 500px;
        }

        .dropdown-menu a {
            padding-left: 60px !important;
            font-size: 0.9em;
            opacity: 0.9;
        }

        .dropdown-toggle::after {
            content: '▼';
            margin-left: auto;
            font-size: 0.8em;
            transition: transform 0.3s;
        }

        .dropdown-toggle.show::after {
            transform: rotate(-180deg);
        }

        .sidebar-logout {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid rgba(255, 255, 255, 0.2);
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: white;
            padding: 20px 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 1.8em;
            color: #333;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            text-align: right;
        }

        .user-info p {
            font-size: 0.9em;
            color: #666;
        }

        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #c82333;
        }

        .content {
            padding: 40px;
            flex: 1;
            overflow-y: auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
                margin-left: -250px;
                transition: margin-left 0.3s;
            }

            .sidebar.open {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .header {
                padding: 15px 20px;
            }

            .header h1 {
                font-size: 1.4em;
            }

            .content {
                padding: 20px;
            }

            .toggle-sidebar-btn {
                display: block;
            }
        }

        .toggle-sidebar-btn {
            display: none;
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.2em;
        }

        /* Success Message */
        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        /* Error Message */
        .error-message {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2>🎓 Admin</h2>
                <p>Course Platform</p>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName() == 'admin.dashboard') active @endif">
                        <span class="icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle" id="ordersToggle">
                        <span class="icon">📦</span>
                        <span>Orders</span>
                    </a>
                    <ul class="dropdown-menu" id="ordersMenu">
                        <li>
                            <a href="{{ route('admin.orders') }}">
                                <span>All Orders</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.orders.pending') }}">
                                <span>⏳ Pending ({{ $pendingCount ?? 0 }})</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.orders.processing') }}">
                                <span>⚙️ Processing ({{ $processingCount ?? 0 }})</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle" id="paymentsToggle">
                        <span class="icon">💳</span>
                        <span>Payments</span>
                    </a>
                    <ul class="dropdown-menu" id="paymentsMenu">
                        <li>
                            <a href="{{ route('admin.payments.completed') }}">
                                <span>✅ Complete Payments</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.payments.incomplete') }}">
                                <span>❌ Incomplete Payments</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle" id="inventoryToggle">
                        <span class="icon">📚</span>
                        <span>Inventory</span>
                    </a>
                    <ul class="dropdown-menu" id="inventoryMenu">
                        <li>
                            <a href="{{ route('admin.courses.index') }}">
                                <span>View Courses</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.courses.create') }}">
                                <span>Add Course</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.users') }}" class="@if(Route::currentRouteName() == 'admin.users') active @endif">
                        <span class="icon">👥</span>
                        <span>Users</span>
                    </a>
                </li>

                <li class="sidebar-logout">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn" style="width: 100%; background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: white;">
                            <span style="margin-right: 10px;">🚪</span>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <button class="toggle-sidebar-btn" id="toggleSidebar">☰</button>
                <h1>@yield('page-title')</h1>
                <div class="header-actions">
                    <div class="user-info">
                        <p>👤 {{ session('admin_email') }}</p>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="content">
                @if (session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="error-message">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Sidebar toggle for mobile
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
        });

        // Orders dropdown
        document.getElementById('ordersToggle').addEventListener('click', function(e) {
            e.preventDefault();
            const menu = document.getElementById('ordersMenu');
            const toggle = this;
            menu.classList.toggle('show');
            toggle.classList.toggle('show');
        });

        // Inventory dropdown
        document.getElementById('inventoryToggle').addEventListener('click', function(e) {
            e.preventDefault();
            const menu = document.getElementById('inventoryMenu');
            const toggle = this;
            menu.classList.toggle('show');
            toggle.classList.toggle('show');
        });

        // Payments dropdown
        document.getElementById('paymentsToggle').addEventListener('click', function(e) {
            e.preventDefault();
            const menu = document.getElementById('paymentsMenu');
            const toggle = this;
            menu.classList.toggle('show');
            toggle.classList.toggle('show');
        });

        // Close sidebar when clicking on a link (mobile)
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.sidebar a').forEach(link => {
                link.addEventListener('click', function() {
                    document.getElementById('sidebar').classList.remove('open');
                });
            });
        }
    </script>
</body>
</html>
