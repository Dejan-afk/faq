<?php

use App\Models\Faq;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TagController;
use App\Models\Category;


Route::get('/', function () {
    $initialCategory = Category::where('name', 'Allgemeines')->first();

    return Inertia::render('Welcome', [
        'faqs' => Faq::where('category_id', $initialCategory->id)->with('tags')->get(),
        'categories' => Category::all(),
        'initialCategoryId' => $initialCategory->id,
        'title' => 'Häufig gestellte Fragen',
        'description' => 'Willkommen in unserem Hilfsbereich! Hier finden Sie eine Sammlung der häufigsten Fragen und Antworten zu unseren Angeboten und Services. Finden Sie schnell und unkompliziert die Informationen, die Sie suchen.'
    ]);
})->name('home');

Route::get('/login', [AuthenticatedSessionController::class, 'create']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('faqs', FaqController::class)->except(['create', 'edit', 'show']);
    Route::resource('tags', TagController::class)->except(['create', 'edit', 'show']);
    Route::post('/faqs/{faq}/sort', [FaqController::class, 'sort'])->name('faqs.sort');
});

Route::fallback(fn () => inertia('NotFound'))->name('fallback');

require __DIR__.'/auth.php';
