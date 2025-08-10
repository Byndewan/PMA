<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->isAdmin()
            ? Order::latest()->paginate(10)
            : Order::where('user_id', auth()->id())->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::get();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        return DB::transaction(function () use ($request) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'status' => 'queue',
                'total_price' => 0,
                'operator_fee_total' => 0,
            ]);

            $totalPrice = 0;
            $totalFee = 0;

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $filePath = $this->storeFile($item['file']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price_per_unit' => $product->price,
                    'operator_fee' => $product->operator_fee,
                    'file_path' => $filePath,
                ]);

                $totalPrice += $product->price * $item['quantity'];
                $totalFee += $product->operator_fee * $item['quantity'];
            }

            $order->update([
                'total_price' => $totalPrice,
                'operator_fee_total' => $totalFee,
            ]);

            // Update operator balance
            auth()->user()->increment('balance', $totalFee);

            return redirect()->route('orders.index')->with('success', 'Order created successfully');
        });
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $this->authorize('update', $order);
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $request->validate([
            'status' => 'required|in:queue,process,done,taken',
        ]);

        $order->update($request->only('status'));

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        $order->delete();
        return back()->with('success', 'Order deleted successfully');
    }

    protected function storeFile($file)
    {
        return $file->store('order_files', 'public');
    }
}
