# 🎓 Stripe Course Selling Platform - Complete Project Explanation

## Project Overview (प्रोजेक्ट का संक्षिप्त परिचय)

यह एक **Laravel-based E-commerce Platform** है जहाँ:
- **Students** courses खरीद सकते हैं
- **Admin** courses manage कर सकता है
- **Payment Gateway** के रूप में Stripe integrate है
- Orders और Payments को track किया जा सकता है

---

## 📁 Project Structure

```
stripe-course/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CourseController.php      (Courses display के लिए)
│   │   │   ├── PaymentController.php     (Payment processing के लिए)
│   │   │   └── AdminController.php       (Admin operations के लिए)
│   │   └── Middleware/
│   │       └── AdminMiddleware.php       (Admin protection के लिए)
│   └── Models/
│       ├── Course.php                    (Course data)
│       ├── Order.php                     (Customer orders)
│       └── Payment.php                   (Payment records)
├── database/
│   ├── migrations/                       (Database schema)
│   └── seeders/                          (Dummy data)
├── resources/
│   └── views/
│       ├── courses/                      (Course pages)
│       ├── payments/                     (Payment forms)
│       └── admin/                        (Admin dashboard)
├── routes/
│   └── web.php                           (URL routes)
├── config/
│   └── services.php                      (Stripe credentials)
└── .env                                  (Environment variables)
```

---

## 🗄️ DATABASE SCHEMA & MODELS

### 1. **courses Table**
```sql
CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),              -- Course का नाम
    description TEXT,                 -- विस्तृत विवरण
    coach_name VARCHAR(255),          -- सिखाने वाले का नाम
    price DECIMAL(10, 2),             -- कीमत USD में
    thumbnail VARCHAR(255),           -- कोर्स की तस्वीर (URL)
    video_url VARCHAR(255),           -- कोर्स वीडियो (YouTube embed URL)
    created_at TIMESTAMP,             -- बनाने का समय
    updated_at TIMESTAMP
);
```

**Model: Course.php**
```php
class Course extends Model {
    protected $fillable = ['title', 'description', 'coach_name', 'price', 'thumbnail', 'video_url'];
    
    // एक Course के कई Orders हो सकते हैं
    public function orders() {
        return $this->hasMany(Order::class);
    }
}
```

**क्यों बनाया?** ताकि सभी courses को database में store कर सकें और students को display कर सकें।

---

### 2. **orders Table**
```sql
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,                   -- कौन सा course
    buyer_name VARCHAR(255),         -- किसने खरीदा
    buyer_email VARCHAR(255),        -- खरीदार का email
    buyer_phone VARCHAR(20),         -- खरीदार का phone
    buyer_country VARCHAR(100),      -- खरीदार का देश
    receiver_name VARCHAR(255),      -- अगर gift है तो किसको दिया
    receiver_email VARCHAR(255),
    receiver_phone VARCHAR(20),
    receiver_country VARCHAR(100),
    total_amount DECIMAL(10, 2),     -- कुल रकम
    type ENUM('self', 'friend'),     -- अपने लिए या gift?
    status ENUM('pending', 'processing', 'completed'),  -- Order की स्थिति
    created_at TIMESTAMP,
    updated_at TIMESTAMP
};
```

**Model: Order.php**
```php
class Order extends Model {
    protected $fillable = [
        'course_id', 'buyer_name', 'buyer_email', 'buyer_phone', 'buyer_country',
        'receiver_name', 'receiver_email', 'receiver_phone', 'receiver_country',
        'total_amount', 'type', 'status'
    ];
    
    // Order किस Course का है
    public function course() {
        return $this->belongsTo(Course::class);
    }
    
    // Order का Payment record
    public function payment() {
        return $this->hasOne(Payment::class);
    }
}
```

**क्यों बनाया?** हर खरीदारी (order) को track करने के लिए - कौन खरीद रहा है, क्या खरीद रहा है, और क्या payment हुई है।

---

