<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class SignupReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $event;
    public $signup;
    /**
     * Create a new message instance.
     */
    public function __construct($contact, $event, $signup)
    {
        $this->contact = $contact;
        $this->event = $event;
        $this->signup = $signup;
        $this->contact->user = $contact->user ?? \App\Models\User::find(1);
        $this->contact->userDetails = \App\Models\Contact::where("email", $contact->user->email)->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __("emails.signup_reminder.subject", ['event' => $this->event->getTranslatable('name', $this->contact->language)]),
            from: new Address (
                address: $this->contact->user->email,
                name: $this->contact->user->name,
            ),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.signupReminder.' . $this->contact->language,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
