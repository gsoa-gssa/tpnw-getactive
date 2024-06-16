<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnlickController;
use Livewire\Attributes\On;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/oneclick/{oneclick:uuid}', [
    OnlickController::class,
    'createSignup'
])->name('oneclick.createSignup');
