<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'staff_id',
        'name',
        'sale_price',
        'purchase_price',
        'qty',
        'description',
        'image',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            // Delete the old image file if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        });
    }
}