### 3. **payments Table**
```sql
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,                    -- कौन सा order
    stripe_payment_id VARCHAR(255),  -- Stripe का unique ID
    card_last4 VARCHAR(4),           -- Card के आखिरी 4 अंक (e.g., "4242")
    card_brand VARCHAR(50),          -- Card brand (Visa, Mastercard, etc.)
    amount DECIMAL(10, 2),           -- Payment amount
    status ENUM('succeeded', 'failed', 'pending'),  -- Payment status
    response_data JSON,              -- Stripe से पूरा response
    created_at TIMESTAMP,
    updated_at TIMESTAMP
};
```

**Model: Payment.php**
```php
class Payment extends Model {
    protected $fillable = ['order_id', 'stripe_payment_id', 'card_last4', 'card_brand', 'amount', 'status', 'response_data'];
    
    // Payment किस Order का है
    public function order() {
        return $this->belongsTo(Order::class);
    }
}
```

**क्यों बनाया?** Payment की पूरी जानकारी save करने के लिए - Stripe से कौन सी payment ID मिली, card के कौन से आखिरी 4 digit, status क्या है।

---

## 🛣️ ROUTES (URLs कैसे काम करते हैं)

### **routes/web.php**
```php
// HOME
Route::redirect('/', '/courses');

// STUDENT ROUTES (सभी को access)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
                      ↓
                जब user यहाँ आता है, CourseController के index() method को call होता है
                
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
           ↑
           {course} = specific course ID (e.g., /courses/1, /courses/2)

// PAYMENT ROUTES
Route::get('/payment/{course}', [PaymentController::class, 'buyNow'])->name('payment.buy-now');
                                                    ↓
                                    Checkout form display करता है

Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('payment.process');
                                                           ↓
                                        Payment को process करता है

Route::get('/payment-success/{order}', [PaymentController::class, 'success']);
                                                      ↓
                                        Success page display करता है

// ADMIN ROUTES (केवल authenticated admin के लिए)
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/orders', [AdminController::class, 'orders']);
    Route::patch('/admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus']);
    // ... और भी बहुत कुछ
});

// LOGIN ROUTES
Route::get('/admin/login', [AdminController::class, 'loginPage']);
Route::post('/admin/login', [AdminController::class, 'login']);
```

**Routes क्यों जरूरी हैं?**
- Browser में URL enter करने पर कौन सा controller method run हो, यह decide करते हैं।
- SEO के लिए meaningful URLs होते हैं।

---

## 🎮 CONTROLLERS (दिमाग)

### **1. CourseController.php**
```php
class CourseController extends Controller {
    
    // सभी courses को दिखाता है
    public function index(): View {
        $courses = Course::all();  // Database से सभी courses fetch करो
        return view('courses.index', compact('courses'));  // View को भेजो
    }
    
    // एक specific course को दिखाता है
    public function show(Course $course): View {
        return view('courses.show', compact('course'));
    }
}
```

**क्यों?** Student को website खोलने पर सभी courses दिखें।

---

### **2. PaymentController.php**

