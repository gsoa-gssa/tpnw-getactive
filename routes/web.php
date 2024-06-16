<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnelickController;

Route::get('/', function () {
    return null;
});

Route::get('/oneclick/{oneclick:uuid}', [
    OnelickController::class,
    'createSignup'
])->name('oneclick.createSignup');


if(env( 'APP_ENV' ) === 'local') {
    include __DIR__ . '/local.php';
}
