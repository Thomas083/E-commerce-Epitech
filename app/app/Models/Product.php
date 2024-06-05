<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'photo',
        'price',
        'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'description' => '',
        'photo' => '',
    ];

    // Orders for one product
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('id', 'total_price', 'is_validated')->withTimestamps();
    }

    // Seller of the product
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
