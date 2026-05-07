<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// ─── Public ──────────────────────────────────────────────────
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/carte', [PortfolioController::class, 'carte'])->name('carte');
Route::post('/contact', [PortfolioController::class, 'sendContact'])
    ->name('contact.send')
    ->middleware('throttle:5,1');

// ─── Auth ─────────────────────────────────────────────────────
Route::get('/login', [AdminController::class, 'loginForm'])->name('login')->middleware('throttle:10,1');
Route::post('/login', [AdminController::class, 'authenticate'])->middleware('throttle:10,1');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// ─── Admin (protégé) ──────────────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard + maintenance
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::delete('/reset-visits', [AdminController::class, 'resetVisits'])->name('reset.visits');
    Route::delete('/reset-messages', [AdminController::class, 'resetMessages'])->name('reset.messages');
    Route::post('/messages/{message}/read', [AdminController::class, 'markMessageRead'])->name('messages.read');

    // Profil
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Projets
    Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
    Route::get('/projects/create', [AdminController::class, 'createProject'])->name('projects.create');
    Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
    Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
    Route::post('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('projects.delete');

    // Compétences
    Route::get('/skills', [AdminController::class, 'skills'])->name('skills');
    Route::post('/skills', [AdminController::class, 'storeSkill'])->name('skills.store');
    Route::delete('/skills/{skill}', [AdminController::class, 'deleteSkill'])->name('skills.delete');

    // Assets du site
    Route::get('/documents', [AdminController::class, 'documents'])->name('documents');
    Route::post('/documents', [AdminController::class, 'storeDocument'])->name('documents.store');
    Route::get('/documents/{document}/edit', [AdminController::class, 'editDocument'])->name('documents.edit');
    Route::put('/documents/{document}', [AdminController::class, 'updateDocument'])->name('documents.update');
    Route::delete('/documents/{document}', [AdminController::class, 'deleteDocument'])->name('documents.delete');
});
