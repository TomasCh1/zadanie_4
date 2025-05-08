<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MailSimpleController;
use App\Http\Controllers\EmailTemplateController;


Route::view('/', 'auth.index')->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('contacts', ContactController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/mail/simple', [MailSimpleController::class,'create'])
        ->name('simple-mail.create');

    Route::post('/mail/simple', [MailSimpleController::class,'store'])
        ->name('simple-mail.store');
});

Route::resource('templates', EmailTemplateController::class);
Route::post('templates/{template}/copy', [EmailTemplateController::class,'copy'])
    ->name('templates.copy');

require __DIR__.'/auth.php';
