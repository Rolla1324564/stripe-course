<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;

$data = [
    'courses' => Course::all()->toArray(),
    'orders' => Order::with(['user', 'course', 'payment'])->get()->toArray(),
    'payments' => Payment::all()->toArray(),
    'users' => User::all()->toArray(),
];

file_put_contents('exported_data.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "✅ Data exported to exported_data.json\n";
echo "Total Records:\n";
echo "- Courses: " . count($data['courses']) . "\n";
echo "- Orders: " . count($data['orders']) . "\n";
echo "- Payments: " . count($data['payments']) . "\n";
echo "- Users: " . count($data['users']) . "\n";
?>
