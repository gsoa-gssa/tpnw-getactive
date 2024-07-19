<?php

namespace App\Notifications\Signup;

use App\Models\User;
use App\Models\Event;
use App\Models\Signup;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Confirmation extends Notification
{
    use Queueable;

    public Signup $signup;
    public Event $event;
    public Contact $contact;
    public User $user;
    public string $language;

    /**
     * Create a new notification instance.
     */
    public function __construct(Signup $signup)
    {
        $this->signup = $signup;
        $this->event = $signup->event;
        $this->contact = $signup->contact;
        $this->user = $this->contact->user ?? User::all()->first();
        $this->language = $this->contact->language ?? "de";

        app()->setLocale($this->language);
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
                    ->subject(__("emails.signup.confirmation.subject", [
                        "event" => $this->event->getTranslatable("name", $this->language),
                    ]))
                    ->from($this->user->email, $this->user->name)
                    ->view('emails.signup.confirmation.' . $this->language, [
                        "event" => $this->event,
                        "contact" => $this->contact,
                        "signup" => $this->signup,
                        "language" => $this->language,
                        "user" => $this->user,
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
            "subject" => __("emails.signup.confirmation.subject", [
                "event" => $this->event->getTranslatable("name", $this->language),
            ]),
            "body" => view('emails.signup.confirmation.' . $this->language, [
                "event" => $this->event,
                "contact" => $this->contact,
                "signup" => $this->signup,
                "language" => $this->language,
                "user" => $this->user,
            ])->render(),
            "type" => "signupConfirmation",
        ];
    }
}
