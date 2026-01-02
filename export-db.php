<?php
// export-db.php - यह file root में डालें

require 'vendor/autoload.php';
require 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;

$users = DB::table('users')->get();
$courses = DB::table('courses')->get();
$orders = DB::table('orders')->get();
$payments = DB::table('payments')->get();

$data = [
    'users' => $users,
    'courses' => $courses,
    'orders' => $orders,
    'payments' => $payments,
];

file_put_contents('exported_data.json', json_encode($data, JSON_PRETTY_PRINT));

echo "✅ Data exported to exported_data.json\n";
?>
