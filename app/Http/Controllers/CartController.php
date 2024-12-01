<?php

namespace App\Http\Controllers;

use App\Models\Product;  // Tambahkan import model Product
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Add product to cart.
     */
    public function addToCart(Request $request, $id)
    {
        // Temukan produk berdasarkan ID
        $product = Product::find($id);

        // Periksa jika produk tidak ditemukan
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Ambil cart yang ada dalam session atau buat array kosong
        $cart = session()->get('cart', []);

        // Jika produk sudah ada di cart, tambahkan kuantitasnya
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Jika produk belum ada di cart, tambahkan produk baru
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }

        // Simpan cart dalam session
        session()->put('cart', $cart);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Product added to cart!');
    }
    public function viewCart()
{
    $cart = session()->get('cart', []);
    return view('cart.index', compact('cart'));
}

}
