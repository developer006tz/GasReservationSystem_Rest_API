<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table = 'sales';

    protected $fillable = [
        'supplier_id',
        'customer_id',
        'post_id',
        'quantity',
        'price',
        'total_amount',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'double',
        'total_amount' => 'double',
    ];

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function post()
    {
        return $this->belongsTo(Gas::class, 'post_id');
    }
}
