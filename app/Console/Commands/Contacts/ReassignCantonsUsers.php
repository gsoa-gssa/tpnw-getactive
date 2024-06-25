<?php

namespace App\Console\Commands\Contacts;

use App\Models\Contact;
use App\Settings\ContactAssign;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Mail;
use function Laravel\Prompts\confirm;

class ReassignCantonsUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contacts:reassign {--dry-run=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         * Find all contacts where ZIP != NULL AND user_responsible_id == 3 (Lukas)
         * oldCanton = $contact->canton
         * Lookup newCanton based on ZIP
         * Check if oldCanton == newCanton
         * if TRUE: continue
         *
         * if FALSE:
         *      assign $contact->canton = newCanton
         *      Check if user_responsible_id is what would be assigned based on oldCanton
         *      if FALSE: continue
         *
         *      if TRUE:
         *          add $contact to alteredContacts array
         *          Find user_responsbile_id based on newCanton
         *          update $contact->user_responsible_id
         *
         * export alteredContacts array as csv and send it to lukas@gsoa.
         *
         */

        if ($this->option('dry-run') === 'true') {
            $this->info('Dry run enabled. No changes will be saved.');
        } else if ($this->option('dry-run') === 'false') {
            $this->info('Dry run disabled. Changes will be saved.');
            $confirmed = confirm('Are you sure you want to continue?');
            if (!$confirmed) {
                $this->info('Command cancelled.');
                return;
            }
        }
        $this->info('Reassigning cantons and users to contacts...');

        $contacts = Contact::where("zip", "!=", null)->where("user_responsible_id", 1)->get();

        $alteredContacts = [];

        foreach ($contacts as $contact) {
            $this->info("Finding canton for contact " . $contact->email);
            $oldCanton = $contact->canton;
            $response = \Illuminate\Support\Facades\Http::get("https://openplzapi.org/ch/Localities", [
                "postalCode" => $contact->zip
            ])->json();

            $newCanton = $response[0]["canton"]["code"] ?? null;

            if (!$newCanton) {
                $this->info("No canton found for contact {$contact->email} with ZIP code {$contact->zip}");
                continue;
            }

            if ($newCanton == $oldCanton) {
                $this->info("New canton identical with old canton for contact {$contact->email}");
                continue;
            }

            $contact->canton = $newCanton;
            $this->info("Assigned {$newCanton} to contact {$contact->email} based on ZIP Code {$contact->zip}.");
            if ($this->option('dry-run') === 'false') {
                $contact->save();
            }

            $contactAssign = app(ContactAssign::class);
            $oldUser = array_values(array_filter($contactAssign->canton_rules, function ($user) use ($oldCanton) {
                return $user["canton"] === $oldCanton;
            }))[0]["user_id"] ?? null;

            $newUser = array_values(array_filter($contactAssign->canton_rules, function ($user) use ($newCanton) {
                return $user["canton"] === $newCanton;
            }))[0]["user_id"] ?? null;

            if ($newUser == $oldUser) {
                $this->info("New user identical with old user for contact {$contact->email}");
                continue;
            }

            $contact->user_responsible_id = $newUser;
            $this->info("Assigned contact {$contact->email} to user {$newUser}.");
            if ($this->option('dry-run') === 'false') {
                $contact->save();
            }
            $alteredContacts[] = $contact;
            $this->info("DONE WITH CONTACT {$contact->id}");
            $this->info("______________ " . PHP_EOL . PHP_EOL);
        }

        if (count($alteredContacts) > 0) {

            $sendEmail = confirm('Do you want to send an email with the altered contacts to a user?');
            if ($sendEmail) {
                $user = select(
                    'Select a user to send the email to:',
                    \App\Models\User::pluck('name', 'email')
                );
                $orphanCSV = [];
                $orphanCSV[] = ['id', 'firstname', 'lastname', 'email', 'canton', 'zip'];
                foreach ($alteredContacts as $alteredContact) {
                    $orphanCSV[] = [$alteredContact->id, $alteredContact->firstname, $alteredContact->lastname, $alteredContact->email, $alteredContact->canton, $alteredContact->zip];
                }
                $csv = \League\Csv\Writer::createFromString('');
                $csv->insertAll($orphanCSV);
                $this->info('Sending email...');
                // Send email with orphan contacts
                Mail::raw("Altered Contacts for reassignment started at " . now(), function ($message) use ($csv, $user) {
                    $message->to($user)
                        ->subject('Altered Contacts')
                        ->attachData($csv->toString(), 'orphans-' . now() . '.csv', [
                            'mime' => 'text/csv',
                        ])
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });
            }
        }

    }
}
