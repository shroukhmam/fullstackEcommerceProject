<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Order;
use App\Model\Cart;
use App\Model\Orderitem;
class CheckoutController extends Controller
{
    //

    public function placeorder(Request $req){
        if(auth('sanctum')->check()){
            $user_id=auth('sanctum')->user()->id;
        $validator=Validator::make($req->all(),[
            'firstname'=>'required|max:191',
            'lastname'=>'required|max:191',
            'email'=>'required|max:191',
            'phone'=>'required|max:191',
            'city'=>'required|max:191',
            'address'=>'required|max:191',
            'state'=>'required|max:191',
            'zipcode'=>'required|max:191',

        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{

            $order=new Order;
            $order->user_id=auth('sanctum')->user()->id;
            $order->firstname=$req->firstname;
            $order->lastname=$req->lastname;
            $order->phone=$req->phone;
            $order->email=$req->email;
            $order->city=$req->city;
            $order->address=$req->address;
            $order->state=$req->state;
            $order->zipcode=$req->zipcode;
            $order->payment_mode=$req->payment_mode;
            $order->payment_id=$req->payment_id;
            $order->tracking_no='fundaecom'.rand(1111,9999);
            $order->remark='COD';
            $order->save();

            $cart=Cart::where('user_id',$user_id)->get();
            $orderItems=[];
            foreach($cart as $item){
                $orderItems[]=[
                    'product_id'=>$item->product_id,
                    'qty'=>$item->product_qty,
                    'price'=>$item->product->sellingPrice==0?$item->product->originalPrice:$item->product->sellingPrice,
                ];
                $item->product->update([
                    'qty'=>$item->product->qty - $item->product_qty,
                ]);
            }

            $order->orderitems()->createMany($orderItems);
            Cart::where('user_id',$user_id)->delete();

            return response()->json([
                'status'=>200,
                'message'=>'Order Place Successfully',
            ]);
    }
}else{
        return response()->json([
            'status'=>401,
            'message'=>'Need To L ogin To Cart'
        ]);
    }
}

    public function validateorder(Request $req){

        if(auth('sanctum')->check()){
            $user_id=auth('sanctum')->user()->id;
        $validator=Validator::make($req->all(),[
            'firstname'=>'required|max:191',
            'lastname'=>'required|max:191',
            'email'=>'required|max:191',
            'phone'=>'required|max:191',
            'city'=>'required|max:191',
            'address'=>'required|max:191',
            'state'=>'required|max:191',
            'zipcode'=>'required|max:191',

        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{

            return response()->json([
                'status'=>200,
                'message'=>'Order Place Successfully',
            ]);
    }
     }else{
        return response()->json([
            'status'=>401,
            'message'=>'Need To L ogin To Cart'
        ]);
    }
    }
}