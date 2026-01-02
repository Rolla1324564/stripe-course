<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class SyncPullCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull data from Render to localhost every 1 minute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $renderUrl = config('app.render_url', 'https://stripe-course-1.onrender.com');
        $syncToken = env('SYNC_TOKEN', 'super-secret-sync-token-2026');

        $this->info('🔄 [' . now()->format('Y-m-d H:i:s') . '] Pulling data from Render...');

        try {
            // Call Render sync status endpoint to get data
            $response = Http::withHeaders([
                'X-Sync-Token' => $syncToken,
            ])->get("{$renderUrl}/api/sync/status");

            if (!$response->successful()) {
                $this->error('❌ Error: Could not connect to Render');
                return;
            }

            // Parse the response
            $data = $response->json();

            // Sync courses
            if (isset($data['courses'])) {
                foreach ($data['courses'] as $courseData) {
                    Course::updateOrCreate(
                        ['id' => $courseData['id']],
                        $courseData
                    );
                }
                $this->info("   ✅ Synced " . count($data['courses']) . " courses");
            }

            // Sync users
            if (isset($data['users'])) {
                foreach ($data['users'] as $userData) {
                    User::updateOrCreate(
                        ['id' => $userData['id']],
                        $userData
                    );
                }
                $this->info("   ✅ Synced " . count($data['users']) . " users");
            }

            // Sync orders
            if (isset($data['orders'])) {
                foreach ($data['orders'] as $orderData) {
                    Order::updateOrCreate(
                        ['id' => $orderData['id']],
                        $orderData
                    );
                }
                $this->info("   ✅ Synced " . count($data['orders']) . " orders");
            }

            // Sync payments
            if (isset($data['payments'])) {
                foreach ($data['payments'] as $paymentData) {
                    Payment::updateOrCreate(
                        ['id' => $paymentData['id']],
                        $paymentData
                    );
                }
                $this->info("   ✅ Synced " . count($data['payments']) . " payments");
            }

            $this->info('✅ Sync completed successfully!');

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
        }
    }
}
