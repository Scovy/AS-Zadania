<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/oferta/{jobOffer}', [HomeController::class, 'show'])->name('job-offer.show');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Candidate routes
Route::middleware(['auth', 'role:kandydat'])->prefix('kandydat')->name('candidate.')->group(function () {
    Route::get('/dashboard', [CandidateController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [CandidateController::class, 'profile'])->name('profile');
    Route::put('/profil', [CandidateController::class, 'updateProfile'])->name('profile.update');
    Route::get('/aplikacje', [CandidateController::class, 'applications'])->name('applications');
    Route::post('/aplikuj/{jobOffer}', [CandidateController::class, 'apply'])->name('apply');
});

// Employer routes
Route::middleware(['auth', 'role:pracodawca'])->prefix('pracodawca')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [EmployerController::class, 'profile'])->name('profile');
    Route::put('/profil', [EmployerController::class, 'updateProfile'])->name('profile.update');
    
    Route::get('/oferty', [EmployerController::class, 'offers'])->name('offers');
    Route::get('/oferty/nowa', [EmployerController::class, 'createOffer'])->name('offers.create');
    Route::post('/oferty', [EmployerController::class, 'storeOffer'])->name('offers.store');
    Route::get('/oferty/{jobOffer}/edytuj', [EmployerController::class, 'editOffer'])->name('offers.edit');
    Route::put('/oferty/{jobOffer}', [EmployerController::class, 'updateOffer'])->name('offers.update');
    Route::delete('/oferty/{jobOffer}', [EmployerController::class, 'deleteOffer'])->name('offers.delete');
    
    Route::get('/aplikacje', [EmployerController::class, 'allApplications'])->name('applications.all');
    Route::get('/oferty/{jobOffer}/aplikacje', [EmployerController::class, 'applications'])->name('applications');
    Route::put('/aplikacje/{application}/status', [EmployerController::class, 'updateApplicationStatus'])->name('applications.status');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/uzytkownicy', [AdminController::class, 'users'])->name('users');
    Route::get('/uzytkownicy/{user}/edytuj', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/uzytkownicy/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/uzytkownicy/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::delete('/uzytkownicy/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    Route::get('/tagi', [AdminController::class, 'tags'])->name('tags');
    Route::post('/tagi', [AdminController::class, 'storeTag'])->name('tags.store');
    Route::put('/tagi/{tag}', [AdminController::class, 'updateTag'])->name('tags.update');
    Route::delete('/tagi/{tag}', [AdminController::class, 'deleteTag'])->name('tags.delete');
});
