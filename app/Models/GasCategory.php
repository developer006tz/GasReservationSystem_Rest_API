<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GasCategory extends Model
{
    use HasFactory;

    protected $table = 'gas_category';
    protected $fillable = ['name','image'];
    protected $hidden = ['created_at','updated_at'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];


}
