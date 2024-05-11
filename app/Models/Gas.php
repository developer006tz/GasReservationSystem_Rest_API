<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gas extends Model
{
    use HasFactory;

    protected $table='gases_posts';
    protected  $primaryKey='id';

    protected  $fillable=['gas_category_id','title','image','location','in_stock','price','supplier_id','is_published','latitude','longitude'];

    public function gasCategory(){
        return $this->hasOne(GasCategory::class,'gas_category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(User::class,'supplier_id');
    }
}
