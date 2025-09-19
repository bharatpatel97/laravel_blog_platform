<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if ($request->wantsJson()) {
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token'   => $token,
                'user'    => $user
            ]);
        }

        return redirect()->intended('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        if ($request->wantsJson()) {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
