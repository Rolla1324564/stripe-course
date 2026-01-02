<?php
/**
 * Quick database test
 */
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Course;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;

echo "\n═══════════════════════════════════════\n";
echo "📊 LOCAL DATABASE STATUS\n";
echo "═══════════════════════════════════════\n\n";

try {
    echo "✅ Courses: " . Course::count() . "\n";
    echo "✅ Users: " . User::count() . "\n";
    echo "✅ Orders: " . Order::count() . "\n";
    echo "✅ Payments: " . Payment::count() . "\n\n";
    echo "✅ Database connection OK!\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "═══════════════════════════════════════\n\n";
