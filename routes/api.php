<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Faq;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Lazy loading FAQs per category */
Route::get('/faqs', function (Request $request) {
    $catId = $request->input('category_id');
    return Faq::where('category_id', $catId)
        ->with('tags')
        ->get();
});
