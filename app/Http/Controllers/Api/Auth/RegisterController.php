<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Jobs\SendEmailJob;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\AuthGuardTrait as TraitResponseAuth;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class RegisterController extends Controller
{
    use TraitResponseTrait, TraitResponseAuth;

    public function userRegister(UserRequest $request)
    {
        $data = $request->validated();
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'phone'    => $data['phone'],
                'password' => bcrypt($data['password']),
            ]);

            $token =  $user->createToken('api', ['role:api'])->plainTextToken;
            $user->update([
                'api_token'       =>  $token
            ]);

            return $this->sendResponse([
                'token'           => $token,
                'id'              => $user->id,
                'name'            => $user->name,
                'email'           => $user->email,
                'phone'           => $user->phone,
    
            ], 'User register successfully.', 200);
               
        }

        public function adminRegister(UserRequest $request)
        {
            $data = $request->validated();
                $admin = Admin::create([
                    'name'     => $data['name'],
                    'email'    => $data['email'],
                    'phone'    => $data['phone'],
                    'password' => bcrypt($data['password']),
                ]);
    
                $token =  $admin->createToken('admin-api', ['role:admin'])->plainTextToken;
                $admin->update([
                    'api_token'       =>  $token
                ]);
                
                return $this->sendResponse([
                    'token'           => $token,
                    'id'              => $admin->id,
                    'name'            => $admin->name,
                    'email'           => $admin->email,
                    'phone'           => $admin->phone,
        
                ], 'Admin register successfully.', 200);
                   
            }
    

    public function showUser()
    {
       $user = Auth::user();
        if ($user) {
            return response()->json([
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'data' => 'false'
            ], 500);
        }
    }
}
