<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SyncController extends Controller
{
    /**
     * Push localhost data to Render (Live)
     * Yeh localhost se Render ko update karega
     */
    public function pushToRender(Request $request)
    {
        // Security check - token verify करो
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $data = $request->json()->all();
            
            // Courses sync करो
            if (isset($data['courses'])) {
                foreach ($data['courses'] as $course) {
                    Course::updateOrCreate(
                        ['id' => $course['id']],
                        $course
                    );
                }
            }

            // Users sync करो
            if (isset($data['users'])) {
                foreach ($data['users'] as $user) {
                    User::updateOrCreate(
                        ['id' => $user['id']],
                        [
                            'name' => $user['name'],
                            'email' => $user['email'],
                            // password न change करो security के लिए
                        ]
                    );
                }
            }

            // Orders sync करो
            if (isset($data['orders'])) {
                foreach ($data['orders'] as $order) {
                    Order::updateOrCreate(
                        ['id' => $order['id']],
                        $order
                    );
                }
            }

            // Payments sync करो
            if (isset($data['payments'])) {
                foreach ($data['payments'] as $payment) {
                    Payment::updateOrCreate(
                        ['id' => $payment['id']],
                        $payment
                    );
                }
            }

            return response()->json([
                'success' => true,
                'message' => '✅ Data synced to Render successfully!',
                'synced' => [
                    'courses' => count($data['courses'] ?? []),
                    'users' => count($data['users'] ?? []),
                    'orders' => count($data['orders'] ?? []),
                    'payments' => count($data['payments'] ?? []),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => '❌ Sync failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Pull Render data to Localhost
     * Yeh Render se localhost ko update karega
     */
    public function pullFromRender(Request $request)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            // Live database से सभी data लो
            $data = [
                'courses' => Course::all()->toArray(),
                'users' => User::all()->toArray(),
                'orders' => Order::all()->toArray(),
                'payments' => Payment::all()->toArray(),
            ];

            return response()->json([
                'success' => true,
                'message' => '✅ Data pulled from Render',
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => '❌ Pull failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get Sync Status
     * Check करो कि data कितना है Render पर
     */
    public function status()
    {
        return response()->json([
            'status' => 'Connected to Render Database',
            'data_count' => [
                'courses' => Course::count(),
                'users' => User::count(),
                'orders' => Order::count(),
                'payments' => Payment::count(),
            ],
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'timestamp' => now(),
        ]);
    }

    /**
     * Delete all data (Careful!)
     */
    public function deleteAll(Request $request)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            DB::statement('DELETE FROM payments');
            DB::statement('DELETE FROM orders');
            DB::statement('DELETE FROM courses');
            DB::statement('DELETE FROM users');

            return response()->json([
                'success' => true,
                'message' => '🗑️ All data deleted from Render database',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Reset और Seed करो
     */
    public function resetAndSeed(Request $request)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            // Delete all
            DB::statement('DELETE FROM payments');
            DB::statement('DELETE FROM orders');
            DB::statement('DELETE FROM courses');
            DB::statement('DELETE FROM users');

            // Seed करो
            \Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);

            return response()->json([
                'success' => true,
                'message' => '🔄 Database reset and seeded successfully!',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Token Verification
     */
    private function verifyToken(Request $request)
    {
        $token = $request->header('X-Sync-Token');
        $validToken = env('SYNC_TOKEN', 'your-secret-token-here');
        
        return $token === $validToken;
    }
}
