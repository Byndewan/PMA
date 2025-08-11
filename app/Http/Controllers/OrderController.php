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
            'customer_name' => 'required|max:255',
            'customer_phone' => 'required|max:13',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.file' => 'required|mimes:jpg,jpeg,png,pdf',
        ]);
        // dd($request->all());

        return DB::transaction(function () use ($request) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'status' => 'queue',
                'total_price' => 0,
                'operator_fee_total' => 0,
            ]);

            $totalPrice = 0;
            $totalFee = 0;

            foreach ($request->items as $index => $item) {
                $product = Product::findOrFail($item['product_id']);

                $uploadedFile = $request->file("items.$index.file");

                $filePath = $this->storeFile($uploadedFile);

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
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:queue,process,done,taken',
        ]);

        $order->update($request->all());

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'queue' || $order->status === 'process') {
            $order->user->decrement('balance', $order->operator_fee_total);
        }

        $order->delete();

        return back()->with('success', 'Order deleted successfully');
    }

    protected function storeFile($file)
    {
        return $file->store('order_files', 'public');
    }
}
