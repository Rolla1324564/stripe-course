# Stripe Test Payment Information

## ✅ Complete Setup Done!

Your Stripe Course Platform is ready to use!

### 📝 Test Card Numbers (Stripe Sandbox Mode)

Use these test card numbers for testing:

1. **Successful Payment:**
   - Card Number: `4242 4242 4242 4242`
   - Expiry: Any future date (e.g., 12/25)
   - CVC: Any 3 digits (e.g., 123)

2. **Card Declined:**
   - Card Number: `4000 0000 0000 0002`
   - Expiry: Any future date
   - CVC: Any 3 digits

3. **Authentication Required:**
   - Card Number: `4000 0025 0000 3155`
   - Expiry: Any future date
   - CVC: Any 3 digits

### 🚀 Access Your Application

- **Base URL:** http://localhost:8000
- **Courses Page:** http://localhost:8000/courses
- **Database:** SQLite (c:\Users\satyam\stripe-course\database\database.sqlite)

### 📋 Sample Courses Loaded

1. **Web Development Mastery** - Coach: Alex Johnson - $99.99
2. **Digital Marketing Fundamentals** - Coach: Martha Williams - $79.99
3. **Mobile App Development** - Coach: Max Chen - $129.99
4. **Data Science & Machine Learning** - Coach: John Smith - $149.99

### 🔐 Stripe Credentials (from .env)

- Public Key: pk_test_51Sk6zH2ax48VzbVb...
- Secret Key: sk_test_51Sk6zH2ax48VzbVb... (configured in .env)

### 📁 Project Structure

```
app/
├── Http/Controllers/
│   ├── CourseController.php      # Course listing
│   └── PaymentController.php     # Payment processing
├── Models/
│   ├── Course.php
│   ├── Order.php
│   └── Payment.php

routes/
└── web.php                       # All routes defined

resources/views/
├── courses/
│   └── index.blade.php          # Course listing with beautiful cards
├── payments/
│   ├── buy-now.blade.php        # Buy for yourself form
│   ├── buy-for-friend.blade.php # Buy for friend form
│   ├── success.blade.php        # Payment success page
│   └── cancel.blade.php         # Payment cancelled page

database/
├── migrations/
│   ├── courses_table
│   ├── orders_table
│   └── payments_table
└── seeders/
    └── CourseSeeder.php         # Sample data

config/
└── services.php                 # Stripe configuration
```

### ✨ Features Implemented

✅ Beautiful responsive course cards with images
✅ Video trailer pop-up modal
✅ Buy Now button for personal purchase
✅ Buy For Friend button with friend details
✅ Complete Stripe payment integration
✅ Payment form validation
✅ Order tracking in database
✅ Payment records with transaction details
✅ Success and cancellation pages
✅ Database normalization with proper relationships
✅ Fully responsive design
✅ Professional UI with gradients and animations

### 🧪 Testing Steps

1. Go to http://localhost:8000/courses
2. Click on any course card
3. Choose "Watch Trailer" to see video modal
4. Click "Buy Now" or "Buy For Friend"
5. Fill the form with test data
6. Use test card: 4242 4242 4242 4242
7. Any future expiry date (e.g., 12/25)
8. Any 3-digit CVC (e.g., 123)
9. Submit and see success page

### 📊 Database Structure

**courses table:**
- id, title, description, thumbnail, coach_name, video_url, price

**orders table:**
- id, course_id (FK), user_id (FK), buyer_name, buyer_email, buyer_phone, buyer_country
- receiver_name, receiver_email, receiver_phone, receiver_country
- total_amount, type (self/friend), status, timestamps

**payments table:**
- id, order_id (FK), stripe_payment_id, card_last4, card_brand, amount, status, response_data

### 🔄 API Routes

- `GET /` → Redirects to /courses
- `GET /courses` → List all courses
- `GET /payment/{course}` → Buy now form
- `GET /payment-friend/{course}` → Buy for friend form
- `POST /process-payment` → Process Stripe payment
- `GET /payment-success/{order}` → Success page
- `GET /payment-cancel` → Cancellation page

### 💡 Tips

- All payments are in TEST mode (no real charges)
- Check database.sqlite in the database folder for stored data
- Logs are in storage/logs folder
- You can modify course data in database using Laravel Tinker

### 🆘 If You Face Issues

1. Server not starting: Make sure port 8000 is free
2. Database error: Run `php artisan migrate:fresh --seed` again
3. Payment not working: Check STRIPE_KEY and STRIPE_SECRET in .env
4. CORS errors: Not applicable as it's a traditional Laravel app

---

**Everything is set up and ready to go! Happy coding! 🎉**
