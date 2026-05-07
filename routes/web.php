<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::post('/contact', [PortfolioController::class, 'sendContact'])->name('contact.send')->middleware('throttle:5,1');

// Admin Auth Routes
Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
Route::post('/login', [AdminController::class, 'authenticate']);
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// Protected Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
    Route::get('/projects/create', [AdminController::class, 'createProject'])->name('projects.create');
    Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
    Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
    Route::post('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('projects.delete');
    Route::get('/skills', [AdminController::class, 'skills'])->name('skills');
    Route::post('/skills', [AdminController::class, 'storeSkill'])->name('skills.store');
    Route::delete('/skills/{skill}', [AdminController::class, 'deleteSkill'])->name('skills.delete');
    Route::get('/documents', [AdminController::class, 'documents'])->name('documents');
    Route::post('/documents', [AdminController::class, 'storeDocument'])->name('documents.store');
    Route::get('/documents/{document}/edit', [AdminController::class, 'editDocument'])->name('documents.edit');
    Route::put('/documents/{document}', [AdminController::class, 'updateDocument'])->name('documents.update');
    Route::delete('/documents/{document}', [AdminController::class, 'deleteDocument'])->name('documents.delete');
});
