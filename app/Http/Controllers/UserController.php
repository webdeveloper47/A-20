<?php

namespace App\Http\Controllers;
use App\Helper\JWTtoken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;


class UserController extends Controller
{
    function UserRegistration(Request $request){
           try{
                User::create([
                    'firstName' => $request->input('firstName'),
                    'lastName' => $request->input('lastName'),
                    'email' => $request->input('email'),
                    'mobile' => $request->input('mobile'),
                    'password' => $request->input('password')
                ]);


                return response()->json([
                    "status"=>"Success",
                    "message"=>"User Registration Successfully"
                ]);
           } catch(Exception $e){

                return response()->json([
                    "status"=>"Failed",
                    "message"=>"User Registration Failed"
                ]);
           }

    }


    function UserLogin(Request $request){
       $count= User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))  
            ->count();


        if($count==1){

           $token = JWTtoken::CreateToken($request->input('email'));
           
            return response()->json([
            "status"=>"success",
            "message"=>"User Login Successfully",
            "token" => $token
        ]);

        }else{
            return response()->json([
                "status"=>"Failed",
                "message"=>"Unauthorized"
            ]);
        }
    }
}
