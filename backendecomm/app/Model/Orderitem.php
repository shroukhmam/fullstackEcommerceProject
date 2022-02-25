<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    //
    protected $table='orderitems';
    protected $fillable=[
        'product_id',
        'order_id',
        'qty',
        'price'
    ];
}
