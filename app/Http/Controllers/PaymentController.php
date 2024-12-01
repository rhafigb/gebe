<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Order;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        // Pastikan bahwa environment variable di .env sudah terisi dengan benar
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false; // Ganti ke true jika sudah siap untuk produksi
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Mencari data order berdasarkan order_id yang dikirimkan
        $order = Order::find($request->order_id);

        // Jika order tidak ditemukan, beri response error
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found!');
        }

        // Detil transaksi
        $transaction_details = [
            'order_id' => $order->id,
            'gross_amount' => $order->total_price, // Total pembayaran
        ];

        // Detil item
        $item_details = [
            [
                'id' => $order->id,
                'price' => $order->total_price,
                'quantity' => 1,
                'name' => 'Dim Sum Order',
            ],
        ];

        // Detil customer
        $customer_details = [
            'first_name'    => $order->customer_name,
            'email'         => $order->customer_email,
            'phone'         => $order->customer_phone, // Pastikan field ini ada
            'shipping_address' => [
                'address'   => $order->address,
                'city'      => 'City', // Ganti dengan data asli jika tersedia
                'postal_code' => 'PostalCode', // Ganti dengan data asli jika tersedia
                'country_code' => 'IDN',
            ]
        ];

        // Set transaksi
        $transaction = [
            'payment_type' => 'credit_card', // Gunakan jenis pembayaran sesuai
            'transaction_details' => $transaction_details,
            'item_details' => $item_details,
            'customer_details' => $customer_details,
        ];

        // Mendapatkan snap token
        try {
            $snapToken = Snap::getSnapToken($transaction);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error generating payment token: ' . $e->getMessage());
        }

        // Mengirimkan snap token ke view untuk proses pembayaran
        return view('payment', compact('snapToken'));
    }
}
