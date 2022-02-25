<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Size;
use App\Model\Color;
class FeatureController extends Controller
{
    //
    public function destroySize(Request $req,$id){
         $size=Size::where('size',$req->size)->where('product_id',$id)->first();
        if($size){
            $size->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Deleted Successfully',
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Feature Size Found',
            ]);
        }
    }
    public function destroyColor(Request $req,$id){
        $color=Color::where('color',$req->color)->where('product_id',$id)->first();
       if($color){
           $color->delete();
           return response()->json([
               'status'=>200,
               'message'=>'Deleted Successfully',
           ]);
       }else{
           return response()->json([
               'status'=>404,
               'message'=>'No Feature Color Found',
           ]);
       }
   }
}
