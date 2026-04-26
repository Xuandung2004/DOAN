<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Bắt buộc phải có chữ "implements ShouldBroadcastNow" để tin nhắn bay đi ngay lập tức
class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Xác định kênh phát sóng (Gửi thẳng vào kênh Private của người nhận)
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->nguoinhanID),
        ];
    }
}