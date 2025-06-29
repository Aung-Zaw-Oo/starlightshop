<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'dob',
        'credential_id',
        'last_login',
        'image',
        'status'
    ];

    public function credential()
    {
        return $this->belongsTo(Credential::class);
    }

    public function sessions()
    {
        return $this->hasMany(CustomerSession::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function updateStats()
    {
        $totalItems = 0;
        $totalSpent = 0;

        foreach ($this->orders as $order) {
            foreach ($order->orderDetails as $detail) {
                $totalItems += $detail->qty;
                $totalSpent += $detail->qty * $detail->price;
            }
        }

        $this->item_bought = $totalItems;
        $this->money_spent = $totalSpent;
        $this->save();
    }

    public function getItemBoughtAttribute()
    {
        return $this->orders()->with('orderDetails')->get()
            ->flatMap(fn($order) => $order->orderDetails)
            ->sum('qty');
    }

    public function getMoneySpentAttribute()
    {
        return $this->orders()->with('orderDetails')->get()
            ->flatMap(fn($order) => $order->orderDetails)
            ->reduce(fn($carry, $detail) => $carry + ($detail->qty * $detail->price), 0);
    }



    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($customer) {
            // Delete the related credential
            if ($customer->credential) {
                $customer->credential->delete();
            }

            // Delete the old image file if exists
            if ($customer->image && Storage::disk('public')->exists($customer->image)) {
                Storage::disk('public')->delete($customer->image);
            }
        });
    }
}