<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $lockedBalance = Order::where('user_id', $user->id)
            ->whereIn('status', ['queue', 'process'])
            ->sum('operator_fee_total');

        $availableBalance = $user->balance - $lockedBalance;

        $withdrawals = Withdrawal::with(['user', 'approver'])
            ->filter(request(['status']))
            ->latest()
            ->paginate(10);

        return view('withdrawals.index', compact('withdrawals', 'lockedBalance', 'availableBalance'));
    }

    public function create()
    {
        $user = auth()->user();

        $lockedBalance = Order::where('user_id', $user->id)
            ->whereIn('status', ['queue', 'process'])
            ->sum('operator_fee_total');

        $availableBalance = $user->balance - $lockedBalance;

        return view('withdrawals.create' ,compact('availableBalance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = $request->user();

        $lockedBalance = Order::where('user_id', $user->id)
            ->whereIn('status', ['queue', 'process']) // order yang belum selesai
            ->sum('operator_fee_total');

        $availableBalance = $user->balance - $lockedBalance;

        if ($availableBalance < $request->amount) {
            return back()->with('error', 'Saldo tidak mencukupi atau masih terikat di order yang sedang dikerjakan.');
        }

        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Withdrawal request submitted');
    }

    public function show(Withdrawal $withdrawal)
    {
        return view('withdrawals.show', compact('withdrawal'));
    }

    public function approve(Withdrawal $withdrawal)
    {

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal already processed');
        }

        DB::transaction(function () use ($withdrawal) {
            $withdrawal->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            $withdrawal->user->decrement('balance', $withdrawal->amount);
        });

        return back()->with('success', 'Withdrawal approved successfully');
    }

    public function destroy(Withdrawal $withdrawal)
    {

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Only pending withdrawals can be canceled');
        }

        $withdrawal->delete();
        return back()->with('success', 'Withdrawal canceled successfully');
    }
}
