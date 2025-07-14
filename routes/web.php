<?php

use App\Models\Faq;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TagController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'faqs' => Faq::all(),
    ]);
})->name('home');

Route::get('/login', [AuthenticatedSessionController::class, 'create']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('faqs', FaqController::class)->except(['create', 'edit', 'show']);
    Route::resource('tags', TagController::class)->except(['create', 'edit', 'show']);
});

require __DIR__.'/auth.php';
