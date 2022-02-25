<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
class AuthController extends Controller
{
    //
    public function register(Request $req){
        $validator=Validator::make($req->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users,email|max:191',
            'password'=>'required|min:8',
        ]);
        if($validator->fails()){
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }else{
            $user=User::create([
                'name'=>$req->name,
                'email'=>$req->email,
                'password'=>Hash::make($req->password)
            ]);
            $token=$user->createToken($user->email.'_Token')->plainTextToken;
            return response()->json([
                'status'=>200,
                'username'=>$user->name,
                'token'=>$token,
                'message'=>'RegisterSuccessfully',
            ]);
        }
       
    }

    public function login(Request $request){
        $validator=Validator::make($request->all(),[
           
            'email'=>'required|max:191',
            'password'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }else{
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'=>401,
                    'message'=>'Login Incorrect',
                ]);
            }else{
                if($user->role_as==1){
                    $role='admin';
                    $token=$user->createToken($user->email.'_AdminToken',['server:admin'])->plainTextToken;
                }else{
                    $role='';
                    $token=$user->createToken($user->email.'_Token',[''])->plainTextToken;
                }
                
                return response()->json([
                    'status'=>200,
                    'username'=>$user->name,
                    'token'=>$token,
                    'message'=>'LoginSuccessfully',
                    'role'=>$role
                ]);
            }
            
        }
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'LogoutSuccessfully',
        ]);
    }
}
