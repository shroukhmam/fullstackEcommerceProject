<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Image;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    //
    public function store($id,Request $req){
        $validator=Validator::make($req->all(),[
            'product_id'=>'required|max:191',
            'picture'=>'required'
            


        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'validation_errors'=>$validator->messages(),
            ]);
        }else{

            $pictures=new Image;
           
           
            if( $req->hasFile('picture') ) {

                

                 foreach($req->file('picture') as $image) {
        
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->move('uploads/product/', $imageName);
        
                   
                     $pictures->product_id=$req->input('product_id');
                     $pictures->picture='uploads/product/'.$imageName;
                    $pictures->save();

              
                 }

            
                 return response()->json([
                    'status'=>200,
                    'message'=>'product Added Successfully',
                ]);
        

                
              
        
            }
        
            

        
       
        }
    }

    public function index($id){
        $image=Image::where('product_id',$id)->get();
        if($image){
            return response()->json([
                'status'=>200,
                'image'=>$image,
            ]);
    
        }
    
    }

    public function destroy($id){
        $image=Image::find($id);
        if($image){

            $path=$image->picture;
           if(file_exists($path)){
              unlink($path);
              $image->delete();
                return response()->json([
                    'status'=>200,
                   
                ]);
           }else{
            return response()->json([
                'status'=>404,
                'message'=>'Not Found',
            ]);
           }

           
    
        }
    
    }
}