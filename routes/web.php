<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\SignLanguageController;
use App\Http\Controllers\ConversationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Recordings
    Route::get('/recordings', [RecordingController::class, 'index'])->name('recordings.index');
    Route::get('/recordings/create', [RecordingController::class, 'create'])->name('recordings.create');
    Route::post('/recordings', [RecordingController::class, 'store'])->name('recordings.store');
    Route::get('/recordings/{recording}', [RecordingController::class, 'show'])->name('recordings.show');
    Route::get('/recordings/{recording}/edit', [RecordingController::class, 'edit'])->name('recordings.edit');
    Route::put('/recordings/{recording}', [RecordingController::class, 'update'])->name('recordings.update');
    Route::delete('/recordings/{recording}', [RecordingController::class, 'destroy'])->name('recordings.destroy');
    
    // Sign Language
    Route::get('/sign-language', [SignLanguageController::class, 'index'])->name('sign-language.index');
    Route::get('/sign-language/learn', [SignLanguageController::class, 'learn'])->name('sign-language.learn');
    
    // Conversation
    Route::get('/conversation', [ConversationController::class, 'index'])->name('conversation.index');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
