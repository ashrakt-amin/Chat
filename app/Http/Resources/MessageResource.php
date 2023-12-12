<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'content'      => $this->content,
            'user_id'      =>  $this->user_id,
            'recipient_id' =>  $this->recipient_id,
        ];
    }
}
