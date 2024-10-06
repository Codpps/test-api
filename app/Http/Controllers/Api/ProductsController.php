<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::latest()->paginate(10);
        // return view('products.index', compact('products'));
        return new ProductsResource(true, 'List Data Products', $products);
    }

    public function create()
    {
        return view('products.create');
    }

    public function edit($id)
    {
        $product = Products::find($id);
        return view('products.form', compact('product'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image')->store('public/products');

        $products = Products::create([
            'image'       => basename($image),
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
        ]);

        return new ProductsResource(true, 'Product successfully added!', $products);
    }

    public function show($id)
    {
        $products = Products::find($id);

        return new ProductsResource(true, 'Detail Data Post!', $products);
    }

    public function update(Request $request, $id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image')) {
            Storage::delete('public/products/' . $product->image);

            $image = $request->file('image');
            $image->storeAs('public/products/', $image->hashName());
            $product->image = $image->hashName(); // Update the image field
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        return new ProductsResource(true, 'Data Post Berhasil Diperbarui!', $product);
    }

    public function destroy($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        Storage::delete('public/products/' . $product->image);

        $product->delete();

        return response()->json(['message' => 'Data Post Berhasil Dihapus!'], 200);
    }
}
