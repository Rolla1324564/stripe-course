<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Stripe Course Platform</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2em;
            font-weight: bold;
        }

        .course-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .course-content {
            padding: 25px;
        }

        .course-title {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .course-coach {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 0.95em;
        }

        .course-description {
            color: #666;
            font-size: 0.95em;
            line-height: 1.5;
            margin-bottom: 20px;
            height: 3em;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .course-price {
            font-size: 1.8em;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .course-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 0.95em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-trailer {
            background: #6c757d;
            color: white;
        }

        .btn-trailer:hover {
            background: #5a6268;
        }

        .btn-buy {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-buy:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-friend {
            background: #28a745;
            color: white;
        }

        .btn-friend:hover {
            background: #218838;
            transform: scale(1.02);
        }

        .video-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .video-modal-content {
            background-color: #000;
            margin: 10% auto;
            padding: 0;
            border: 1px solid #888;
            width: 80%;
            max-width: 800px;
            border-radius: 8px;
            overflow: hidden;
        }

        .video-modal-content video {
            width: 100%;
            height: auto;
            display: block;
        }

        .close-video {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            padding: 10px 20px;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.7);
            position: relative;
            z-index: 10;
        }

        .close-video:hover {
            color: #fff;
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

            h1 {
                font-size: 1.8em;
            }

            .courses-grid {
                grid-template-columns: 1fr;
                gap: 20px;
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
                <li><a href="/" class="active">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="/">Courses</a></li>
            </ul>
            <a href="{{ route('admin.login') }}" class="login-btn">Login</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content">
        <div class="container">
            <h1>🎓 Available Courses</h1>

            @if($courses->isEmpty())
                <div style="text-align: center; color: white; font-size: 1.2em;">
                    No courses available yet.
                </div>
            @else
                <div class="courses-grid">
                    @foreach($courses as $course)
                        <div class="course-card">
                            <div class="course-image">
                                @if($course->thumbnail)
                                    <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}">
                                @else
                                    📚 Course Image
                                @endif
                            </div>
                            <div class="course-content">
                                <h2 class="course-title">{{ $course->title }}</h2>
                                <p class="course-coach">👨‍🏫 Coach: {{ $course->coach_name }}</p>
                                <p class="course-description">{{ $course->description }}</p>
                                <div class="course-price">${{ number_format($course->price, 2) }}</div>

                                <div class="course-buttons">
                                    <button class="btn btn-trailer" onclick="playVideo('{{ $course->id }}')">
                                        ▶️ Watch Trailer
                                    </button>
                                    <a href="{{ route('payment.buy-now', $course->id) }}" class="btn btn-buy">
                                        🛒 Buy Now
                                    </a>
                                    <a href="{{ route('payment.buy-for-friend', $course->id) }}" class="btn btn-friend">
                                        🎁 Buy For Friend
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Video Modal -->
                        <div id="videoModal{{ $course->id }}" class="video-modal">
                            <div class="video-modal-content">
                                <span class="close-video" onclick="closeVideo('{{ $course->id }}')">&times;</span>
                                <video controls>
                                    <source src="{{ $course->video_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        function playVideo(courseId) {
            document.getElementById('videoModal' + courseId).style.display = 'block';
        }

        function closeVideo(courseId) {
            document.getElementById('videoModal' + courseId).style.display = 'none';
            let video = document.querySelector('#videoModal' + courseId + ' video');
            video.pause();
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('video-modal')) {
                event.target.style.display = 'none';
                let video = event.target.querySelector('video');
                if (video) video.pause();
            }
        }
    </script>
</body>
</html>
