<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class Apis extends Controller
{
    
    public function register(Request $request){ 
      
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            // 'c_password'=>'required|same:password'
        ]);

        if($validator->fails()){
            return response()->json(['status'=>false,$validator->errors(), 202]);
        }
        $exists = user::where('email',$request->email)->first();
        if($exists){
            return response()->json(['status'=>false,'message'=>'User already exists']);
           }
           $input = $request->all();
           $input ['password']= bcrypt($input['password']);
           $user =User::create($input);
        //    $student = new User();
        //    $student->name = $request->name;
        //    $student->email = $request->email;
        //    $student->password = $request->password;
        //    $student->c_password = $request->c_password;
        //    $student->save();
        
           $responseArray = [];
           $responseArray['token'] = $user->createToken('MyApp')->accessToken;
           $responseArray['name'] = $user->name;
        return response()->json(['status'=>true,'message'=>'Successfully Registered',$responseArray]);
    }

    /// login //////

    public function login(Request $request){ 
        $data = $request->all();
        $validator = Validator::make($data,[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->messages()]);
       }
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            $responseArray = [];
            $responseArray['token'] = $user->createToken('MyApp')->accessToken;
            $responseArray['name'] = $user->name;
            
            return response()->json(['status'=>true,'data' => $responseArray,200]);

        }else{
            return response()->json([ 'status'=>false, 'error'=>'Unauthenticated'],203);
        }
    }

    public function getTaskList(){
        $id = Auth::id();
        dd($id);
        $data =  User::all();
        $responseArray = [
            'status'=>'ok',
            'data'=>$data
        ]; 
        return response()->json($responseArray,200);
    }
}
