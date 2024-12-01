<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import model Product

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::all(); // Mengambil semua data produk
        return view('products.index', compact('products')); // Mengirim data ke view
    }
}
