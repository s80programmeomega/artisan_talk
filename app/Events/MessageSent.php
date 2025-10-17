<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Message $message
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('chat.' . $this->message->conversation_id),
        ];
        // switch ($this->message->conversation_type) {
        //     case 'chat':
        //         return [
        //             new PresenceChannel('chat.' . $this->message->conversation_id),
        //         ];

        //     case 'group':
        //         return [
        //             new PresenceChannel('group.' . $this->message->conversation_id),
        //         ];
        //     default:
        //         return [];
        // }
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message->load('sender'),
            'chat_id' => $this->message->conversation_id
        ];
    //     switch ($this->message->conversation_type) {
    //         case 'chat':
    //             return [
    //                 'message' => $this->message->load('sender'),
    //                 'chat_id' => $this->message->conversation_id
    //             ];
    //         case 'group':
    //             return [
    //                 'message' => $this->message->load('sender'),
    //                 'group_id' => $this->message->conversation_id
    //             ];
    //         default:
    //             return [];
    //     }
    }
}
