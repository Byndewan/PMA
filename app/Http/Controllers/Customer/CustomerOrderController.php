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
            'customer_name' => 'required|max:255',
            'customer_phone' => 'required|max:13',
            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        return DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);

            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'status' => 'pending',
                'total_price' => 0,
                'operator_fee_total' => 0,
                'notes' => $request->notes,
                'order_number' => 'ORD-' . time(),
                'payment_status' => 'pending',
            ]);

            $totalPrice = 0;
            $totalFee = 0;

            foreach ($request->items as $index => $item) {
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
        if (!in_array($order->status, ['pending', 'queue'])) {
            return back()->with('error', 'Only pending orders can be canceled.');
        }

        $order->update(['status' => 'canceled']);
        return back()->with('success', 'Order has been canceled.');
    }

    public function upload(Request $request, Order $order)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'item_id' => 'required|exists:order_items,id',
        ]);

        $item = $order->items()->where('id', $request->item_id)->firstOrFail();
        $filePath = $this->storeFile($request->file('file'));

        $item->update(['file_path' => $filePath]);

        return back()->with('success', 'Foto berhasil diperbaharui.');
    }

    public function payment(Order $order)
    {
        return view('customer.orders.payment', compact('order'));
    }

   public function submitPayment(Request $request, Order $order)
    {
        $order->update([
            'payment_status' => 'pending'
        ]);

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Payment proof uploaded. Waiting for verification.');
    }

    protected function storeFile($file)
    {
        return $file->store('order_files', 'public');
    }
}
