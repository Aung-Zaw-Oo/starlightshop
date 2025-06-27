<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
