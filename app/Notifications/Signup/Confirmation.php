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
use Illuminate\Support\Facades\Log;

class Confirmation extends Notification
{
    use Queueable;

    public Signup $signup;
    public Event $event;
    public Contact $contact;
    public User $user;
    public string $language;
    private array $ccEmails;
    private array $bccEmails;

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

        // add the volunteer's contact person and the event's contact person to the CC list
        $this->ccEmails = [
            $this->user->name => $this->user->email,
            $this->event->contact->name => $this->event->contact->email
        ];
        // if the second email is the same as the first, remove second entry
        if ($this->ccEmails[$this->user->name] === $this->ccEmails[$this->event->contact->name]) {
            unset($this->ccEmails[$this->event->contact->name]);
        }

        // add all responsible users of the event to the BCC list if they are not already in the CC list
        $this->bccEmails = [];
        $responsibleUsers = $this->event->users->map(function ($user) {
            return [$user->email, $user->name];
        })->toArray();
        foreach ($responsibleUsers as $user) {
            if (!in_array($user, $this->ccEmails)) {
                $this->bccEmails[$user[1]] = $user[0];
            }
        }

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
                    ->cc($this->ccEmails)
                    ->bcc($this->bccEmails)
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
