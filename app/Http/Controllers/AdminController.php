<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Untuk add category
 */
use App\Models\Category;

/**
 * Untuk add product
 */
use App\Models\Product;

class AdminController extends Controller
{
    public function view_category()
    {
        $data = Category::all();

        return view('admin.category', compact('data'));
    }

    /**
     * Untuk post pakai Request $request itu
     */
    public function add_category(Request $request)
    {
        // Validasi input untuk memastikan 'category' wajib diisi
        $request->validate([
            'category' => 'required|string|max:255'
        ]);

        // Cek apakah kategori dengan nama yang sama sudah ada
        $existingCategory = Category::where('category_name', $request->category)->first();

        if ($existingCategory) {
            // Notifikasi jika kategori sudah ada
            toastr()->error('Category already exists.');
            return redirect()->back();
        }

        // Jika tidak ada, buat kategori baru
        $category = new Category;
        $category->category_name = $request->category;
        $category->save();

        // Notifikasi berhasil menambahkan kategori
        toastr()->timeOut(10000)->closeButton()->addSuccess('Category Added Successfully');

        return redirect()->back();
    }


    public function delete_category($id)
    {
        $data = Category::find($id);

        $data->delete();

        toastr()->timeOut(10000)->closeButton()->addSuccess('
        Category Deleted Successfully');

        return redirect()->back();
    }

    public function edit_category($id)
    {
        $data = Category::find($id);

        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request, $id)
    {
        $data = Category::find($id);

        $data->category_name = $request->category;

        $data->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('
        Category Updated Successfully');

        return redirect('/view_category');
    }

    public function add_product()
    {
        $category = Category::all();

        return view('admin.add_product', compact('category'));
    }

    public function upload_product(Request $request){
        // Validasi input termasuk file gambar
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            's_price' => 'required|numeric',
            'disc' => 'nullable|numeric',
            'f_price' => 'required|numeric',
            'qty' => 'required|integer',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
        ]);

        // Pembuatan instance produk baru
        $data = new Product;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->starting_price = $request->s_price;
        $data->discount = $request->disc;
        $data->final_price = $request->f_price;
        $data->quantity = $request->qty;
        $data->category = $request->category;

        // Proses unggah gambar
        $image = $request->image;

        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            // Simpan gambar ke folder 'products' di direktori public
            $image->move(public_path('products'), $imagename);
            $data->image = $imagename;
        }

        // Pesan sukses
        toastr()->timeOut(10000)->closeButton()->addSuccess('Product Added Successfully');

        // Simpan data ke database
        $data->save();

        return redirect()->back();
}


    public function view_product()
    {
        $product = Product::paginate(3);
        return view('admin.view_product', compact('product'));
    }

    public function delete_product($id)
    {
        $data = Product::find($id);

        /**
         * untuk delete file image di public
         */
        $image_path = public_path('products/'.$data->image);
        if(file_exists($image_path))
        {
            unlink($image_path);
        }

        $data->delete();

        toastr()->timeOut(10000)->closeButton()->addSuccess('
        Products Deleted Successfully');

        return redirect()->back();
    }

    public function edit_product($id)
    {
        $data = Product::find($id);
        $categories = Category::all(); // Fetch all categories from the database
        return view('admin.edit_product', compact('data', 'categories'));

    }

    public function update_product(Request $request, $id)
{
    // Validasi input termasuk file gambar
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        's_price' => 'required|numeric',
        'disc' => 'nullable|numeric',
        'f_price' => 'required|numeric',
        'qty' => 'required|integer',
        'category' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar, opsional
    ]);

    // Cari produk berdasarkan ID
    $data = Product::find($id);

    if (!$data) {
        toastr()->timeOut(10000)->closeButton()->addError('Product not found');
        return redirect()->back();
    }

    // Update field dengan data dari request
    $data->title = $request->title;
    $data->description = $request->description;
    $data->starting_price = $request->s_price;
    $data->discount = $request->disc;
    $data->final_price = $request->f_price;
    $data->quantity = $request->qty;
    $data->category = $request->category;

    // Proses penggantian gambar
    $image = $request->file('image');

    if ($image) {
        // Hapus gambar lama jika ada
        $image_path = public_path('products/' . $data->image);
        if (file_exists($image_path) && $data->image) {
            unlink($image_path);
        }

        // Simpan gambar baru
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('products'), $imagename);
        $data->image = $imagename;
    }

    // Simpan perubahan ke database
    $data->save();

    toastr()->timeOut(10000)->closeButton()->addSuccess('Product Updated Successfully');

    return redirect('/view_product');
}


    public function product_search(Request $request)
    {
        $search = $request->search;

        $product = Product::where('title', 'LIKE', '%'.$search.'%')->
        orWhere('category', 'LIKE', '%'.$search.'%')->paginate(3);

        $product->appends(['search' => $search]);

        return view('admin.view_product', compact('product'));
    }
}
