<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Review;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    //
    public function index(){
       $review=Review::all();
        return response()->json([
            'status'=>200,
            'review'=>$review,
        ]);

    }
    public function store(Request $req){

        $validator=Validator::make($req->all(),[
            'product_id'=>'required',
            'name'=>'required',
            'pharagraph'=>'required|max:191',
            'image'=>'required|image|mimes:jpg,png,jpg|max:2048'


        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'validation_errors'=>$validator->messages(),
            ]);
        }else{

           $review=new Review; 
           $review->product_id=$req->input('product_id');
           $review->name=$req->input('name');
           $review->pharagraph=$req->input('pharagraph');
            if($req->hasFile('image')){
                $file=$req->file('image');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('uploads/product/',$filename);
               $review->image='uploads/product/'.$filename;
            }
            

            $review->save();
            
            return response()->json([
                'status'=>200,
                'message'=>'Review Added Successfully',
            ]);
       }
       

    }

    public function edit($id){
       $review=Review::find($id);
        if($review){
            return response()->json([
                'status'=>200,
                'review'=>$review,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Category Not Found',
            ]);
        }
    }
    public function update(Request $req ,$id){
        $validator=Validator::make($req->all(),[
            'name'=>'required',
            'pharagraph'=>'required|max:191',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'validation_errors'=>$validator->messages(),
            ]);
        }else{
           $review=Review::find($id);
            if($review){
               $review->name=$req->input('name');
               $review->pharagraph=$req->input('pharagraph');

                
                if($req->hasFile('image')){
                    $path=$review->image;
                    if(file_exists($path)){
                       unlink($path);
                    }  
                    $file=$req->file('image');
                    $extension=$file->getClientOriginalExtension();
                    $filename=time().'.'.$extension;
                    $file->move('uploads/product/',$filename);
                   $review->image='uploads/product/'.$filename;
                   
                }

               $review->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Review Updated Successfully',
                ]);

               
           }
        }
    }



    public function destroy($id){
       $review=Review::find($id);
        if($review){
            
            $path=$review->image;
            if(file_exists($path)){
               unlink($path);
            }  
           $review->delete();
           
           
            return response()->json([
                'status'=>200,
                'message'=>'DeleteSuccessfully'
            ]);
        }else{
            
            return response()->json([
                'status'=>404,
                'message'=>'Category Not Found',
            ]);
        }
    }
}
