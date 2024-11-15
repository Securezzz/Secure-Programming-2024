<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:'.User::class],
            'password' => [
                'required', 
                'string',
                'min:8',              // Minimal 8 karakter
                'regex:/[a-z]/',      // Harus mengandung huruf kecil
                'regex:/[A-Z]/',      // Harus mengandung huruf kapital
                'regex:/[0-9]/',      // Harus mengandung angka
                'regex:/[@$!%*?&#]/',
                'confirmed', 
                Rules\Password::defaults()],
            'phone' => ['required', 'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,10}$/'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Tambahkan flash message
        session()->alert('status', 'Registration successful!');

        return redirect(route('login', absolute: false));
    }
}
