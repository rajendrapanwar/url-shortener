<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\InvitationController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Invitation routes
    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');

    // Only admin and member can create
    Route::get('/short-urls/create', [ShortUrlController::class, 'create'])
        ->middleware('role:admin,member')
        ->name('short-urls.create');
    
    Route::post('/short-urls', [ShortUrlController::class, 'store'])
        ->middleware('role:admin,member')
        ->name('short-urls.store');
    
    // All authenticated users can view their respective lists
    Route::get('/short-urls', [ShortUrlController::class, 'index'])
        ->name('short-urls.index');
});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
});


// Public routes
Route::get('/invitations/{token}', [InvitationController::class, 'acceptForm'])->name('invitations.accept');
Route::post('/invitations/{token}/accept', [InvitationController::class, 'accept'])->name('invitations.accept.post');

Route::get('/{code}', [ShortUrlController::class, 'redirect'])
    ->where('code', '[A-Za-z0-9]{6}');
require __DIR__.'/auth.php';
