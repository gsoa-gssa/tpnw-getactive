<?php

namespace App\Console\Commands\Contacts;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;

class AssignCantons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contacts:assign-cantons {--dry-run=false} {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Cantons to Contacts based on their zip code.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option("y")) {
            $this->info('EXECUTING IN AUTO MODE');
            $this->info("START TIME: " . now());
        }

        if ($this->option('dry-run') === 'true') {
            $this->info('Dry run enabled. No changes will be saved.');
        } else if (!$this->option('y') && $this->option('dry-run') === 'false') {
            $this->info('Dry run disabled. Changes will be saved.');
            $confirmed = confirm('Are you sure you want to continue?');
            if (!$confirmed) {
                $this->info('Command cancelled.');
                return;
            }
        }
        $this->info('Assigning cantons to contacts...');

        // Get all contacts where canton is null and user_responsible_id is null (not assigned to a user)
        $contacts = \App\Models\Contact::where("canton", null)->where("user_responsible_id", null)->get();

        $orphans = [];
        $assigned = 0;

        // Loop through all contacts
        foreach ($contacts as $contact) {
            $this->info("Assigning canton to contact {$contact->id}...");
            // Get the zip code of the contact
            $zipCode = $contact->zip;
            if (!$zipCode) {
                $this->error("Contact {$contact->id} has no zip code.");
                $orphans[] = $contact;
                continue;
            }

            // Get the canton based on the zip code through https://openplzapi.org/ch/Localities API
            $response = \Illuminate\Support\Facades\Http::get("https://openplzapi.org/ch/Localities", [
                "postalCode" => $zipCode,
            ])->json();

            $canton = $response[0]["canton"]["code"] ?? null;

            if (!$canton) {
                $this->error("No canton found for contact {$contact->id} with zip code {$zipCode}.");
                $orphans[] = $contact;
                continue;
            }

            // Assign the canton to the contact
            $contact->canton = $canton;
            $assigned++;
            $this->info("Canton {$canton} assigned to contact {$contact->id}.");
            if ($this->option('dry-run') === 'false') {
                $contact->save();
            }
        }


        if (count($orphans) > 0) {
            $this->info('Orphan contacts: ' . count($orphans));
            foreach ($orphans as $orphan) {
                $this->info("Orphan contact: {$orphan->email}");
            }
            if (!$this->option("y")) {
                $sendEmail = confirm('Do you want to send an email with the orphan contacts to a user?');
                if ($sendEmail) {
                    $user = select(
                        'Select a user to send the email to:',
                        \App\Models\User::pluck('name', 'email')
                    );
                    $orphanCSV = [];
                    $orphanCSV[] = ['id', 'firstname', 'lastname', 'email'];
                    foreach ($orphans as $orphan) {
                        $orphanCSV[] = [$orphan->id, $orphan->firstname, $orphan->lastname, $orphan->email];
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
        }

        $this->info("Assigned cantons to {$assigned} contacts.");
        $this->info('Command completed.');

        if ($this->option("y")) {
            $this->info("END TIME: " . now());
            $this->info("______________ " . PHP_EOL . PHP_EOL);
        }
    }
}
