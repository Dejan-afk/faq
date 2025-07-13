<?php

use App\Models\Faq;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


Route::get('/', function () {
    return Inertia::render('Faq/Index', [
        'faqs' => Faq::all(),
    ]);
})->name('faq.index');

Route::get('/login', [AuthenticatedSessionController::class, 'create']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::resource('faqs', FaqController::class);
    });
    
});

require __DIR__.'/auth.php';
