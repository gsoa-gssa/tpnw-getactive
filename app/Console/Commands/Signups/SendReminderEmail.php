<?php

namespace App\Console\Commands\Signups;

use Illuminate\Console\Command;

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

        /**
         * Get All Events that are happening within the next two days
         */
        $events = \App\Models\Event::whereDate('date', "<=", now()->addDays(2)->toDateString())->whereDate('date', '>', now()->toDateString())->get();

        if ($events->isEmpty()) {
            $this->info('No events found for the next two days.');
            return;
        } else {
            $line = "Events found for the next two days: ";
            foreach ($events as $event) {
                $line .= "{$event->getTranslatable('name', 'de')} ({$event->date->format('d.m.Y')}), ";
            }
            $this->info($line);
        }
        /**
         * Get all signups for the events with status confirmed and doesn't have email notifications where emailNotification.type is signupReminder
         */
        $signups = \App\Models\Signup::whereIn('event_id', $events->pluck('id'))->where('status', 'confirmed')->whereDoesntHave('emailNotifications', function ($query) {
            $query->where('type', 'signupReminder');
        })->get();
        if ($signups->isEmpty()) {
            $this->info('No unreminded signups found for these events.');
            return;
        }

        /**
         * Loop through the signups and send reminder emails
         */
        foreach ($signups as $signup) {
            $this->info("Sending reminder email to {$signup->contact->email} for event {$signup->event->getTranslatable('name', $signup->contact->language)}");
            $notification = new \App\Notifications\Signup\Reminder($signup);
            $signup->contact->notify($notification);
            $data = $notification->toArray($signup->contact);
            $emailNotification = \App\Models\EmailNotification::create([
                'subject' => $data['subject'],
                'body' => $data['body'],
                'user_id' => $signup->contact->user->id,
                'contact_id' => $signup->contact->id,
                'signup_id' => $signup->id,
                'type' => $data['type'],
            ]);
            $this->info("Email notification created with ID {$emailNotification->id}");
        }
    }
}