```php
class PaymentController extends Controller {
    
    public function __construct() {
        Stripe::setApiKey(config('services.stripe.secret'));
        // Stripe को बताता है कि किस secret key से payment process करनी है
    }
    
    // Checkout form दिखाता है
    public function buyNow(Course $course): View {
        return view('payments.buy-now', compact('course'));
    }
    
    // Payment को process करता है (सबसे महत्वपूर्ण!)
    public function processPayment(Request $request): RedirectResponse {
        // 1. Validation - सभी required fields check करो
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'buyer_name' => 'required|string',
            'buyer_email' => 'required|email',
            'stripe_token' => 'required|string',  // Stripe का secure token
            'type' => 'required|in:self,friend',
        ]);
        
        // 2. Course fetch करो
        $course = Course::findOrFail($validated['course_id']);
        
        // 3. Order create करो (अभी pending status में)
        $order = Order::create([
            'course_id' => $course->id,
            'buyer_name' => $validated['buyer_name'],
            'buyer_email' => $validated['buyer_email'],
            'total_amount' => $course->price,
            'type' => $validated['type'],
            'status' => 'pending',  // शुरुआत में pending
        ]);
        
        try {
            // 4. Stripe को payment create करने के लिए कहो
            $charge = \Stripe\Charge::create([
                'amount' => (int)($course->price * 100),  // Cents में (100 = $1)
                'currency' => 'usd',
                'source' => $validated['stripe_token'],   // Student का card token
                'description' => $course->title,
            ]);
            
            // 5. Payment record create करो database में
            Payment::create([
                'order_id' => $order->id,
                'stripe_payment_id' => $charge->id,       // Stripe का unique ID
                'card_last4' => $charge->payment_method_details->card->last4,
                'card_brand' => $charge->payment_method_details->card->brand,
                'amount' => $course->price,
                'status' => $charge->status,  // 'succeeded' या 'failed'
            ]);
            
            // 6. Order status update करो
            if ($charge->status === 'succeeded') {
                $order->update(['status' => 'processing']);  // Admin के लिए
            }
            
            // 7. Success page दिखाओ
            return redirect()->route('payment.success', $order->id);
            
        } catch (\Exception $e) {
            // अगर error आए
            $order->update(['status' => 'failed']);
            return redirect()->route('payment.cancel')->with('error', $e->getMessage());
        }
    }
    
    public function success(Order $order): View {
        return view('payments.success', compact('order'));  // Success message दिखाओ
    }
    
    public function cancel() {
        return view('payments.cancel');  // Error message दिखाओ
    }
}
```

**यह सबसे महत्वपूर्ण है!** क्योंकि यहाँ:
1. Form से data लेते हैं
2. Order create करते हैं
3. Stripe को payment भेजते हैं
4. Payment record save करते हैं

---

### **3. AdminController.php**

```php
class AdminController extends Controller {
    
    // LOGIN PAGE
    public function loginPage(): View {
        return view('admin.login');  // Login form दिखाता है
    }
    
    // LOGIN PROCESS
    public function login(Request $request): RedirectResponse {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        
        // Hardcoded credentials (production में proper auth use करो)
        if ($credentials['email'] === 'admin@stripe.com' && 
            $credentials['password'] === 'admin123') {
            
            session(['admin_logged_in' => true]);  // Session में store करो
            return redirect()->route('admin.dashboard');
        }
        
        return back()->withErrors(['Invalid credentials']);
    }
    
    // DASHBOARD
    public function dashboard(): View {
        $orders = Order::with('course', 'payment')->latest()->get();
        $totalRevenue = Payment::where('status', 'succeeded')->sum('amount');
        $totalOrders = Order::count();
        
        return view('admin.dashboard-new', compact('orders', 'totalRevenue', 'totalOrders'));
    }
    
    // सभी PAGES के लिए similar logic है...
    
    // ORDER STATUS UPDATE (सबसे महत्वपूर्ण!)
    public function updateOrderStatus(Request $request, Order $order): RedirectResponse {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed',
        ]);
        
        $order->update(['status' => $validated['status']]);
        
        return back()->with('success', 'Status updated!');
    }
    
    // LOGOUT
    public function logout(): RedirectResponse {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }
}
```

---

## 🔐 MIDDLEWARE (सुरक्षा गार्ड)

### **app/Http/Middleware/AdminMiddleware.php**

```php
class AdminMiddleware {
    public function handle(Request $request, Closure $next): Response {
        
        // Check करो क्या admin logged in है
        if (!session()->has('admin_logged_in')) {
            return redirect()->route('admin.login')
                   ->with('error', 'Please login first');
        }
        
        // अगर logged in है तो अगले controller को call करो
        return $next($request);
    }
}
```

**क्यों जरूरी है?**
- بिना login के कोई admin pages access न कर सके
- `/admin/dashboard` पर सीधे नहीं जा सकते बिना login के

**कैसे काम करता है?**
1. Browser में `/admin/dashboard` enter करो
2. Middleware check करता है: क्या logged in है?
3. अगर नहीं → login page पर redirect करो
4. अगर हाँ → dashboard दिखाओ

---

## 💳 STRIPE PAYMENT GATEWAY

