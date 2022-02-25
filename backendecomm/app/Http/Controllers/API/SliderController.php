<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Slider;
use Illuminate\Support\Facades\Validator;


class SliderController extends Controller
{
    //

    public function index(){
        $slider=Slider::all();
        return response()->json([
            'status'=>200,
            'slider'=>$slider,
        ]);

    }
    public function store(Request $req){

        $validator=Validator::make($req->all(),[
            'pharagraph'=>'required|max:191',
            'image'=>'required|image|mimes:jpg,png,jpg|max:2048'


        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'validation_errors'=>$validator->messages(),
            ]);
        }else{

            $slider=new Slider; 
            $slider->pharagraph=$req->input('pharagraph');
            if($req->hasFile('image')){
                $file=$req->file('image');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('uploads/product/',$filename);
                $slider->image='uploads/product/'.$filename;
            }
            

             $slider->save();
            
            return response()->json([
                'status'=>200,
                'message'=>'Slider Added Successfully',
            ]);
        }
       

    }
}
