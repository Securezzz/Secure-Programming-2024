<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function clearCart(Request $request)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();

            return response()->json(['success' => true, 'message' => 'Keranjang berhasil dikosongkan.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Anda harus login terlebih dahulu.']);
        }
    }
}
