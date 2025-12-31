<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Courses' }} - Stripe Course Platform</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Navbar Styles */
        nav {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        nav .logo {
            font-size: 1.8em;
            font-weight: bold;
            color: #F53003;
            text-decoration: none;
        }

        nav .nav-menu {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
        }

        nav .nav-menu a {
            text-decoration: none;
            color: #1b1b18;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav .nav-menu a:hover {
            color: #F53003;
        }

        nav .nav-menu a.active {
            color: #F53003;
            border-bottom: 2px solid #F53003;
            padding-bottom: 5px;
        }

        nav .login-btn {
            background: #F53003;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }

        nav .login-btn:hover {
            background: #d41f02;
        }

        @media (max-width: 768px) {
            nav .nav-menu {
                gap: 15px;
                font-size: 0.9em;
            }

            nav .nav-container {
                height: 60px;
            }

            nav .logo {
                font-size: 1.4em;
            }
        }

        .content {
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: white;
            margin-bottom: 50px;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .course-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .course-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3em;
            color: white;
        }

        .course-content {
            padding: 25px;
        }

        .course-title {
            font-size: 1.3em;
            margin-bottom: 10px;
            color: #1b1b18;
        }

        .course-coach {
            color: #706f6c;
            font-size: 0.95em;
            margin-bottom: 10px;
        }

        .course-description {
            color: #706f6c;
            margin-bottom: 15px;
            font-size: 0.95em;
            line-height: 1.5;
        }

        .course-price {
            font-size: 1.5em;
            color: #F53003;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .course-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        button, .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-size: 0.95em;
        }

        .btn-primary {
            background: #F53003;
            color: white;
            flex: 1;
            min-width: 120px;
        }

        .btn-primary:hover {
            background: #d41f02;
            transform: scale(1.05);
        }

        .btn-secondary {
            background: #667eea;
            color: white;
            flex: 1;
            min-width: 120px;
        }

        .btn-secondary:hover {
            background: #5568d3;
            transform: scale(1.05);
        }

        .btn-trailer {
            background: #764ba2;
            color: white;
            flex: 1;
            min-width: 120px;
        }

        .btn-trailer:hover {
            background: #6a3f91;
            transform: scale(1.05);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 12px;
            max-width: 700px;
            width: 90%;
            animation: slideDown 0.3s;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close-modal:hover,
        .close-modal:focus {
            color: #000;
        }

        .modal-video {
            width: 100%;
            aspect-ratio: 16 / 9;
            border-radius: 8px;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 1.8em;
            }

            .courses-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .modal-content {
                width: 95%;
                margin: 10% auto;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <a href="/" class="logo">EduStrike</a>
            <ul class="nav-menu">
                <li><a href="/" class="{{ request()->routeIs('courses.index') ? 'active' : '' }}">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="/" class="{{ request()->routeIs('courses.index') ? 'active' : '' }}">Courses</a></li>
            </ul>
            <a href="{{ route('admin.login') }}" class="login-btn">Login</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content">
        {{ $slot }}
    </div>

    <script>
        function openModal(videoUrl, courseName) {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('trailerVideo');
            iframe.src = videoUrl;
            document.getElementById('modalTitle').textContent = courseName;
            modal.style.display = 'block';
        }

        function closeModal() {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('trailerVideo');
            modal.style.display = 'none';
            iframe.src = '';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('videoModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
