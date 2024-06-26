<?php

namespace App\Http\Controllers;

use App\Models\Oneclick;
use App\Models\Signup;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OnelickController extends Controller
{
    /**
     * Create signup from onlick
     */
    public function createSignup(Oneclick $oneclick)
    {
        $fields = request()->all();

        $validator = Validator::make($fields, [
            'email' => 'required|email',
            'phone' => 'required',
            'zip' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('signup.events', $oneclick->event->id)->withInput();
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
        if (!is_array($contact->activities)) {
            $contact->activities = [];
        }
        $contact->activities = array_unique(array_merge($contact->activities, [$event->type]));
        if (!isset($contact->language) || $contact->language == "") {
            $contact->language = app()->getLocale();
        }
        $contact->save();
        $signup = Signup::firstOrCreate([
            'event_id' => $event->id,
            'contact_id' => $contact->id,
        ]);
        return view('oneclick.thanks', ['oneclick' => $oneclick, 'event' => $event, 'contact' => $contact]);
    }
}
