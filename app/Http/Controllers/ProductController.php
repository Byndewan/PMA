<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->filter(
            request(['search', 'status'])
        )->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'format' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'operator_fee' => 'required|numeric|min:0',
            'estimate_time' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'format' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'operator_fee' => 'required|numeric|min:0',
            'estimate_time' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted successfully');
    }
}
