<?php
use Illuminate\Support\Facades\Route;

Route::get('/events/signups/export', function () {
    return view('events.exports.signups', [
        'event' => App\Models\Event::find(2)
    ]);
});

Route::prefix("emails")->group(function () {
    Route::get("/signup/confirmation", function () {
        $signup = App\Models\Signup::all()->first();

        return (new App\Notifications\Signup\Confirmation($signup))->toMail($signup->contact);
    });

    Route::get("/signup/reminder", function () {
        $signup = App\Models\Signup::all()->last();

        return (new App\Notifications\Signup\Reminder($signup))->toMail($signup->contact);
    });
});

