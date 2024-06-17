<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Signup;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    /**
     * Handle frontend form submission.
     */

    public function createSignup(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'zip' => 'required',
            'canton' => 'required',
            'events' => 'required|json',
        ]);
        $request->events = json_decode($request->events);

        $contact = Contact::firstOrCreate([
            'email' => $request->email,
        ], [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'zip' => $request->zip,
            'canton' => $request->canton,
        ]);

        foreach ($request->events as $event) {
            Signup::firstOrCreate([
                'contact_id' => $contact->id,
                'event_id' => $event,
            ]);
        }

        return redirect()->route('signup.thanks', ['firstname' => $contact->firstname]);
    }
}
