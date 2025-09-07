<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect()->route('leads.index');
})->name('home'); // This names the route "home"


Route::resources([
    'leads' => App\Http\Controllers\LeadController::class,
    'tickets' => App\Http\Controllers\TicketController::class,
    'notes' => App\Http\Controllers\NoteController::class,
    'timelines' => App\Http\Controllers\TimelineController::class,
    'emails' => App\Http\Controllers\EmailController::class,
]);

// Zoho OAuth routes
Route::get('/zoho/oauth', [App\Http\Controllers\ZohoOAuthController::class, 'redirectToZoho']);
Route::get('/zoho/oauth/redirect', [App\Http\Controllers\ZohoOAuthController::class, 'redirectToZoho'])->name('zoho.oauth.redirect');
Route::get('/zoho/oauth/callback', [App\Http\Controllers\ZohoOAuthController::class, 'handleZohoCallback'])->name('zoho.oauth.callback');
Route::get('/zoho/access-token', [App\Http\Controllers\ZohoOAuthController::class, 'getAccessToken']);

// Zoho fetch-info trigger
Route::post('/zoho/fetch-info', App\Http\Controllers\ZohoFetchInfoController::class);
