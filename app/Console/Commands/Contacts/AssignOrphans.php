<?php

namespace App\Console\Commands\Contacts;

use App\Settings\ContactAssign;
use Illuminate\Console\Command;

class AssignOrphans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contacts:autoassign';

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
        $contactAssign = app(ContactAssign::class);
        dd($contactAssign->canton_rules);
    }
}
