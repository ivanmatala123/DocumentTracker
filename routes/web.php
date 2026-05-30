<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
require __DIR__ . '/auth.php';

// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [DocumentController::class, 'index'])->name('user.dashboard');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    // Documents Management
    Route::get('/admin/documents', [AdminController::class, 'documents'])->name('admin.documents');
    Route::put('/admin/documents/{document}/status', [AdminController::class, 'updateDocumentStatus'])->name('admin.documents.status');
    Route::delete('/admin/documents/{document}', [AdminController::class, 'deleteDocument'])->name('admin.documents.delete');
    // Admin Profile routes
    Route::get('/admin/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::put('/admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::post('/admin/profile/photo', [ProfileController::class, 'updatePhoto'])->name('admin.profile.photo');
});
