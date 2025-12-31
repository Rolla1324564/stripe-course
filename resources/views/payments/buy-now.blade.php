<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase - {{ $course->title }}</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #333;
            margin-bottom: 10px;
        }

        .course-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }

        .course-info p {
            color: #666;
            margin-bottom: 8px;
        }

        .course-info strong {
            color: #333;
        }

        .price-display {
            font-size: 1.5em;
            color: #667eea;
            font-weight: bold;
            text-align: center;
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

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1em;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        #card-element {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1em;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .error {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .loading {
            display: none;
            text-align: center;
            color: #667eea;
            margin: 20px 0;
        }

        h3 {
            margin-top: 30px;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛒 Complete Your Purchase</h1>
            <p style="color: #666;">Secure Payment with Stripe</p>
        </div>

        <div class="course-info">
            <p><strong>Course:</strong> {{ $course->title }}</p>
            <p><strong>Coach:</strong> {{ $course->coach_name }}</p>
            <div class="price-display">${{ number_format($course->price, 2) }}</div>
        </div>

        @if ($errors->any())
            <div style="background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                <strong style="color: #721c24;">Errors:</strong>
                <ul style="color: #721c24; margin-top: 10px; margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="payment-form" action="{{ route('payment.process') }}" method="POST">
            @csrf

            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="type" value="self">
            <input type="hidden" id="stripe_token" name="stripe_token" value="">

            <h3>👤 Personal Information</h3>

            <div class="form-group">
                <label for="buyer_name">Full Name *</label>
                <input type="text" id="buyer_name" name="buyer_name" required value="{{ old('buyer_name') }}">
                @error('buyer_name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="buyer_email">Email Address *</label>
                <input type="email" id="buyer_email" name="buyer_email" required value="{{ old('buyer_email') }}">
                @error('buyer_email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="buyer_phone">Phone Number *</label>
                    <input type="tel" id="buyer_phone" name="buyer_phone" required value="{{ old('buyer_phone') }}">
                    @error('buyer_phone') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="buyer_country">Country *</label>
                    <select id="buyer_country" name="buyer_country" required>
                        <option value="">Select country</option>
                        <option value="United States" {{ old('buyer_country') == 'United States' ? 'selected' : '' }}>United States</option>
                        <option value="Canada" {{ old('buyer_country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                        <option value="United Kingdom" {{ old('buyer_country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                        <option value="Australia" {{ old('buyer_country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                        <option value="India" {{ old('buyer_country') == 'India' ? 'selected' : '' }}>India</option>
                        <option value="Germany" {{ old('buyer_country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                        <option value="France" {{ old('buyer_country') == 'France' ? 'selected' : '' }}>France</option>
                    </select>
                    @error('buyer_country') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <h3>💳 Payment Details</h3>

            <div class="form-group">
                <label for="card-element">Card Information *</label>
                <div id="card-element"></div>
                <div id="card-errors" class="error"></div>
            </div>

            <div id="loading" class="loading">
                <p>Processing your payment...</p>
            </div>

            <button type="submit" id="submit-btn" class="submit-btn">💰 Complete Purchase - ${{ number_format($course->price, 2) }}</button>
        </form>

        <div class="back-link">
            <a href="{{ route('courses.index') }}">← Back to Courses</a>
        </div>
    </div>

    <script>
        const stripe = Stripe('{{ config("services.stripe.key") }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        cardElement.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            const submitBtn = document.getElementById('submit-btn');
            const loading = document.getElementById('loading');
            const cardErrors = document.getElementById('card-errors');

            submitBtn.disabled = true;
            loading.style.display = 'block';

            try {
                const {token, error} = await stripe.createToken(cardElement);

                if (error) {
                    cardErrors.textContent = error.message;
                    submitBtn.disabled = false;
                    loading.style.display = 'none';
                } else {
                    document.getElementById('stripe_token').value = token.id;
                    form.submit();
                }
            } catch (err) {
                cardErrors.textContent = 'An error occurred. Please try again.';
                submitBtn.disabled = false;
                loading.style.display = 'none';
            }
        });
    </script>
</body>
</html>
