<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function clearCart(Request $request)
    {
        if (Auth::check()) {
            // Ambil semua item dalam keranjang pengguna
            $cartItems = Cart::where('user_id', Auth::id())->get();

            // Looping melalui item dalam keranjang untuk mengupdate stok produk
            foreach ($cartItems as $cartItem) {
                // Cari produk terkait berdasarkan product_id
                $product = Product::find($cartItem->product_id);

                if ($product) {
                    // Kurangi stok produk sesuai jumlah item dalam keranjang
                    $product->decrement('quantity', $cartItem->quantity);
                }
            }

            // Menghapus semua item keranjang pengguna
            Cart::where('user_id', Auth::id())->delete();

            // Mendapatkan semua produk dengan quantity 0
            $productsToDelete = Product::where('quantity', 0)->get();

            // Mengiterasi setiap produk dan menghapus file image serta entry database
            foreach ($productsToDelete as $product) {
                $imagePath = public_path('products/' . $product->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath); // Menghapus file image
                }

                $product->delete(); // Menghapus produk dari database
            }


            return response()->json(['success' => true, 'message' => 'Keranjang berhasil dikosongkan dan stok diperbarui.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Anda harus login terlebih dahulu.']);
        }
    }


    public function validatePayment(Request $request)
    {
        $cartItems = $request->input('cart_items'); // Pastikan data ini dikirim dari client
        $totalAmount = 0;

        foreach ($cartItems as $item) {
            $cartItem = Cart::find($item['id']);
            if ($cartItem && $cartItem->product) {
                // Validasi harga dan stok dari database
                $product = $cartItem->product;
                $totalAmount += $product->final_price * $cartItem->quantity;

                if ($product->quantity < $cartItem->quantity) {
                    return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi untuk produk: ' . $product->title]);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Item di keranjang tidak valid.']);
            }
        }

        if ($totalAmount != $request->input('calculated_total')) {
            return response()->json(['success' => false, 'message' => 'Total harga tidak valid.']);
        }

        // Lanjutkan proses pembayaran jika validasi berhasil
        return response()->json(['success' => true, 'message' => 'Validasi berhasil.']);
    }
}
