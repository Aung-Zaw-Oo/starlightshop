<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'credential_id',
        'browser',
        'device',
        'visit_count',
        'percentage',
        'status',
    ];

    protected $casts = [
        'visit_count' => 'integer',
        'percentage' => 'float',
        'status' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function credential()
    {
        return $this->belongsTo(Credential::class);
    }
}
