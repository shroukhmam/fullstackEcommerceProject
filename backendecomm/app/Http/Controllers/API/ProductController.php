<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Size;
use App\Model\Color;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Model\Image;
class ProductController extends Controller
{
    //

    public function index(){
        $product=Product::all();
        return response()->json([
            'status'=>200,
            'product'=>$product,
        ]);

    }

    public function store(Request $req){

        $validator=Validator::make($req->all(),[
            'category_id'=>'required|max:191',
            'name'=>'required|max:191',
            'slug'=>'required|max:191',
            'title'=>'required',
            'brand'=>'required|max:20',
            'sellingPrice'=>'required|max:20',
            'originalPrice'=>'required|max:20',
            'qty'=>'required|max:4',
            'sizes' => 'required|array',
            'colors' => 'required|array',
           // 'image'=>'required|image|mimes:jpg,png,jpg|max:2048'


        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'validation_errors'=>$validator->messages(),
            ]);
        }else{

            $product=new Product;


           
            
            $product->category_id=$req->input('category_id');
            $product->name=$req->input('name');
            $product->slug=$req->input('slug');
            $product->description=$req->input('description');
            
            $product->status=$req->input('status')==true?'1':'0';
            $product->feature=$req->input('feature')==true?'1':'0';
            $product->popular=$req->input('popular')==true?'1':'0';

            $product->title=$req->input('title');
            $product->metakeyword=$req->input('metakeyword');
            $product->metadescription=$req->input('metadescription');
            
            if($req->hasFile('image')){
                $file=$req->file('image');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('uploads/image/',$filename);
                $product->image='uploads/image/'.$filename;
            }
            //$product->image='uploads/product/';
            $product->brand=$req->input('brand');
            $product->qty=$req->input('qty');
            $product->sellingPrice=$req->input('sellingPrice');
            $product->originalPrice=$req->input('originalPrice');

             $product->save();
             $insertedId = $product->id;
            foreach($req->sizes as $onesize) {
                   
                $size=new Size;
                $size->product_id=$insertedId;
                $size->size=$onesize;
                $size->save();
             }
             foreach($req->colors as $onecolor) {
                   
                $color=new Color;
                $color->product_id=$insertedId;
                $color->color=$onecolor;
                $color->save();
             }
            return response()->json([
                'status'=>200,
                'message'=>'product Added Successfully',
            ]);
        }
       

    }


    public function edit($id){
        $product=Product::find($id);
        $size=Size::where('product_id',$id);
        if($product){
            return response()->json([
                'status'=>200,
                'product'=>$product,
                'size'=>$size,
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
            'category_id'=>'required|max:191',
            'name'=>'required|max:191',
            'slug'=>'required|max:191',
            'title'=>'required',
            'brand'=>'required|max:20',
            'sellingPrice'=>'required|max:20',
            'originalPrice'=>'required|max:20',
            'qty'=>'required|max:4',
            //'image'=>'required|image|mimes:jpg,png,jpg|max:2048'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }else{

            $product=Product::find($id);
            if($product){
            $product->category_id=$req->input('category_id');
            $product->name=$req->input('name');
            $product->slug=$req->input('slug');
            $product->description=$req->input('description');
            
            $product->status=$req->input('status')==true?'1':'0';
            $product->feature=$req->input('feature')==true?'1':'0';
            $product->popular=$req->input('popular')==true?'1':'0';

            $product->title=$req->input('title');
            $product->metakeyword=$req->input('metakeyword');
            $product->metadescription=$req->input('metadescription');
            
            // if($req->hasFile('image')){
            //     $file=$req->file('image');
            //     $extension=$file->getClientOriginalExtension();
            //     $filename=time().'.'.$extension;
            //     $file->move('uploads/image/',$filename);
            //     $product->image='uploads/image/'.$filename;
            // }
            
            $product->brand=$req->input('brand');
            $product->qty=$req->input('qty');
            $product->sellingPrice=$req->input('sellingPrice');
            $product->originalPrice=$req->input('originalPrice');

             $product->save();
             if(count($req->sizes)> 0){
                Size::where('product_id',$id)->delete();
             }
             
             foreach($req->sizes as $onesize) {
                   
                $size=new Size;
                $size->product_id=$id;
                $size->size=$onesize;
                $size->save();
            }
            if(count($req->colors)> 0){
                Color::where('product_id',$id)->delete();
             }

             foreach($req->colors as $onecolor) {
                   
                $color=new Color;
                $color->product_id=$id;
                $color->color=$onecolor;
                $color->save();
            }
             
             
                
                return response()->json([
                    'status'=>200,
                    'message'=>'Product Updated Successfully',
                ]);
            }else{

                return response()->json([
                    'status'=>404,
                    'message'=>'Product Not Found',
                ]);
            }
            
        }
       

    }


    public function destroy($id){
        $product=Product::find($id);
        if($product){
            //DB::beginTransaction();
            $product->delete();
            $images=Image::where('product_id',$id)->get();
            if($images){
                foreach($images as $image){
                    $path=$image->picture;
                    if(file_exists($path)){
                       unlink($path);
                      $image->delete();
                   
                     }
                }
            }
            //DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'DeleteSuccessfully'
            ]);
        }else{
            //DB::rollback();
            return response()->json([
                'status'=>404,
                'message'=>'Category Not Found',
            ]);
        }
    }


    public function showAll($category){
        $product=Product::where('category_id',$category)->get();
        if($product){
            return response()->json([
                'status'=>200,
                'product'=>$product,
            ]);
        }
    }

    public function showAllCategoryProduct(){
        $product=Product::where('status','1')->get();
        if($product){
            return response()->json([
                'status'=>200,
                'product'=>$product,
            ]);
        }
    }


    public function getOneProduct($id){
        $product=Product::find($id);
        $category=Product::where('category_id',$product->category_id)->get();
        if($product){
            return response()->json([
                'status'=>200,
                'product'=>$product,
                'category'=>$category,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Category Not Found',
            ]);
        }
    }
}
