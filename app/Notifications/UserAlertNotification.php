<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserAlertNotification extends Notification
{
    use Queueable;

    public $type;
    public $title;
    public $message;
    public $sender;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $title, $message, $sender)
    {
        $this->type = $type;
        $this->title = $title;
        $this->message = $message;
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'sender' => $this->sender,
        ];
    }
}
