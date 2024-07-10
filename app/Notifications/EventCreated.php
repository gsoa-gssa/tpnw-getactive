<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreated extends Notification
{
    use Queueable;

    public $event;
    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line('Someone has created a new event in your canton. Please review the event details. If you are satisfied, you can publish the event by clicking on the button in the top right corner.')
                    ->action('View Event', url('/admin/events/' . $this->event->id))
                    ->line('Have a splendid day!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
