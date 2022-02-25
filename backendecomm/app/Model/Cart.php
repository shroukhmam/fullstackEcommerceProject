<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Product;

class Cart extends Model
{
    //
    protected $table='carts';
    protected $fillable=[
        'user_id',
        'product_id',
        'product_qty',
        'color',
        'size'
    ];

    protected $with=['product'];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
