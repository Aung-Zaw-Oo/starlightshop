<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    /** @use HasFactory<\Database\Factories\CredentialFactory> */
    use HasFactory;

    protected $fillable = [
        'email',
        'password'
    ];

    protected $hidden = ['password'];

    public function staff()
    {
        return $this->hasOne(Staff::class, 'credential_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'credential_id');
    }

}
