# 🗄️ Render SQLite Database - Data Access & Export Guide

## समस्या: Render पर Database Data कहां save है?

Render deployment के बाद, आपका SQLite database यहाँ save होगा:
```
/var/www/html/database/database.sqlite
```

---

## ✅ Solution 1: SSH के through Database Access करें (सबसे आसान)

### Step 1: Render Dashboard में जाओ
1. Render.com login करो
2. अपना **stripe-course** service खोलो
3. **Shell** tab पर click करो

### Step 2: SQLite Database को Access करो

```bash
# SQLite में जाओ
sqlite3 database/database.sqlite

# सभी tables देखो
.tables

# किसी एक table का सारा data देखो
SELECT * FROM courses;
SELECT * FROM orders;
SELECT * FROM payments;
SELECT * FROM users;

# Formatted output के लिए
.mode column
.headers on
SELECT * FROM courses;

# Exit करने के लिए
.quit
```

---

## ✅ Solution 2: Laravel Tinker से Data देखो

```bash
# Render Shell में
php artisan tinker

# फिर command चलाओ:
Course::all()
Order::all()
Payment::all()
User::all()

# Specific data
Course::where('price', '>', 100)->get()
Order::with('user', 'course')->get()
```

---

## ✅ Solution 3: JSON/CSV Format में Export करो

### डाउनलोड के लिए API endpoint बनाओ

#### File: `routes/web.php`
```php
// सभी courses को JSON में export करो
Route::get('/api/export/courses', function () {
    $courses = \App\Models\Course::all();
    return response()->json($courses, 200, [], JSON_PRETTY_PRINT);
});

// सभी orders को JSON में
Route::get('/api/export/orders', function () {
    $orders = \App\Models\Order::with(['user', 'course', 'payment'])->get();
    return response()->json($orders, 200, [], JSON_PRETTY_PRINT);
});

// CSV format में
Route::get('/api/export/courses-csv', function () {
    $courses = \App\Models\Course::all();
    $csv = "ID,Title,Price,Description\n";
    foreach ($courses as $course) {
        $csv .= "{$course->id},{$course->title},{$course->price},\"{$course->description}\"\n";
    }
    return response($csv, 200, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="courses.csv"',
    ]);
});
```

---

## ✅ Solution 4: Local में Database File Download करो

### Option A: Terminal से Direct Download
```bash
# Render Shell में database copy करो memory में
sqlite3 database/database.sqlite ".dump" > /tmp/backup.sql

# फिर Render से download करने के लिए file system expose करो
```

### Option B: Laravel Artisan Command बनाओ

#### File: `app/Console/Commands/ExportDatabase.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportDatabase extends Command
{
    protected $signature = 'db:export-json';
    protected $description = 'Export database to JSON files';

    public function handle()
    {
        $exportDir = storage_path('app/public/exports');
        if (!is_dir($exportDir)) {
            mkdir($exportDir, 0755, true);
        }

        // Export all tables
        $this->exportTable('courses', \App\Models\Course::all(), $exportDir);
        $this->exportTable('orders', \App\Models\Order::with(['user', 'course'])->get(), $exportDir);
        $this->exportTable('payments', \App\Models\Payment::all(), $exportDir);
        $this->exportTable('users', \App\Models\User::all(), $exportDir);

        $this->info('Database exported to storage/app/public/exports/');
        $this->info('Access at: https://stripe-course-1.onrender.com/storage/exports/');
    }

    private function exportTable($name, $data, $dir)
    {
        $file = "{$dir}/{$name}.json";
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->line("✓ Exported {$name}");
    }
}
```

**Use करने के लिए:**
```bash
# Render Shell में
php artisan db:export-json

# फिर files download करो
```

---

## ✅ Solution 5: Beautiful Table Format में देखो

### Terminal में Pretty Print करो

```bash
# Render Shell में
sqlite3 database/database.sqlite

# Column mode enable करो
.mode column
.headers on
.width 5 30 10 50

# फिर query चलाओ
SELECT id, title, price, description FROM courses;

# Result:
# id  title              price  description
# --  ----------------   -----  --------------------------
# 1   Web Development    999    Learn web dev from scratch
# 2   Mobile Dev         1299   Android & iOS development
```

---

## ✅ Solution 6: PHP Script से Data को HTML/Image में Convert करो

#### File: `app/Http/Controllers/ExportController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use Illuminate\Support\Facades\View;

class ExportController extends Controller
{
    // HTML table के रूप में देखो
    public function viewDatabase()
    {
        return view('admin.database-viewer', [
            'courses' => Course::all(),
            'orders' => Order::with(['user', 'course'])->get(),
            'users' => \App\Models\User::all(),
        ]);
    }

    // PDF में export करो
    public function exportPdf()
    {
        $data = [
            'courses' => Course::all(),
            'orders' => Order::with(['user', 'course'])->get(),
        ];
        // Dompdf library use करेंगे
    }
}
```

#### File: `routes/web.php`
```php
Route::get('/admin/database', [\App\Http\Controllers\ExportController::class, 'viewDatabase']);
```

#### File: `resources/views/admin/database-viewer.blade.php`
```blade
<div class="container mt-5">
    <h2>📊 Database Viewer</h2>

    <h3>📚 Courses</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Price</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->title }}</td>
                <td>₹{{ $course->price }}</td>
                <td>{{ $course->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>📦 Orders</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Course</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->course->title }}</td>
                <td>₹{{ $order->amount }}</td>
                <td>{{ $order->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

---

## 🎯 सबसे तेज़ तरीका (Recommended)

### Option 1️⃣: जल्दी JSON में देखो
```bash
# Browser में खोल दो
https://stripe-course-1.onrender.com/api/export/courses
```

### Option 2️⃣: Shell से देखो (सबसे Detailed)
```bash
# Render Dashboard → Shell
sqlite3 database/database.sqlite
.mode column
.headers on
SELECT * FROM courses;
```

### Option 3️⃣: Beautiful Dashboard बनाओ
Add करो `/admin/database` route और सभी data को table में दिखाओ

---

## 🔗 Important Links

| Action | Link |
|--------|------|
| Export Courses JSON | `/api/export/courses` |
| Export Orders JSON | `/api/export/orders` |
| Export as CSV | `/api/export/courses-csv` |
| Admin Dashboard | `/admin/database` |

---

## ❌ अगर Database में कोई data नहीं है?

```bash
# Render Shell में
php artisan migrate:fresh --seed

# या manually seed करो
php artisan db:seed
```

---

## 📱 Mobile/Tablet में देखने के लिए

1. Render पर deployment करो (✓ Done)
2. `/admin/database` खोल दो
3. Responsive design automatically adjust हो जाएगा

---

## 🛠️ Troubleshooting

### Database File नहीं मिल रहा?
```bash
# Check करो कहां है
find /var/www/html -name "*.sqlite" -type f
```

### Data delete हो गया?
```bash
# Fresh migration + seed
php artisan migrate:fresh --seed
```

### Connection Error?
```bash
# Check database permissions
ls -la database/
chmod 777 database/
```

---

## 📝 Next Steps

1. Export APIs add करो (`/api/export/*`)
2. Admin dashboard बनाओ (`/admin/database`)
3. Regular backups setup करो
4. Data visualization charts जोड़ो

