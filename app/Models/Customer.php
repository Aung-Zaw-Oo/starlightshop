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