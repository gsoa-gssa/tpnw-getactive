<?php

namespace App\Console\Commands\Contacts;

use App\Models\Contact;
use App\Settings\ContactAssign;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Mail;
use function Laravel\Prompts\confirm;

class AssignOrphans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contacts:autoassign {--dry-run=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign orphans to users based on canton rules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('dry-run') === 'true') {
            $this->info('Dry run enabled. No changes will be saved.');
        } else {
            $this->info('Dry run disabled. Changes will be saved.');
            $confirmed = confirm('Are you sure you want to continue?');
            if (!$confirmed) {
                $this->info('Command cancelled.');
                return;
            }
        }

        $this->info('Assigning contacts to users...');
        $contactAssign = app(ContactAssign::class);

        // Get all contacts that are not assigned to a user
        $contacts = Contact::whereNull('user_responsible_id')->get();
        $orphans = [];
        $assigned = 0;

        foreach ($contacts as $contact) {
            $this->info("Assigning contact {$contact->id} to a user...");
            if (!$contact->canton) {
                $this->error("Contact {$contact->id} has no canton.");
                $orphans[] = $contact;
                continue;
            }

            $user = array_values(array_filter($contactAssign->canton_rules, function ($user) use ($contact) {
                return $user["canton"] === $contact->canton;
            }))[0]["user_id"] ?? null;

            if (!$user) {
                $this->error("No user found for canton {$contact->canton}.");
                $orphans[] = $contact;
                continue;
            }

            $contact->user_responsible_id = $user;
            $assigned++;
            $this->info("Assigned contact {$contact->id} to user {$user}.");
            if ($this->option('dry-run') === 'false') {
                $contact->save();
            }
        }

        if (count($orphans) > 0) {
            $this->info('Orphan contacts: ' . count($orphans));
            foreach ($orphans as $orphan) {
                $this->info("Orphan contact: {$orphan->email}");
            }

            $sendEmail = confirm('Do you want to send an email with the orphan contacts to a user?');
            if ($sendEmail) {
                $user = select(
                    'Select a user to send the email to:',
                    \App\Models\User::pluck('name', 'email')
                );
                $orphanCSV = [];
                $orphanCSV[] = ['id', 'firstname', 'lastname', 'email', 'canton', 'zip'];
                foreach ($orphans as $orphan) {
                    $orphanCSV[] = [$orphan->id, $orphan->firstname, $orphan->lastname, $orphan->email, $orphan->canton, $orphan->zip];
                }
                $csv = \League\Csv\Writer::createFromString('');
                $csv->insertAll($orphanCSV);
                $this->info('Sending email...');
                // Send email with orphan contacts
                Mail::raw("Ophan Contacts for export " . now(), function ($message) use ($csv, $user) {
                    $message->to($user)
                        ->subject('Orphan Contacts')
                        ->attachData($csv->toString(), 'orphans-' . now() . '.csv', [
                            'mime' => 'text/csv',
                        ])
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });

            }
        }

        $this->info("Assigned {$assigned} contacts to users.");
        $this->info('Command completed.');
    }
}
