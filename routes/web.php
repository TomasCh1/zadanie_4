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
Route::get(   '/templates',              [EmailTemplateController::class, 'index'] )->name('templates.index');
Route::get(   '/templates/create',       [EmailTemplateController::class, 'create'])->name('templates.create');
Route::post(  '/templates',              [EmailTemplateController::class, 'store'] )->name('templates.store');
Route::get(   '/templates/{template}',   [EmailTemplateController::class, 'show']  )->name('templates.show');
Route::get(   '/templates/{template}/edit',[EmailTemplateController::class,'edit'])->name('templates.edit');
Route::put(   '/templates/{template}',   [EmailTemplateController::class, 'update'])->name('templates.update');
Route::delete('/templates/{template}',   [EmailTemplateController::class, 'destroy'])->name('templates.destroy');
Route::post('/templates/{template}/duplicate', [EmailTemplateController::class,'duplicate'])
    ->name('templates.duplicate');

require __DIR__.'/auth.php';
