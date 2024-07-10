<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnelickController;
use App\Http\Controllers\SignupController;
use App\Models\Signup;

Route::get('/', function () {
    $events = \App\Models\Event::whereDate('date', ">=", now())->where("visibility", true)->orderBy('date', 'asc')->get();
    return view("frontend.events", compact('events'));
})->name('landingpage');

Route::post('/signup', [SignupController::class, 'createSignup'])->name('signup.create');

Route::get('/signup/thanks', function () {
    return view("frontend.thanks");
})->name('signup.thanks');

Route::get('/signup/{events}', function ($events) {
    $events = explode(',', $events);
    $events = \App\Models\Event::whereIn('id', $events)->get();
    return view("frontend.signup", compact('events'));
})->name('signup.events');

Route::get('/event/create', function () {
    return view("frontend.event.create");
})->name('event.create');

Route::post('/event/create', [EventController::class, 'createEvent'])->name('event.create');

Route::get('/event/thanks', function () {
    return view("frontend.thanks");
})->name('event.thanks');

Route::get('/oneclick/{oneclick:uuid}', [
    OnelickController::class,
    'createSignup'
])->name('oneclick.createSignup');


if(env( 'APP_ENV' ) === 'local') {
    include __DIR__ . '/local.php';
}
