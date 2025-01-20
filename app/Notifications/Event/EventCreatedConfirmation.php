<?php

namespace App\Notifications\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreatedConfirmation extends Notification
{
    use Queueable;

    public \App\Models\Event $event;
    public \App\Models\Contact $contact;

    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\Event $event)
    {
        $this->event = $event;
        $this->contact = $event->contact;
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
            ->subject(__('emails.event.created.confirmation.subject', locale: $this->contact->language))
            ->from($this->contact->user->email, $this->contact->user->name)
            ->view('emails.event.created.confirmation.' . $this->contact->language, [
                'event' => $this->event,
                'contact' => $this->contact,
                'user' => $this->contact->user,
            ]);
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
