<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class UserController extends Controller
{
    use TraitResponseTrait;

    public function index()
    {
        $users = User::whereNotIn('id', [Auth::user()->id])->get();
        return $this->sendResponse(UserResource::collection($users), "success", 200);
    }

    public function updateOnlineStatus(Request $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        $user->is_online = $request->input('is_online');
        $user->save();

        return response()->json(['status' => 'success']);
    }
}
