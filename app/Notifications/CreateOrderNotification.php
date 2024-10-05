<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Notification;

class CreateOrderNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $user,public $order)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id, 
            'name' => $this->user->name, 
            'Email' => $this->user->name, 
            'order_id' => $this->order->id, 
            'message' => $this->user->name . 'create new order',
        ];
    }

    /**
     * Get the broadcast data representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toBroadcast(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id, 
            'name' => $this->user->name, 
            'Email' => $this->user->email, 
            'order_id' => $this->order->id, 
            'message' => $this->user->name . ' created a new order',
        ];
    }

    /**
     * The broadcast channel that the notification will be sent on.
     *
     * @return string
     */
    public function broadcastOn()
    {
        // Broadcasting on a private channel
        return ['orders'];
    }

    public function broadcastAs()
    {
        return 'CreateOrderNotification';
    }
}
