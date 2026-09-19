<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// Login Routes
Route::get('/login', function () {
    return view('auth.login');
})->middleware(['guest'])->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ]);
    }

    if (!$user->is_active) {
        return back()->withErrors([
            'email' => 'حسابك غير نشط. يرجى الاتصال بالمسؤول.', // Your account is inactive. Please contact the administrator.
        ]);
    }

    Auth::login($user, $request->boolean('remember'));
    $request->session()->regenerate();
    return redirect()->intended('/');

    return back()->withErrors([
        'email' => 'بيانات الدخول غير صحيحة.',
    ]);
})->middleware(['guest']);

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->middleware(['auth'])->name('logout');

// Register Routes
Route::get('/register', function () {
    return view('auth.register');
})->middleware(['guest'])->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'phone' => ['nullable', 'string', 'max:20'],
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'phone' => $validated['phone'] ?? null,
        'role' => 'buyer',
        'is_active' => true,
    ]);

    $user->assignRole('buyer');
    Auth::login($user);

    return redirect('/');
})->middleware(['guest']);
