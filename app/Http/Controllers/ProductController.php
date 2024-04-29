<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Added this line
use App\Models\Product;

class ProductController extends Controller
{
    // This method will show products page
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();

        return view('products.list', [
            'products' => $products
        ]);
    }

    // thisa method will show create product page
    public function create()
    {
        return view('products.create');
    }

    // thisa method will store a product in db
    public function store(request $request)
    {
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
        ];

        if ($request->image != "") {
            $rules["image"] = "image";
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }

        // here we will insert product in db
        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->image != "") {
            // here we will store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext; // unique image name

            // save image to products directory
            $image->move(public_path('uploads/products'), $imageName);

            // save image name in database
            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }

    // this method will show edit products page
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', [
            'product' => $product
        ]);
    }

    // thisa method will update a product in db
    public function update($id, Request $request)
    {

        $product = Product::findOrFail($id);

        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
        ];

        if ($request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.edit', $product->id)->withInput()->withErrors($validator);
        }

        // here we will update product
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->image != "") {
            // delete old image
            Storage::delete('uploads/products/' . $product->image);

            // here we will store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext; // unique image name

            // save image to products directory
            $image->move(public_path('uploads/products'), $imageName);

            // save image name in database
            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product update successfully');
    }

    // this method will delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // delete image
        Storage::delete(public_path('uploads/products/' . $product->image));

        // delete product from database
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product delete successfully');
    }
}
