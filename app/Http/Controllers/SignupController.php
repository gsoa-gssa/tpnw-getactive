<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Event;
use App\Models\Signup;
use App\Models\Git;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    /**
     * Handle frontend form submission.
     */

    public function createSignup(Request $request)
    {
        $logfile = storage_path('logs/signups/' . Git::getLastCommit()->getAuthorDate()->format('Y-m-d.H:i:s') . "/" . \Illuminate\Support\Str::uuid() . '.log');
        \Illuminate\Support\Facades\Log::build([
            "driver" => "single",
            "path" => $logfile,
        ])->info(json_encode($request->all()));

        if (!$request->events || !is_array(json_decode($request->events))) {
            return redirect()->back()->withInput();
        }

        $request->events = json_decode($request->events);
        if (count($request->events) == 1) {
            $event = Event::find($request->events[0]);
            $reassign = $event->reassign;
        } else {
            foreach ($request->events as $event) {
                $event = Event::find($event);
                if ($event->reassign) {
                    return redirect()->back()->withInput()->withErrors([
                        'firstname' => __('validator.signup.subevent.notpossible'),
                    ]);
                } else {
                    $reassign = false;
                }
            }
        }

        $validate = [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'zip' => 'required',
            'events' => 'required|json',
            "source" => ""
        ];

        if (isset($reassign) && $reassign) {
            $validate['subevent'] = 'required';
        }

        $validated = $request->validate($validate, [
            'subevent.required' => __('validator.signup.subevent.required'),
            'events.required' => __('validator.signup.events.required'),
        ]);

        if ($reassign) {
            $validated["events"] = [$validated["subevent"]];
        } else {
            $validated["events"] = $request->events;
        }

        $contact = Contact::updateOrCreate([
            'email' => $validated["email"],
        ], [
            'firstname' => $validated["firstname"],
            'lastname' => $validated["lastname"],
            'phone' => $validated["phone"],
            'zip' => $validated["zip"],
            'language' => app()->getLocale(),
        ]);

        if (!is_array($contact->activities)) {
            $contact->activities = [];
        }
        $activities = [];
        foreach ($validated["events"] as $event) {
            $event = Event::find($event);
            if (!$event) {
                return redirect()->route('signup.events')->withInput();
            }
            $activities[] = $event->type;
        }
        $contact->activities = array_unique(array_merge($contact->activities, $activities));
        $contact->save();

        foreach ($validated["events"] as $event) {
            Signup::where('contact_id', $contact->id)->where('event_id', $event)->delete();
            Signup::create([
                'contact_id' => $contact->id,
                'event_id' => $event,
                "confirmation_email" => true,
                "reminder_email" => true,
                "source" => isset($validated["source"]) ? $validated["source"] : null,
            ]);
        }

        return redirect()->route('signup.thanks', ['firstname' => $contact->firstname]);
    }
}
