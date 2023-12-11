<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\AuthGuardTrait as TraitResponseAuth;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class AdminLoginController extends Controller
{
    use TraitResponseTrait, TraitResponseAuth;

    public function login(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $admin->createToken('admin-api', ['role:admin'])->plainTextToken;
        $admin->update([
            'api_token'       =>  $token
        ]);

        return response()->json([
            'admin' => $admin,
            'token' => $token,
        ]);
    }
}
