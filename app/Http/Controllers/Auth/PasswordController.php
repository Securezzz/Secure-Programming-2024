<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => [
            'nullable',            // buat password opsional saat update
            'string',
            'min:8',               // minimal 8 karakter
            'regex:/[a-z]/',       // setidaknya ada satu huruf kecil
            'regex:/[A-Z]/',       // setidaknya ada satu huruf kapital
            'regex:/[0-9]/',       // setidaknya ada satu angka
            'regex:/[@$!%*?&#]/',  // setidaknya ada satu simbol
            Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        session()->flash('status', 'Password updated successfully!');
        return back()->with('status', 'password-updated');
    }
}
