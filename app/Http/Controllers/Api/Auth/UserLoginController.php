<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\AuthGuardTrait as TraitResponseAuth;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class UserLoginController extends Controller
{
    use TraitResponseTrait, TraitResponseAuth;

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
   
        $token = $user->createToken('api', ['role:api'])->plainTextToken;
        $user->update([
            'api_token'       =>  $token
        ]);
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

  
}
