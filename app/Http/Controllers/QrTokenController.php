<?php

namespace App\Http\Controllers;

use App\Models\QrToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class QrTokenController extends Controller
{
    public function showQRLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $token = Str::random(40);
        $expiresAt = now()->addMinutes(5);

        QrToken::create([
            'token' => $token,
            'expired_at' => $expiresAt,
        ]);

        $qrUrl = route('qr.login') . '?token=' . $token;

        return view('auth.qr-login', compact('qrUrl'));
    }

    public function verifyQRToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $qrToken = QrToken::where('token', $request->token)
            ->where('expired_at', '>', now())
            ->whereNull('used_at')
            ->first();

        if (!$qrToken) {
            return back()->with('error', 'QR Token invalid or expired');
        }

        // Mark token as used
        $qrToken->update([
            'used_at' => now(),
            'user_id' => $qrToken->user_id, // Link to operator account
        ]);

        // Login the operator
        Auth::loginUsingId($qrToken->user_id);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
