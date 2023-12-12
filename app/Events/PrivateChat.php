<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrivateChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

        public $content ;
    
        public function __construct($content , public User $user)
        {
            $this->$content = $content;
         //   $this->$user = $user;

        }
    
        public function broadcastOn()
        {
            return new PrivateChannel("PrivateChat.user.".$this->user->id);
        }

      
        public function broadcastAs()
        {
            return 'PrivateChat';
        }
}
