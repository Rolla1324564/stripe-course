<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function buyNow(Course $course): View
    {
        return view('payments.buy-now', compact('course'));
    }

    public function buyForFriend(Course $course): View
    {
        return view('payments.buy-for-friend', compact('course'));
    }

    public function processPayment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'required|email',
            'buyer_phone' => 'required|string|max:20',
            'buyer_country' => 'required|string|max:100',
            'receiver_name' => 'nullable|string|max:255',
            'receiver_email' => 'nullable|email',
            'receiver_phone' => 'nullable|string|max:20',
            'receiver_country' => 'nullable|string|max:100',
            'stripe_token' => 'required|string',
            'type' => 'required|in:self,friend',
        ]);

        $course = Course::findOrFail($validated['course_id']);

        // Create Order
        $order = Order::create([
            'course_id' => $course->id,
            'buyer_name' => $validated['buyer_name'],
            'buyer_email' => $validated['buyer_email'],
            'buyer_phone' => $validated['buyer_phone'],
            'buyer_country' => $validated['buyer_country'],
            'receiver_name' => $validated['receiver_name'] ?? null,
            'receiver_email' => $validated['receiver_email'] ?? null,
            'receiver_phone' => $validated['receiver_phone'] ?? null,
            'receiver_country' => $validated['receiver_country'] ?? null,
            'total_amount' => $course->price,
            'type' => $validated['type'],
            'status' => 'pending',
        ]);

        try {
            // Create Stripe Charge using token
            $charge = \Stripe\Charge::create([
                'amount' => (int)($course->price * 100), // Amount in cents
                'currency' => 'usd',
                'source' => $validated['stripe_token'],
                'description' => $course->title . ' - Order #' . $order->id,
                'metadata' => [
                    'order_id' => $order->id,
                    'course_id' => $course->id,
                    'buyer_email' => $validated['buyer_email'],
                ],
            ]);

            // Create Payment Record
            Payment::create([
                'order_id' => $order->id,
                'stripe_payment_id' => $charge->id,
                'card_last4' => $charge->payment_method_details->card->last4 ?? 'xxxx',
                'card_brand' => ucfirst($charge->payment_method_details->card->brand ?? 'card'),
                'amount' => $course->price,
                'status' => $charge->status,
                'response_data' => json_encode($charge),
            ]);

            // Update Order Status to processing (payment received, but admin needs to verify)
            $order->update(['status' => 'processing']);

            return redirect()->route('payment.success', $order->id);
        } catch (\Exception $e) {
            $order->update(['status' => 'failed']);
            return redirect()->route('payment.cancel')->with('error', $e->getMessage());
        }
    }

    public function success(Order $order): View
    {
        $payment = $order->payment;
        return view('payments.success', compact('order', 'payment'));
    }

    public function cancel(): View
    {
        return view('payments.cancel');
    }
}




