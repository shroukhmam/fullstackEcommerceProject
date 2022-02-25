<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Blogger;
use Illuminate\Support\Facades\Validator;
class BloggerController extends Controller
{
    //
    public function index(){
        $blogger=Blogger::all();
        return response()->json([
            'status'=>200,
            'blogger'=>$blogger,
        ]);

    }
    public function store(Request $req){

        $validator=Validator::make($req->all(),[
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

            $blogger=new Blogger; 
            $blogger->name=$req->input('name');
            $blogger->pharagraph=$req->input('pharagraph');
            if($req->hasFile('image')){
                $file=$req->file('image');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('uploads/product/',$filename);
                $blogger->image='uploads/product/'.$filename;
            }
            

             $blogger->save();
            
            return response()->json([
                'status'=>200,
                'message'=>'blogger Added Successfully',
            ]);
       }
       

    }

    public function edit($id){
        $blogger=blogger::find($id);
        if($blogger){
            return response()->json([
                'status'=>200,
                'blogger'=>$blogger,
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
            $blogger=Blogger::find($id);
            if($blogger){
                $blogger->name=$req->input('name');
                $blogger->pharagraph=$req->input('pharagraph');

                
                if($req->hasFile('image')){
                    $path=$blogger->image;
                    if(file_exists($path)){
                       unlink($path);
                    }  
                    $file=$req->file('image');
                    $extension=$file->getClientOriginalExtension();
                    $filename=time().'.'.$extension;
                    $file->move('uploads/product/',$filename);
                    $blogger->image='uploads/product/'.$filename;
                   
                }

                $blogger->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'blogger Added Successfully',
                ]);

               
           }
        }
    }



    public function destroy($id){
        $blogger=Blogger::find($id);
        if($blogger){
            
            $path=$blogger->image;
            if(file_exists($path)){
               unlink($path);
            }  
            $blogger->delete();
           
           
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
