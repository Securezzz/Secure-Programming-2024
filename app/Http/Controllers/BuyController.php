<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

/** untuk nampilin product */
use App\Models\Product;

class BuyController extends Controller
{
    public function buy()
    {
        $category = Category::all();
        $product = Product::paginate(21);
        return view('buy.index', compact('product', 'category'));

    }

    public function category_search(Request $request)
    {
        $category = Category::all();
        $selectedCategory = $request->input('category');

        // Query untuk mengambil produk berdasarkan kategori yang dipilih
        if ($selectedCategory) {
            $product = Product::where('category', $selectedCategory)->paginate(21);
            $product->appends(['category' => $selectedCategory]); // Menambahkan parameter category ke link pagination
        } else {
            // Query untuk menampilkan semua produk jika tidak ada kategori yang dipilih
            $product = Product::paginate(21);
        }
        return view('buy.index', compact('product', 'category'));
    }

    public function shop_search(Request $request)
    {
        $category = Category::all();
        $search = $request->search;

        $product = Product::where('title', 'LIKE', '%'.$search.'%')->
        orWhere('category', 'LIKE', '%'.$search.'%')->paginate(21);

            // ini untuk biar pas di next paginatenya itu tetep nyangkut cari hal yang sama
        $product->appends(['search' => $search]);

        return view('buy.index', compact('product', 'category'));
    }



}
