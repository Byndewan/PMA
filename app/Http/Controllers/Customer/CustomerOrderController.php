<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function create(Product $product)
    {
        return view('customer.orders.create', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        return DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);
            $filePath = $this->storeFile($request->file('file'));

            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => auth()->user()->name,
                'phone' => auth()->user()->phone,
                'status' => 'pending',
                'total_price' => $product->price * $request->quantity,
                'operator_fee_total' => $product->operator_fee * $request->quantity,
                'notes' => $request->notes,
                'order_number' => 'ORD-' . time(),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price_per_unit' => $product->price,
                'operator_fee' => $product->operator_fee,
                'file_path' => $filePath,
            ]);

            return redirect()->route('customer.orders.show', $order)
                ->with('success', 'Order created successfully. Please complete the payment.');
        });
    }

    public function show(Order $order)
    {
        return view('customer.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {

        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be canceled.');
        }

        $order->update(['status' => 'canceled']);
        return back()->with('success', 'Order has been canceled.');
    }

    public function upload(Request $request, Order $order)
    {

        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePath = $this->storeFile($request->file('file'));
        $order->items()->update(['file_path' => $filePath]);

        return back()->with('success', 'File updated successfully.');
    }

    public function payment(Order $order)
    {
        return view('customer.orders.payment', compact('order'));
    }

    public function submitPayment(Request $request, Order $order)
    {

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        $order->update([
            'payment_status' => 'pending',
            'payment_proof' => $paymentProofPath,
        ]);

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Payment proof uploaded. Waiting for verification.');
    }

    protected function storeFile($file)
    {
        return $file->store('order_files', 'public');
    }
}
