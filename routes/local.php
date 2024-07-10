<?php
use Illuminate\Support\Facades\Route;

Route::get('/events/signups/export', function () {
    return view('events.exports.signups', [
        'event' => App\Models\Event::find(2)
    ]);
});
