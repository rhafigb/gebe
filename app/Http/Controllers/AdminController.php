<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Impor model Product
use App\Models\Order;   // Impor model Order

class AdminController extends Controller
{
    public function showProducts()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'desc' => 'required|string',
        ]);

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'desc' => $request->desc,
        ]);

        return redirect()->route('admin.products.index');
    }

    public function salesReport()
    {
        $orders = Order::all();
        return view('admin.reports.sales', compact('orders'));
    }
}
