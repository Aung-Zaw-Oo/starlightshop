<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    /** @use HasFactory<\Database\Factories\StaffFactory> */
    use HasFactory;

    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'address',
        'phone',
        'dob',
        'credential_id',
        'image',
        'last_login',
        'status'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function credential()
    {
        return $this->belongsTo(Credential::class);
    }

    public function product(){
        return $this->hasMany(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($staff) {
            // Delete the related credential
            if ($staff->credential) {
                $staff->credential->delete();
            }

            // Delete the old image file if exists and not default
            if ($staff->image && Storage::disk('public')->exists($staff->image)) {
                Storage::disk('public')->delete($staff->image);
            }
        });
    }

}
