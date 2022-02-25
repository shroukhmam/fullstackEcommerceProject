<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\orderitem;
class Order extends Model
{
    //
    protected $table='orders';
    protected $fillable=[
        'firstname',
        'lastname',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'zipcode',
        'payment_id',
        'payment_mode',
        'tracking_no',
        'status',
        'remark'
    ];
    public function orderitems(){
        return $this->hasMany(Orderitem::class,'order_id');
    }
}
