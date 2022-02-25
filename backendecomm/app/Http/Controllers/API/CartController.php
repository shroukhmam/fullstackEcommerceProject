<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Cart;
class CartController extends Controller
{
    //

    public function addToCart(Request $req){
        if(auth('sanctum')->check()){

            $user_id=auth('sanctum')->user()->id;
            $product_id=$req->product_id;
            $product_qty=$req->product_qty;
            $productChecked=Product::where('id',$product_id)->first();
            if($productChecked){
                if(Cart::where('product_id',$product_id)->where('user_id',$user_id)->exists()){

                    return response()->json([
                        'status'=>409,
                        'message'=>'Already Added To Cart'
                    ]);
                }else{

                    $cartitem=new Cart;
                    $cartitem->user_id=$user_id;
                    $cartitem->product_id=$product_id;
                    $cartitem->product_qty=$product_qty;
                    $cartitem->color=$req->color;
                    $cartitem->size=$req->size;
                    $cartitem->save();

                    return response()->json([
                        'status'=>201,
                        'message'=>'Added Successfully in Cart'
                    ]);
                }
    
               
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Product Not Found',
                ]);
            }
    
        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Need To L ogin To Cart'
            ]);
            

        }
      
    }


    public function getCart(){
        if(auth('sanctum')->check()){
           $user_id=auth('sanctum')->user()->id;
           $cart=Cart::where('user_id',$user_id)->get();
           
           return response()->json([
            'status'=>200,
            'cart'=>$cart
        ]);
        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Need To L ogin To Cart'
            ]);
            

        }
    }
    public function updateCart($id,$scope){
        if(auth('sanctum')->check()){
            $user_id=auth('sanctum')->user()->id;
           $cart=Cart::where('id',$id)->where('user_id',$user_id)->first();
           if($scope=='inc'){
               $cart->product_qty+=1;
           }else if($scope=='dec'){
            $cart->product_qty-=1;
           }
           $cart->save();
           return response()->json([
            'status'=>200,
            'cart'=>$cart
        ]);
        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Need To L ogin To Cart'
            ]);
            

        }
    }


    public function deleteCart($id){
        if(auth('sanctum')->check()){
            $user_id=auth('sanctum')->user()->id;
           $cart=Cart::where('id',$id)->where('user_id',$user_id)->first();
           $cart->delete();
           return response()->json([
            'status'=>200,
            'cart'=>$cart
        ]);
        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Need To L ogin To Cart'
            ]);
            

        }
    }
    public function deleteAllCart(){
        if(auth('sanctum')->check()){
            $user_id=auth('sanctum')->user()->id;
           $cart=Cart::where('user_id',$user_id)->get();
           $cart->delete();
           return response()->json([
            'status'=>200,
            'cart'=>$cart
        ]);
        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Need To L ogin To Cart'
            ]);
            

        }
    }
}
