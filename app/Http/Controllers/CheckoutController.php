<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;  // Pastikan Request diimpor dengan benar

class CheckoutController extends Controller
{
    /**
     * Handle the checkout process.
     */
    public function checkout(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
        ]);

        // Get cart data from session
        $cart = session()->get('cart', []);

        // Calculate total price
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        // Create a new order record
        Order::create([
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'address' => $validated['address'],
            'total_price' => $total,
        ]);

        // Clear the cart from session after the order is placed
        session()->forget('cart');

        // Redirect to the home page with a success message
        return redirect('/')->with('success', 'Order placed successfully!');
    }
}
