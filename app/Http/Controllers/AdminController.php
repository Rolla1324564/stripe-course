<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    // Login page
    public function loginPage(): View
    {
        return view('admin.login');
    }

    // Handle login
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Simple hardcoded admin credentials (in production, use proper authentication)
        if ($credentials['email'] === 'admin@stripe.com' && $credentials['password'] === 'admin123') {
            session(['admin_logged_in' => true, 'admin_email' => $credentials['email']]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Dashboard
    public function dashboard(): View
    {
        $orders = Order::with('course', 'payment')->latest()->get();
        $totalRevenue = Payment::where('status', 'succeeded')->sum('amount');
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();

        return view('admin.dashboard-new', compact('orders', 'totalRevenue', 'totalOrders', 'completedOrders'));
    }

    // Orders page
    public function orders(): View
    {
        $orders = Order::with('course', 'payment')->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    // Pending Orders
    public function ordersPending(): View
    {
        $pendingOrders = Order::where('status', 'pending')
            ->with('course', 'payment')
            ->latest()
            ->get();
        
        return view('admin.orders-pending', compact('pendingOrders'));
    }

    // Processing Orders
    public function ordersProcessing(): View
    {
        $processingOrders = Order::where('status', 'processing')
            ->with('course', 'payment')
            ->latest()
            ->get();
        
        return view('admin.orders-processing', compact('processingOrders'));
    }

    // Payments page (All)
    public function payments(): View
    {
        $allPayments = Payment::with('order.course')->latest()->get();
        $completedPayments = Payment::where('status', 'succeeded')->with('order.course')->latest()->get();
        $failedPayments = Payment::where('status', 'failed')->with('order.course')->latest()->get();

        return view('admin.payments', compact('allPayments', 'completedPayments', 'failedPayments'));
    }

    // Completed Payments
    public function paymentsCompleted(): View
    {
        $completedPayments = Payment::where('status', 'succeeded')
            ->with('order.course')
            ->latest()
            ->get();

        return view('admin.payments-completed', compact('completedPayments'));
    }

    // Incomplete Payments
    public function paymentsIncomplete(): View
    {
        $incompletePayments = Payment::where('status', 'failed')
            ->with('order.course')
            ->latest()
            ->get();

        return view('admin.payments-incomplete', compact('incompletePayments'));
    }

    // Users page
    public function users(): View
    {
        $orders = Order::with('course', 'payment')->get();
        // Get unique users from orders
        $users = $orders->unique('buyer_email')->values();
        
        return view('admin.users', compact('users', 'orders'));
    }

    // Courses - Index
    public function courseIndex(): View
    {
        $courses = Course::latest()->get();
        return view('admin.courses.index', compact('courses'));
    }

    // Courses - Create form
    public function courseCreate(): View
    {
        return view('admin.courses.create');
    }

    // Courses - Store
    public function courseStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'coach_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'required|url',
            'video_url' => 'required|url',
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    // Courses - Edit form
    public function courseEdit(Course $course): View
    {
        return view('admin.courses.edit', compact('course'));
    }

    // Courses - Update
    public function courseUpdate(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'coach_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'required|url',
            'video_url' => 'required|url',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    // Courses - Delete
    public function courseDestroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }

    // Order details
    public function orderDetails(Order $order): View
    {
        $payment = $order->payment;
        return view('admin.order-details', compact('order', 'payment'));
    }

    // Update order status
    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated successfully!');
    }

    // Logout
    public function logout(): RedirectResponse
    {
        session()->forget(['admin_logged_in', 'admin_email']);
        return redirect()->route('admin.login');
    }
}