### **Stripe क्या है?**
एक **third-party payment service** जो credit card payments handle करती है।

### **Why Stripe?**
1. ✅ **PCI Compliant** - कानूनी रूप से सुरक्षित
2. ✅ **Secure** - Stripe servers पर card details जाती हैं, हमारे पास नहीं
3. ✅ **Multiple Payment Methods** - Visa, Mastercard, Amex, etc.
4. ✅ **Easy Integration** - PHP SDK available है

### **Setup कैसे किया?**

#### **Step 1: Stripe Account बनाया**
```
https://dashboard.stripe.com/register
```

#### **Step 2: API Keys लिए**
```
- Publishable Key: pk_test_xxxxx  (Frontend में use करते हैं)
- Secret Key:      sk_test_xxxxx  (Backend में use करते हैं)
```

#### **Step 3: .env में add किया**
```env
STRIPE_KEY=pk_test_xxxxx
STRIPE_SECRET=sk_test_xxxxx
```

#### **Step 4: config/services.php में add किया**
```php
'stripe' => [
    'secret' => env('STRIPE_SECRET'),
    'public' => env('STRIPE_KEY'),
],
```

#### **Step 5: PaymentController में initialize किया**
```php
public function __construct() {
    Stripe::setApiKey(config('services.stripe.secret'));
}
```

---

## 🎫 CARD NUMBERS (Test Cards)

### **Stripe Test Cards:**
```
✅ SUCCESSFUL PAYMENT:
Card Number: 4242 4242 4242 4242
Expiry: Any future date (e.g., 12/25)
CVC: Any 3 digits (e.g., 123)

❌ DECLINED PAYMENT:
Card Number: 4000 0000 0000 0002
Expiry: Any future date
CVC: Any 3 digits
```

### **कैसे काम करता है?**

1. **Student checkout form भरता है:**
   ```
   - Name: John Doe
   - Email: john@example.com
   - Card: 4242 4242 4242 4242
   - Expiry: 12/25
   - CVC: 123
   ```

2. **Frontend में Stripe.js काम करता है:**
   ```javascript
   // Stripe को card details देता है
   stripe.createToken(cardElement).then(function(result) {
       // Stripe एक secure TOKEN देता है
       // यह token ही payment process में भेजा जाता है
       // Card का real data नहीं!
   });
   ```

3. **Backend में processPayment() काम करता है:**
   ```php
   \Stripe\Charge::create([
       'amount' => 9999,  // $99.99
       'currency' => 'usd',
       'source' => $validated['stripe_token'],  // Token (safe!)
       'description' => 'Python Course',
   ]);
   ```

4. **Stripe response देता है:**
   ```php
   {
       "id": "ch_1234567890",
       "status": "succeeded",
       "amount": 9999,
       "card": {
           "brand": "Visa",
           "last4": "4242"
       }
   }
   ```

5. **Database में save करते हैं:**
   ```php
   Payment::create([
       'stripe_payment_id' => 'ch_1234567890',
       'card_last4' => '4242',
       'status' => 'succeeded',
   ]);
   ```

---

## 📄 VIEWS (Frontend Pages)

### **1. courses/index.blade.php**
```
[Logo] [Navbar]
━━━━━━━━━━━━━━━━
Course 1        Course 2        Course 3        Course 4
[Image]         [Image]         [Image]         [Image]
Title           Title           Title           Title
Coach           Coach           Coach           Coach
Price           Price           Price           Price
[Buy Now]       [Buy Now]       [Buy Now]       [Buy Now]
```

**क्या करता है?** सभी courses को सुंदर grid में दिखाता है।

---

### **2. payments/buy-now.blade.php**
```
[Checkout Form]
━━━━━━━━━━━━━━━
Course: Python Basics
Price: $99.99

[Buyer Details]
Name:
Email:
Phone:
Country:

[Card Details - Stripe Hosted]
Card Number: [    4242    4242    4242    4242    ]
Expiry:      [  12 / 25  ]
CVC:         [  123  ]

[Pay Now Button]
```

