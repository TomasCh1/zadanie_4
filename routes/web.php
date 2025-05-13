<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MailSimpleController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\SentEmailController;
use App\Http\Controllers\PredefinedMailController;
require __DIR__ . '/auth.php';

// Public routes for guests (e.g., login, registration)
Route::middleware('guest')->group(function () {
    Route::view('/', 'auth.index');
});

// All other routes require authentication
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});

Route::middleware('auth')->group(function () {
    // Profile management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Contacts CRUD
    Route::resource('contacts', ContactController::class);

    // Simple mail
    Route::prefix('mail/simple')->name('simple-mail.')->group(function () {
        Route::get('/', [MailSimpleController::class, 'create'])->name('create');
        Route::post('/', [MailSimpleController::class, 'store'])->name('store');
        Route::get('from-sent/{sentEmail}', [MailSimpleController::class, 'replicate'])->name('replicate');
    });

    // Email templates
    Route::resource('templates', EmailTemplateController::class)->except(['index']);
    Route::get('/templates', [EmailTemplateController::class, 'index'])->name('templates.index');
    Route::post('/templates/{template}/duplicate', [EmailTemplateController::class, 'duplicate'])->name('templates.duplicate');

    // Sent emails
    Route::get('/sent-emails', [SentEmailController::class, 'index'])->name('sent_emails.index');
    Route::get('/sent-emails/{sentEmail}', [SentEmailController::class, 'show'])->name('sent_emails.show');

    // Predefined mails
    Route::resource('predefined-mails', PredefinedMailController::class)->except(['show']);
    Route::get('predefined-mails/{predefinedMail}', [PredefinedMailController::class, 'show'])->name('predefined-mails.show');
    Route::post('predefined-mails/{predefinedMail}/send', [PredefinedMailController::class, 'send'])->name('predefined-mails.send');
    Route::post('predefined-mails/{predefinedMail}/duplicate', [PredefinedMailController::class, 'duplicate'])->name('predefined-mails.duplicate');
});Route::get('/whoami', function () {
    return \Illuminate\Support\Facades\Auth::check()
        ? 'PRIHLÁSENÝ ID: '.\Auth::id()
        : 'GUEST';
});
