<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Message;
use App\Events\PrivateChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MessageResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;



class ChatController extends Controller
{
    use TraitResponseTrait;
    public function sendPrivateMessage(Request $request)
    {
        $validatedData = $request->validate([
            'content'      => 'required|string',
            'recipient_id' => 'required|exists:users,id',
        ]);
        $user = User::findOrFail($validatedData['recipient_id']);
        PrivateChat::dispatch($user,$validatedData['content']);

       $content = Message::create([
            'user_id'      => Auth::user()->id,
            'content'      => $validatedData['content'],
            'recipient_id' => $validatedData['recipient_id']
        ]);

        return $this->sendResponse(new MessageResource($content), "success", 200);
    }
}