**क्या करता है?** Payment form दिखाता है और Stripe को card details देता है।

---

### **3. admin/dashboard.blade.php**
```
🎓 Admin Dashboard
━━━━━━━━━━━━━━━━━

[Statistics Cards]
Total Orders: 45
Revenue: $4,500
Completed: 40
Pending: 5

[Recent Orders Table]
| Order ID | Course | Buyer | Amount | Status |
|----------|--------|-------|--------|--------|
| 1        | Python | John  | $99.99 | ✅     |
| 2        | Java   | Jane  | $79.99 | ⏳     |
```

**क्या करता है?** Admin को पूरा overview देता है - कितने orders, revenue, etc.

---

### **4. admin/orders-pending.blade.php**
```
⏳ Pending Orders
━━━━━━━━━━━━━━━

[Summary]
Pending Orders: 5
Total Amount: $499.95
Avg Order Value: $99.99

[Orders Table]
| Order ID | Buyer | Course | Amount | Status | Date |
|----------|-------|--------|--------|--------|------|
| 1        | John  | Python | $99.99 | ⏳     | ... |
| 2        | Jane  | Java   | $79.99 | ⏳     | ... |
```

**क्या करता है?** सभी pending orders को दिखाता है जिन्हें admin को verify करना है।

---

### **5. admin/payments-completed.blade.php**
```
✅ Completed Payments
━━━━━━━━━━━━━━━━━━━

[Summary]
Total Completed: $4,500
Transactions: 45
Avg Transaction: $100

[Payments Table]
| Payment ID | Customer | Course | Amount | Card | Date |
|------------|----------|--------|--------|------|------|
| ch_123... | John     | Python | $99.99 | Visa | ... |
```

**क्या करता है?** सभी successful payments दिखाता है।

---

## 🔄 COMPLETE FLOW (शुरू से अंत तक)

### **1. STUDENT SIDE**
```
Student Website खोलता है
    ↓
CourseController::index() run होता है
    ↓
सभी courses database से fetch होते हैं
    ↓
courses/index.blade.php render होता है
    ↓
Student को सभी courses दिखते हैं
    ↓
Student "Buy Now" पर click करता है
    ↓
PaymentController::buyNow() run होता है
    ↓
payments/buy-now.blade.php दिखता है (form)
    ↓
Student अपनी details भरता है
    ↓
Student "Pay Now" क्लिक करता है
    ↓
Frontend: Stripe.js run होता है
    ↓
Stripe को card details दे कर TOKEN लेता है
    ↓
Form submit होता है ProcessPayment के लिए
    ↓
PaymentController::processPayment() run होता है
    ↓
1. Order create होता है (status = 'pending')
2. Payment create होता है Stripe से
3. अगर successful → Order status = 'processing'
4. अगर failed → Order status = 'failed'
    ↓
Success/Cancel page दिखता है
```

### **2. ADMIN SIDE**
```
Admin /admin/login पर जाता है
    ↓
AdminController::loginPage() run होता है
    ↓
login form दिखता है
    ↓
Admin अपनी credentials भरता है
    ↓
AdminController::login() run होता है
    ↓
Session में 'admin_logged_in' = true set होता है
    ↓
/admin/dashboard पर redirect होता है
    ↓
AdminMiddleware check करता है (logged in है?)
    ↓
हाँ → dashboard दिखाता है
    ↓
Admin को Pending Orders दिखते हैं
    ↓
Admin किसी order पर "View Details" click करता है
    ↓
OrderDetails page खुलता है
    ↓
Admin status dropdown से "Processing" select करता है
    ↓
AdminController::updateOrderStatus() run होता है
    ↓
Order status database में update होता है
    ↓
Sidebar counts automatically update होते हैं
    ↓
Order "Processing Orders" में move हो जाता है
    ↓
Admin अगले दिन order को "Completed" mark करता है
    ↓
सब complete!
```

---

## 📊 DATABASE RELATIONSHIPS (रिश्ते)

