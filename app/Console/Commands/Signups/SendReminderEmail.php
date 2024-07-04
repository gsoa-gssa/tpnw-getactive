<?php

namespace App\Console\Commands\Signups;

use Illuminate\Console\Command;
use SendGrid;

class SendReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signups:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to contacts with upcoming signups.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all events that are two or less days out
        $upcomingEvents = \App\Models\Event::whereDate('date', '<=', now()->addDays(2))
            ->whereDate('date', '>=', now())
            ->where("reassign", false)
            ->get();

        // Get all signups for the upcoming events that have status "confirmed"
        $signups = \App\Models\Signup::whereIn('event_id', $upcomingEvents->pluck('id'))
            ->where('status', 'confirmed')
            ->get();

        // Foreach signup, send a reminder email
        $sdg = new SendGrid(env('SDG_API_KEY'));
        foreach ($signups as $signup) {
            $contact = $signup->contact;
            $event = $signup->event;
            $contact->user = $contact->user ?? \App\Models\User::find(1);
            $contact->userDetails = \App\Models\Contact::where("email", $contact->user->email)->first();
            $mail = new SendGrid\Mail\Mail();
            try {
                $mail->setFrom($contact->user->email, $contact->user->name);
                $mail->setSubject(__('emails.signup_reminder.subject', ['event' => $event->getTranslatable('name', $contact->language)]));
                $mail->addTo($contact->email, $contact->name);
                $mail->addCc($contact->user->email, $contact->user->name);
                $mail->addContent("text/html", view('emails.signupReminder.' . $contact->language, compact('contact', 'event', 'signup'))->render());
                $response = $sdg->send($mail);
            } catch (\Exception $e) {
                $this->error('Error sending email to ' . $contact->email . ': ' . $e->getMessage());
            }

            dd($response);
        }
    }
}
