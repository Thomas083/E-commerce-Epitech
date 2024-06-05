<?php

namespace App\Models;

use App\Http\Controllers\OrderController;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'is_validated',
        'total_price',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_validated' => false,
        'total_price' => null,
    ];


    // Logique à mettre dans le OrderController : getTotalPrice()

    /**
     * Store the total price of the odrer.
     */
    // protected function totalPriceAtrribute(): Attribute
    // {
    //     // $totalPrice = Product::whereId($this->user_id)->price;
    //     // foreach ($this->products as $product) {
    //     //     $totalPrice += $product->price;
    //     // }

    //     // $totalPrice = 0;
    //     // $products = Order::whereId($this->id)->products;
    //     // foreach ($products as $product) {
    //     //     $totalPrice += $product->price;
    //     // }

    //     $totalPrice = OrderController::getTotalPrice($this);

    //     return Attribute::make(
    //         set: fn (string $value) => $totalPrice,
    //     );
    // }

    // Products of one order
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    // Customer of the order
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
