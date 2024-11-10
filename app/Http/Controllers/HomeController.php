<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\User;

use App\Models\Cart;

use App\Models\Category;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Sepaket sama tadi atur route untuk admin
     */
    public function index()
    {
        $product = Product::paginate(3);
        $data = Category::all();
        return view('admin.index', compact('product', 'data'));
    }

    /**
     * Route tambahan untuk ke home index habis dikasih template HTML
     */
    public function home()
    {
        return view('home.index');
    }

    // Fungsi login home
    public function login_home()
    {
        $product = Product::all();

        $user = Auth::user();

        $userid = $user->id;

        $count = Cart::where('user_id', $userid)->count();

        return view('home.index', compact('product', 'count'));
    }

    // Fungsi add to cart
    public function add_cart($id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        // Memeriksa apakah produk sudah ada di cart
        $existingCartItem = Cart::where('user_id', $user_id)
                                ->where('product_id', $id)
                                ->first();

        if ($existingCartItem) {
            // Jika produk sudah ada di cart, tampilkan pesan dan jangan tambahkan lagi
            toastr()->timeOut(10000)->closeButton()->addWarning('Product is already in the cart');
        } else {
            // Jika produk belum ada di cart, tambahkan produk ke cart
            $data = new Cart;
            $data->user_id = $user_id;
            $data->product_id = $id;
            $data->quantity = 1; // Default quantity atau Anda bisa menyesuaikan sesuai kebutuhan

            $data->save();
            toastr()->timeOut(10000)->closeButton()->addSuccess('Product Added to the cart');
        }

        return redirect()->back();
    }


    public function mycart()
    {
        if(Auth::id())
        {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
            $cart = Cart::where('user_id', $userid)->get();
        }
        return view('home.mycart', compact('count', 'cart'));
    }

    // Remove cart
    public function deleteCart($id)
    {
        $cartItem = Cart::find($id);
        $cartItem->delete();
        toastr()->timeOut(10000)->closeButton()->addSuccess('
        Cart Deleted Successfully');
        return redirect()->back();
    }

    public function updateQuantity(Request $request)
    {
        $cartItem = Cart::find($request->cartItemId);

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return response()->json(['success' => true, 'message' => 'Cart updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Cart item not found']);
    }

}

