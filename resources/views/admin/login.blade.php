<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Stripe Course Platform</title>
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
            display: flex;
            flex-direction: column;
            padding: 0;
        }

        /* Top Navigation */
        .top-nav {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-nav .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #F53003;
            text-decoration: none;
        }

        .top-nav .website-btn {
            background: #667eea;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }

        .top-nav .website-btn:hover {
            background: #5568d3;
        }

        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            padding: 20px;
        }

        .login-container {
            background: white;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 2em;
        }

        .login-header p {
            color: #666;
            font-size: 0.95em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1em;
            transition: border-color 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-top: 10px;
        }

        .login-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .error-message {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .top-nav {
                flex-direction: column;
                gap: 15px;
            }

            .login-container {
                padding: 30px;
            }

            .login-header h1 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation with Website Link -->
    <div class="top-nav">
        <a href="/" class="logo">EduStrike</a>
        <a href="{{ route('courses.index') }}" class="website-btn">🌐 View Website</a>
    </div>

    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h1>🔐 Admin Login</h1>
            <p>Stripe Course Management Dashboard</p>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="Enter admin email">
                    @error('email') <span style="color: #dc3545; font-size: 0.85em;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter password">
                    @error('password') <span style="color: #dc3545; font-size: 0.85em;">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="login-btn">Login to Dashboard</button>
            </form>

            <div style="background: #e7f3ff; border: 1px solid #b3d9ff; color: #0056b3; padding: 15px; border-radius: 6px; margin-top: 30px; font-size: 0.9em;">
                <h4 style="margin-bottom: 10px;">📝 Demo Credentials:</h4>
                <p style="margin-bottom: 5px;"><strong>Email:</strong> admin@stripe.com</p>
                <p style="margin-bottom: 5px;"><strong>Password:</strong> admin123</p>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('courses.index') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">← Back to Courses</a>
            </div>
        </div>
    </div>
</body>
</html>
