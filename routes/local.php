<?php
use Illuminate\Support\Facades\Route;

Route::get('/events/signups/export', function () {
    return view('events.exports.signups', [
        'event' => App\Models\Event::find(2)
    ]);
});

Route::get("/signups/reminder-email", function () {
    $signup = App\Models\Signup::all()->first();

    return (new App\Notifications\Signup\Reminder($signup))->toMail($signup->contact);
});
