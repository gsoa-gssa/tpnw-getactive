<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Create an event from the frontend form
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createEvent(Request $request)
    {
        $validated = $request->validate([
            'event.name' => 'required',
            'event.date' => 'required|date',
            'event.time' => 'required',
            'event.location' => 'required',
            'event.canton' => 'required|exists:cantons,code',
            'event.type' => 'required',
            'event.description' => 'required',
            'contact.firstname' => 'required',
            'contact.lastname' => 'required',
            'contact.email' => 'required|email',
            'contact.phone' => 'required',
            'contact.zip' => 'required',
            'locale' => 'required|in:de,fr,it',
        ]);

        $eventData = $validated['event'];
        $user = \App\Models\Canton::where('code', $eventData['canton'])->first()->user()->first();
        $contactData = $validated['contact'];
        $locale = $validated['locale'];

        $contact = \App\Models\Contact::updateOrCreate(
            [
                "email" => $contactData['email']
            ],
            [
                "firstname" => $contactData['firstname'],
                "lastname" => $contactData['lastname'],
                "phone" => $contactData['phone'],
                "zip" => $contactData['zip']
            ]
        );

        $event = \App\Models\Event::create([
            "name" => [
                $locale => $eventData['name']
            ],
            "description" => [
                $locale => $eventData['description']
            ],
            "date" => $eventData['date'],
            "time" => [
                $locale => $eventData['time']
            ],
            "location" => [
                $locale => $eventData['location']
            ],
            "canton" => $eventData['canton'],
            "type" => $eventData['type'],
            "visibility" => false,
            "contact_id" => $contact->id
        ]);
        $event->users()->attach($user);
        $event->save();

        $user->notify(new \App\Notifications\EventCreated($event));

        return redirect()->route('event.thanks', ['firstname' => $contact->firstname]);
    }
}
