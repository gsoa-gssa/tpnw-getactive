<?php

namespace App\Notifications\Signup;

use App\Models\Contact;
use App\Models\Event;
use App\Models\Signup;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Reminder extends Notification
{
    use Queueable;

    public Signup $signup;
    public Event $event;
    public Contact $contact;
    public string $language;
    /**
     * Create a new notification instance.
     */
    public function __construct(Signup $signup)
    {
        $this->signup = $signup;
        $this->event = $signup->event;
        $this->contact = $signup->contact ?? Contact::all()->first();
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
                    ->subject(__("emails.signup.reminder.subject", [
                        "event" => $this->event->getTranslatable("name", $this->language),
                    ]))
                    ->from($this->contact->user->email, $this->contact->user->name)
                    ->cc($this->contact->user->email, $this->contact->user->name)
                    ->view('emails.signup.reminder.' . $this->language, [
                        "event" => $this->event,
                        "contact" => $this->contact,
                        "signup" => $this->signup,
                        "language" => $this->language,
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
            "subject" => __("emails.signup.reminder.subject", [
                "event" => $this->event->getTranslatable("name", $this->language),
            ]),
            "body" => view('emails.signup.reminder.' . $this->language, [
                "event" => $this->event,
                "contact" => $this->contact,
                "signup" => $this->signup,
                "language" => $this->language,
            ])->render(),
            "type" => "signupReminder",
        ];
    }
}
