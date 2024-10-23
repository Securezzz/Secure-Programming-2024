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
        $category = new Category;

        /**
         * Tulisannya yang abis "->" kan "category" itu didapet dari file category.blade.php
         * yang ada input text namenya category (itu yang dipake)
         */
        $category->category_name = $request->category;

        $category->save();

        /**
         * Tambah buat notif toastr kalau berhasil add category
         */
        toastr()->timeOut(10000)->closeButton()->addSuccess('
        Category Added Successfully');

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

    public function upload_product(Request $request)
    {
        $data = new Product;

        $data->title = $request->title;
        $data->description = $request->description;
        $data->starting_price = $request->s_price;
        $data->discount = $request->disc;

        $data->final_price = $request->f_price;

        $data->quantity = $request->qty;
        $data->category = $request->category;

        $image = $request->image;

        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            /**
             * Masuk ke folder products di public
             */
            $request->image->move('products', $imagename);
            $data->image = $imagename;
        }

        /* Pesan sukses */
        toastr()->timeOut(10000)->closeButton()->addSuccess('
        Product Added Successfully');

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
        $data = Product::find($id);

        $data->title = $request->title;
        $data->description = $request->description;
        $data->starting_price = $request->s_price;
        $data->discount = $request->disc;

        $data->final_price = $request->f_price;

        $data->quantity = $request->qty;
        $data->category = $request->category;

        $image = $request->image;

        $image_path = public_path('products/'.$data->image);
        if(file_exists($image_path) && $image='')
        {
            unlink($image_path);
        }

        if ($image && $image instanceof \Illuminate\Http\UploadedFile) {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $image->move('products', $imagename);
            $data->image = $imagename;
        }

        $data->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('
        Product Updated Successfully');

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
