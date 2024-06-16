<?php

namespace App\Http\Controllers;

use App\Models\Oneclick;
use App\Models\Signup;
use App\Models\Contact;
use Illuminate\Http\Request;

class OnelickController extends Controller
{
    /**
     * Create signup from onlick
     */
    public function createSignup(Oneclick $oneclick)
    {
        $fields = request()->all();
        if (!isset($fields['email']) || !filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Email must be provided and valid.', 400);
        }
        $event = $oneclick->event;
        $contact = Contact::firstOrCreate(['email' => $fields['email']]);
        foreach ($fields as $field => $value) {
            if ($field === 'email') {
                continue;
            } else if ($value == "") {
                continue;
            }
            $contact->$field = $value;
        }
        $contact->activities = array_merge($contact->activities, [$event->type]);
        $contact->save();
        $signup = Signup::firstOrCreate([
            'event_id' => $event->id,
            'contact_id' => $contact->id,
        ]);
        return view('oneclick.thanks', ['oneclick' => $oneclick, 'event' => $event, 'contact' => $contact]);
    }
}
