<?php
// import-db.php - यह file root में डालें

require 'vendor/autoload.php';
require 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;

$data = json_decode(file_get_contents('exported_data.json'), true);

// Users insert करें
foreach ($data['users'] as $user) {
    DB::table('users')->insert((array)$user);
}

// Courses insert करें
foreach ($data['courses'] as $course) {
    DB::table('courses')->insert((array)$course);
}

// Orders insert करें
foreach ($data['orders'] as $order) {
    DB::table('orders')->insert((array)$order);
}

// Payments insert करें
foreach ($data['payments'] as $payment) {
    DB::table('payments')->insert((array)$payment);
}

echo "✅ Data imported successfully to Render!\n";
?>
