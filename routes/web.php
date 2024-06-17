<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnelickController;

Route::get('/', function () {
    $events = \App\Models\Event::whereDate('date', ">=", now())->where("visibility", true)->orderBy('date', 'asc')->get();
    return view("frontend.events", compact('events'));
})->name('landingpage');

Route::get('/signup/{events}', function ($events) {
    $events = explode(',', $events);
    $events = \App\Models\Event::whereIn('id', $events)->get();
    dd($events);
})->name('signup');

Route::get('/oneclick/{oneclick:uuid}', [
    OnelickController::class,
    'createSignup'
])->name('oneclick.createSignup');


if(env( 'APP_ENV' ) === 'local') {
    include __DIR__ . '/local.php';
}
