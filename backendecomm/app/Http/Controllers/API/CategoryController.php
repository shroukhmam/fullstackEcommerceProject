<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //

    public function index(){
        $category=Category::all();
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);

    }
    public function store(Request $req){

        $validator=Validator::make($req->all(),[
            'name'=>'required|max:191',
            'slug'=>'required|max:191',
            'title'=>'required|min:8',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'validation_errors'=>$validator->messages(),
            ]);
        }else{

            $category=new Category;
            $category->name=$req->input('name');
            $category->slug=$req->input('slug');
            $category->description=$req->input('description');
            $category->status=$req->input('status')==true?'1':'0';
            $category->title=$req->input('title');
            $category->metakeyword=$req->input('metakeyword');
            $category->metadescription=$req->input('metadescription');
            $category->save();
            
            return response()->json([
                'status'=>200,
                'message'=>'Category Added Successfully',
            ]);
        }
       

    }


    public function edit($id){
        $category=Category::find($id);
        if($category){
            return response()->json([
                'status'=>200,
                'category'=>$category,
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
            'name'=>'required|max:191',
            'slug'=>'required|max:191',
            'title'=>'required|min:8',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }else{

            $category=Category::find($id);
            if($category){
                $category->name=$req->input('name');
                $category->slug=$req->input('slug');
                $category->description=$req->input('description');
                $category->status=$req->input('status')==true?'1':'0';
                $category->title=$req->input('title');
                $category->metakeyword=$req->input('metakeyword');
                $category->metadescription=$req->input('metadescription');
                $category->save();
                
                return response()->json([
                    'status'=>200,
                    'message'=>'Category Added Successfully',
                ]);
            }else{

                return response()->json([
                    'status'=>404,
                    'message'=>'Category Not Found',
                ]);
            }
            
        }
       

    }


    public function destroy($id){
        $category=Category::find($id);
        if($category){
            $category->delete();
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
    public function allcategory(){
        $category=Category::where('status','1')->get();
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);
    }
    
}
