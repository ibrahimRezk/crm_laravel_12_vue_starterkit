<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');




Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('contacts', \App\Http\Controllers\ContactController::class);
    Route::resource('deals', \App\Http\Controllers\DealController::class);
    Route::resource('activities', \App\Http\Controllers\ActivityController::class)->only(['store', 'update', 'destroy']);
});

Route::post('/language', function (\Illuminate\Http\Request $request) {
    $request->validate(['locale' => 'required|in:en,ar']);
    session()->put('locale', $request->locale);
    return back();
})->name('language.switch');

require __DIR__ . '/settings.php';
