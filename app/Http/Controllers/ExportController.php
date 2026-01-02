<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;

class ExportController extends Controller
{
    /**
     * Export courses as JSON
     */
    public function exportCoursesJson()
    {
        $courses = Course::all();
        return response()->json($courses, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Export orders as JSON with relations
     */
    public function exportOrdersJson()
    {
        $orders = Order::with(['user', 'course', 'payment'])->get();
        return response()->json($orders, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Export payments as JSON
     */
    public function exportPaymentsJson()
    {
        $payments = Payment::with(['order', 'order.user', 'order.course'])->get();
        return response()->json($payments, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Export users as JSON
     */
    public function exportUsersJson()
    {
        $users = User::all();
        return response()->json($users, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Export courses as CSV
     */
    public function exportCoursesCsv()
    {
        $courses = Course::all();
        $csv = "ID,Title,Price,Description,Created At\n";
        
        foreach ($courses as $course) {
            $description = str_replace('"', '""', $course->description ?? '');
            $csv .= "{$course->id},\"{$course->title}\",{$course->price},\"{$description}\",{$course->created_at}\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="courses.csv"',
        ]);
    }

    /**
     * Export orders as CSV
     */
    public function exportOrdersCsv()
    {
        $orders = Order::with(['user', 'course'])->get();
        $csv = "ID,User Name,Course,Amount,Status,Created At\n";
        
        foreach ($orders as $order) {
            $csv .= "{$order->id},\"{$order->user->name}\",\"{$order->course->title}\",{$order->amount},{$order->status},{$order->created_at}\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="orders.csv"',
        ]);
    }

    /**
     * Display database viewer dashboard
     */
    public function viewDatabase()
    {
        $stats = [
            'courses' => Course::count(),
            'users' => User::count(),
            'orders' => Order::count(),
            'payments' => Payment::count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
        ];

        return view('admin.database-viewer', [
            'courses' => Course::paginate(10),
            'orders' => Order::with(['user', 'course', 'payment'])->paginate(10),
            'payments' => Payment::with(['order'])->paginate(10),
            'users' => User::paginate(10),
            'stats' => $stats,
        ]);
    }

    /**
     * Get all data as single JSON for easy copying
     */
    public function getAllDataJson()
    {
        $data = [
            'courses' => Course::all(),
            'users' => User::all(),
            'orders' => Order::with(['user', 'course', 'payment'])->get(),
            'payments' => Payment::with(['order'])->get(),
            'stats' => [
                'total_courses' => Course::count(),
                'total_users' => User::count(),
                'total_orders' => Order::count(),
                'total_payments' => Payment::count(),
                'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            ],
            'generated_at' => now()->toDateTimeString(),
        ];

        return response()->json($data, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
