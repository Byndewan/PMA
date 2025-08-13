<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->filter(request(['search']))->paginate(12);

        return view('customer.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $relatedProducts = Product::where('id', '!=', $product->id)->inRandomOrder()->limit(4)->get();

        return view('customer.products.show', compact('product', 'relatedProducts'));
    }

    public function favorite(Product $product)
    {
        $user = auth()->user();

        $isFavorite = $user->favoriteProducts()->where('product_id', $product->id)->exists();

        if ($isFavorite) {
            $user->favoriteProducts()->detach($product->id);
            $action = 'removed';
        } else {
            $user->favoriteProducts()->attach($product->id);
            $action = 'added';
        }

        if (request()->expectsJson()) {
            return response()->json(['action' => $action]);
        }

        return back()->with('success', $action === 'added'
            ? 'Product added to favorites.'
            : 'Product removed from favorites.');
    }

}
