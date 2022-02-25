<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Order;

class OrderController extends Controller
{
    //
    public function index(){
        $order=Order::all();
         return response()->json([
             'status'=>200,
             'order'=>$order,
         ]);
 
     }

     public function destroy($id){
        $order=Order::find($id);
         if($order){
              
            $order->delete();
             return response()->json([
                 'status'=>200,
                 'message'=>'DeleteSuccessfully'
             ]);
         }else{
             
             return response()->json([
                 'status'=>404,
                 'message'=>'Order Not Found',
             ]);
         }
     }
}
