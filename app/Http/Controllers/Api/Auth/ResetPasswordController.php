<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\updatepaswrdRequest;
use App\Http\Requests\checkCodeRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Jobs\sendCodeJob;



class ResetPasswordController extends Controller
{
    use TraitResponseTrait;

    public function chechEmail(Request $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);

    }else{

        $code = random_int(1000, 9999);
        $email = $request->email;
        $name = $user->name;
        sendCodeJob::dispatch($code , $email ,$name);
         
        //Mail::to($request->email)->send(new ResetPassword($mailData)); 
        $user->update(['code'=>$code]); 
        return $this->sendResponse([
            'email'           => $user->email,
        ], 'we sent code to email.', 200);

     }

}


public function checkCode(checkCodeRequest $request)
{
    $data = $request->validated();
    $user = User::where('code', $data['code'])->first();
    if($user){
        return $this->sendResponse([
            'code'   => $user->code,
            'email'  => $user->email,
        ], 'correct code.', 200);
    }else{
        return response()->json(['message' => 'error code'], 404);

       }
}

public function resetPassword(updatepaswrdRequest $request)
{
    $data = $request->validated();
    $user = User::where('email', $data['email'])->first();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);

    }else{
         if( $user->code == $data['code']){
        $user->update([
                'password' => bcrypt($data['password']),
                'code'     => NULL
        ]); 
                
        $token =  $user->createToken('token')->plainTextToken;
        return $this->sendResponse([
                'token'           => $token,
                'id'              => $user->id,
                'name'            => $user->name,
                'email'           => $user->email,
                'phone'           => $user->phone,
    
            ], 'password reset successfully.', 200);

           }else{
            return response()->json(['message' => 'error code'], 404);

           }
          }
         }

        }

