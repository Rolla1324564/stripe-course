<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Order;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Please login first');
        }

        // Share sidebar counts with all views
        $pendingCount = Order::where('status', 'pending')->count();
        $processingCount = Order::where('status', 'processing')->count();
        
        view()->share([
            'pendingCount' => $pendingCount,
            'processingCount' => $processingCount,
        ]);

        return $next($request);
    }
}
