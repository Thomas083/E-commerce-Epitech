<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Product::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|max:255",
            "description" => "required_without:photo",
            "photo" => "required_without:description",
            "price" => "required|numeric|max:10e6",
        ]);

        $product = Product::create(
            $request->all()+
            ["user_id" => auth()->user()->id],
        );

        return response([
            "message" => 'Product created successfully',
            "data" => $product,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response($product, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            "name" => "required|max:255",
            "description" => "required_without:photo",
            "photo" => "required_without:description",
            "price" => "required|numeric|max:10e6",
        ]);

        $product->update($request->all());

        return response([
            "message" => "Product updated successfully",
            "data" => $product,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response([
            "message" => "Product deleted successfully",
            "data" => $product,
        ], 200);
    }
}
