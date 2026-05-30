<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Set active on login
        User::where('id', $user->id)->update(['status' => 'active']);

        session()->flash('toast_success', 'Welcome back, ' . $user->name . '!');

        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Set inactive on logout
        if ($user) {
            User::where('id', $user->id)->update(['status' => 'inactive']);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}