```
┌──────────────┐
│   COURSES    │
│   (Product)  │
└──────────────┘
       ↑ (hasMany)
       │
       │ (belongsTo)
       ↓
┌──────────────┐         ┌──────────────┐
│   ORDERS     │────────→│   PAYMENTS   │
│ (Customer's  │ hasOne  │   (Payment   │
│  Purchase)   │←────────│    Record)   │
└──────────────┘ belongsTo└──────────────┘
```

**Relationships:**
1. **Course → Orders**: एक course के कई orders हो सकते हैं
2. **Order → Payment**: एक order का एक ही payment record होता है
3. **Payment → Order**: हर payment एक order से linked है

---

## 🎯 KEY FEATURES (महत्वपूर्ण Features)

### **For Students:**
✅ Courses की list दिखाई देती है  
✅ Video trailer देख सकते हैं  
✅ "Buy Now" या "Buy for Friend" से payment कर सकते हैं  
✅ Secure Stripe payment gateway  
✅ Success/Failure notification  

### **For Admin:**
✅ Complete dashboard with statistics  
✅ Pending/Processing/Completed orders separate pages  
✅ Complete/Incomplete payments track करना  
✅ Users management - कौन खरीद रहे हैं  
✅ Courses CRUD - add/edit/delete  
✅ Order status update करना (Pending → Processing → Completed)  
✅ Real-time sidebar counts  

---

## 🔒 SECURITY MEASURES

1. **Middleware Protection**: Admin routes middleware से protected हैं
2. **Stripe Token**: Card data directly नहीं भेजते, token भेजते हैं
3. **Validation**: सभी inputs को validate करते हैं
4. **Environment Variables**: Sensitive keys .env में हैं
5. **CSRF Protection**: Laravel automatically CSRF tokens add करता है

---

## 📱 RESPONSIVE DESIGN

सभी pages mobile-friendly हैं:
- Grid layout responsive है
- Sidebar mobile में hamburger menu बन जाती है
- Tables responsive हैं
- Forms optimized हैं

---

## 🚀 DEPLOYMENT के लिए TODO:

1. **Stripe Live Keys** लेना
2. **SSL Certificate** लगाना (HTTPS)
3. **Environment Variables** update करना
4. **Email Notifications** add करना
5. **Proper Authentication** (Laravelauth use करना)
6. **Logging** setup करना
7. **Error Handling** improve करना

---

## 📝 SUMMARY

यह एक **complete e-commerce platform** है जहाँ:

| Component | क्या करता है | कहाँ है |
|-----------|------------|---------|
| **Models** | Database से data लेना/देना | app/Models/ |
| **Controllers** | Business logic | app/Http/Controllers/ |
| **Views** | UI/HTML | resources/views/ |
| **Routes** | URLs को controller से link करना | routes/web.php |
| **Middleware** | Access control | app/Http/Middleware/ |
| **Database** | Data storage | migrations/ |
| **Stripe** | Payment processing | PaymentController.php |

---

## 🎓 Learning Points

1. **MVC Pattern**: Model, View, Controller का proper use
2. **RESTful Routing**: /courses/1 जैसे meaningful URLs
3. **Payment Integration**: Third-party service integrate करना
4. **Database Relationships**: hasMany, belongsTo, hasOne
5. **Security**: Middleware, validation, token-based payment
6. **Frontend-Backend**: Form submit → Backend processing
7. **Session Management**: Login/logout functionality
8. **Status Flow**: Pending → Processing → Completed

---

## 🛠️ Development Stack

- **Language**: PHP
- **Framework**: Laravel 11
- **Frontend**: Blade Templates, HTML, CSS, JavaScript
- **Database**: SQLite
- **Payment Gateway**: Stripe
- **Server**: Laravel Development Server
- **Version Control**: Git

---

**Project बनाने का Purpose:**
यह एक practical example है कि कैसे एक real-world e-commerce application बनाते हैं जहाँ:
- Students courses खरीद सकते हैं
- Admin सब manage कर सकता है
- Payments securely process होती हैं
- Orders को track किया जा सकता है

यह project production-ready होने के लिए कुछ improvements चाहिए लेकिन सभी core functionality काम कर रही है! 🚀
