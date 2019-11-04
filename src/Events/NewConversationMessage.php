<?php

namespace Wqqas1\LaravelVideoChat\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Auth\User;

class NewConversationMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var
     */
    public $text;
    /**
     * @var
     */
    public $channel;
    /**
     * @var array
     */
    private $files;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new event instance.
     *
     * @param $text
     * @param $channel
     * @param array $files
     * @param User $user
     */
    public function __construct($text, $channel, $files = [], $user = null)
    {
        $this->text = $text;
        $this->channel = $channel;
        $this->files = $files;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel($this->channel);
    }

    public function broadcastWith()
    {
        return [
            'text'       => $this->text,
            'sender'     => $this->user,
            'files'      => $this->files,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}
