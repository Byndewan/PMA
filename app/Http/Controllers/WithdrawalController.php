<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with(['user', 'approver'])
            ->latest()
            ->paginate(10);

        return view('withdrawals.index', compact('withdrawals'));
    }

    public function create()
    {
        return view('withdrawals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = $request->user();

        if ($user->balance < $request->amount) {
            return back()->with('error', 'Saldo tidak mencukupi');
        }

        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan withdraw berhasil diajukan');
    }

    public function show($id)
    {
        $withdrawal = Withdrawal::find($id);
        return view('withdrawals.show', compact('withdrawal'));
    }

    public function approve(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal sudah diproses');
        }

        DB::transaction(function () use ($withdrawal) {
            $withdrawal->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            $withdrawal->user->decrement('balance', $withdrawal->amount);
        });

        return back()->with('success', 'Withdrawal berhasil diapprove');
    }
}
