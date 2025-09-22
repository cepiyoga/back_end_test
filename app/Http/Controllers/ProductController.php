<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $products = Product::where('user_id', $user_id)->orderBy('id', 'desc')->get()->map(function ($product) {
            $product->banner_image = $product->banner_image ? asset('storage/'.$product->banner_image) : null;
            return $product;
        });
        return json_encode([
            'success' => true,
            'message' => 'Products retrieved',
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'cost' => 'required',
        ]);
        $data["banner_image"] = "default.jpg";
        $data["user_id"] = auth()->user()->id;
        if ($request->hasFile('banner_image')) {
            $data["banner_image"] = $request->file('banner_image')->store("products", 'public');
        }

        Product::create($data);
        return json_encode([
            'status' => true,
            'message' => 'Product created successfully, title: '.$request->title
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return json_encode([
            'status' => true,
            'message' => 'Product retrieved',
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $data = $request->validate([
            'title' => 'required',
        ]);


        $data["description"] = isset($request->description) ? $request->description : $product->description;
        $data["cost"] = isset($request->cost) ? $request->cost : $product->cost;

        if ($request->hasFile('banner_image')) {
            $data["banner_image"] = $request->file('banner_image')->store("products", 'public');
        }

        $product->update($data);
        return json_encode([
            'status' => true,
            'message' => 'Product updated'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PRoduct $product)
    {
        $product->delete();
        return json_encode([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
