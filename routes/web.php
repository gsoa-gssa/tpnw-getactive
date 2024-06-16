<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnelickController;
use Livewire\Attributes\On;

Route::get('/', function () {
    return null;
});

Route::get('/oneclick/{oneclick:uuid}', [
    OnelickController::class,
    'createSignup'
])->name('oneclick.createSignup');
