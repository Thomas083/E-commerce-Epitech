<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class OrderController extends Controller
{
    private function getCurrentUserCart(){
        // A modifier une fois le merge avec sanctum
        $userId = auth()->user()->id;
        $cart = Order::where('user_id', $userId)->where('is_validated', false)->first();
        if ($cart == null) {
            return false;
        }
        return $cart;
        //return Order::where('user_id', 1)->where('is_validated', false)->first();
    }

    private function getTotalPrice(Order $order){
        $total = 0;
        $products = $order->products;
        foreach ($products as $product){
            $total += $product->price;
        }
        return number_format($total, 2);
    }

    /**
     * Display all orders of the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        // A modifier une fois le merge avec sanctum
        $orders = Order::where('user_id', auth()->user()->id)->where("is_validated", true)->get();
        //$orders = Order::all();
        foreach ($orders as $order){
            $order->total_price = $this->getTotalPrice($order);
            $data += [
                "products" => $order->products,
            ];
        };

        return response($orders, 200);
    }

    /**
     * Add a product to the shopping cart. Create a cart if no current cart.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product)
    {
        if (($order = $this->getCurrentUserCart()) == null){
            // A modifier une fois le merge avec sanctum
            $order = Order::create(["user_id" => auth()->user()->id]);
            //$order = Order::create(["user_id" => 1]);
        }
        $order->products()->attach($product);
        $order->total_price = $this->getTotalPrice($order);
        $p = $order->products;

        return response([
            "message" => "Product added to cart successfully",
            "data" => $order,
        ], 201);
    }

    /**
     * Display information about a specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->total_price = $this->getTotalPrice($order);
        $p = $order->products;
        return response($order, 200);
    }

    /**
     * Display state (products list) of the current user's cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCart()
    {
        if (($cart = $this->getCurrentUserCart()) == null){
            return response("Error : No current cart found, please add a product first.", 404);
        }
        return response($cart->products, 200);
    }

    /**
     * Validate the current user's cart into an order. Caution, this action is currently irreversible.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCart()
    {
        if (($cart = $this->getCurrentUserCart()) == null){
            return response("Error : No current cart found, please add a product first.", 404);
        }
        $cart->update(['is_validated' => !$cart->is_validated]);
        $cart->total_price = $this->getTotalPrice($cart);
        return response([
            "message" => "Cart validated successfully",
            "data" => $cart,
        ], 200);
    }

    /**
     * Remove the specified product from current cart.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function remove(Product $product)
    {
        if (($cart = $this->getCurrentUserCart()) == null){
            return response("Error : No current cart found, please add a product first.", 404);
        }
        $cart->products()->detach($product);

        return response([
            "message" => "Product removed from cart successfully",
            "data" => $product,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        $order->total_price = $this->getTotalPrice($order);
        return response([
            "message" => "Order deleted successfully",
            "data" => $order,
        ], 200);
    }
}
