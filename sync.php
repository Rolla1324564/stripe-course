<?php
/**
 * Sync Script - Localhost से Render को update करने के लिए
 * 
 * Usage:
 * php sync.php push    - localhost data को Render को भेज दो
 * php sync.php pull    - Render data को localhost में लाओ
 * php sync.php status  - Check करो sync status
 */

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Http;

// Render URL (अपने URL से replace करो)
$RENDER_URL = 'https://stripe-course-1.onrender.com';
$SYNC_TOKEN = env('SYNC_TOKEN', 'super-secret-sync-token-2026');

class DataSync
{
    private $render_url;
    private $token;

    public function __construct($url, $token)
    {
        $this->render_url = $url;
        $this->token = $token;
    }

    /**
     * Localhost से data लो और Render को भेज दो
     */
    public function push()
    {
        echo "\n📤 Pushing localhost data to Render...\n";

        $data = [
            'courses' => Course::all()->toArray(),
            'users' => User::all()->toArray(),
            'orders' => Order::all()->toArray(),
            'payments' => Payment::all()->toArray(),
        ];

        try {
            $response = Http::withHeaders([
                'X-Sync-Token' => $this->token,
                'Content-Type' => 'application/json',
            ])->post("{$this->render_url}/api/sync/push", $data);

            if ($response->successful()) {
                $result = $response->json();
                echo "\n✅ SUCCESS!\n";
                echo "- Courses: " . $result['synced']['courses'] . "\n";
                echo "- Users: " . $result['synced']['users'] . "\n";
                echo "- Orders: " . $result['synced']['orders'] . "\n";
                echo "- Payments: " . $result['synced']['payments'] . "\n";
            } else {
                echo "\n❌ Error: " . $response->body() . "\n";
            }

        } catch (\Exception $e) {
            echo "\n❌ Failed: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Render से data लो और localhost में update करो
     */
    public function pull()
    {
        echo "\n📥 Pulling data from Render...\n";

        try {
            $response = Http::withHeaders([
                'X-Sync-Token' => $this->token,
            ])->get("{$this->render_url}/api/sync/pull");

            if ($response->successful()) {
                $result = $response->json();
                $data = $result['data'];

                // Update करो
                if (isset($data['courses'])) {
                    foreach ($data['courses'] as $course) {
                        Course::updateOrCreate(
                            ['id' => $course['id']],
                            $course
                        );
                    }
                }

                if (isset($data['users'])) {
                    foreach ($data['users'] as $user) {
                        User::updateOrCreate(
                            ['id' => $user['id']],
                            ['name' => $user['name'], 'email' => $user['email']]
                        );
                    }
                }

                if (isset($data['orders'])) {
                    foreach ($data['orders'] as $order) {
                        Order::updateOrCreate(
                            ['id' => $order['id']],
                            $order
                        );
                    }
                }

                if (isset($data['payments'])) {
                    foreach ($data['payments'] as $payment) {
                        Payment::updateOrCreate(
                            ['id' => $payment['id']],
                            $payment
                        );
                    }
                }

                echo "\n✅ SUCCESS!\n";
                echo "- Courses: " . count($data['courses']) . "\n";
                echo "- Users: " . count($data['users']) . "\n";
                echo "- Orders: " . count($data['orders']) . "\n";
                echo "- Payments: " . count($data['payments']) . "\n";

            } else {
                echo "\n❌ Error: " . $response->body() . "\n";
            }

        } catch (\Exception $e) {
            echo "\n❌ Failed: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Check करो sync status
     */
    public function status()
    {
        echo "\n📊 Checking Render database status...\n";

        try {
            $response = Http::get("{$this->render_url}/api/sync/status");

            if ($response->successful()) {
                $data = $response->json();
                echo "\n✅ Connected to Render!\n";
                echo "- Courses: " . $data['data_count']['courses'] . "\n";
                echo "- Users: " . $data['data_count']['users'] . "\n";
                echo "- Orders: " . $data['data_count']['orders'] . "\n";
                echo "- Payments: " . $data['data_count']['payments'] . "\n";
                echo "- Total Revenue: ₹" . $data['total_revenue'] . "\n";
            } else {
                echo "\n❌ Error: " . $response->body() . "\n";
            }

        } catch (\Exception $e) {
            echo "\n❌ Failed: " . $e->getMessage() . "\n";
        }
    }
}

// Main Logic
$command = $argv[1] ?? 'help';
$sync = new DataSync($RENDER_URL, $SYNC_TOKEN);

echo "\n═════════════════════════════════════════";
echo "\n   🔄 STRIPE COURSE - DATA SYNC";
echo "\n═════════════════════════════════════════\n";

switch ($command) {
    case 'push':
        $sync->push();
        break;
    case 'pull':
        $sync->pull();
        break;
    case 'status':
        $sync->status();
        break;
    default:
        echo "\n📖 Usage:\n";
        echo "  php sync.php push     - Push localhost data to Render\n";
        echo "  php sync.php pull     - Pull Render data to localhost\n";
        echo "  php sync.php status   - Check Render database status\n\n";
}

echo "\n═════════════════════════════════════════\n";
?>
