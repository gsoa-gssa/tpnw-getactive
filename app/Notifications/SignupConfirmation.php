<?php

namespace App\Notifications;

use App\Models\Signup;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SignupConfirmation extends Notification
{
    use Queueable;

    public Signup $signup;
    public User $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Signup $signup, User $user)
    {
        $this->signup = $signup;
        $this->user = $user;
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
            ->subject(__("emails.signup_confirmation.subject"))
            ->from($this->user->email, $this->user->name)
            ->view('emails.signup_confirmation.' . app()->getLocale(), [
                "signup" => $this->signup,
                "contact" => $this->contact,
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
