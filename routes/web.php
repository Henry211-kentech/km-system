<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

// Client routes
Route::resource('clients', ClientController::class)->middleware('auth');

// Vehicle routes
Route::resource('vehicles', VehicleController::class)->middleware('auth');

// Job routes
Route::resource('jobs', JobController::class)->middleware('auth');

// Invoice routes
Route::resource('invoices', InvoiceController::class)->middleware('auth');
Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf')->middleware('auth');

// Payment routes
Route::resource('payments', PaymentController::class)->only(['index', 'create', 'store', 'show', 'destroy'])->middleware('auth');

// Receipt routes
Route::resource('receipts', ReceiptController::class)->only(['index', 'store', 'show', 'destroy'])->middleware('auth');
Route::get('/receipts/{receipt}/pdf', [ReceiptController::class, 'pdf'])->name('receipts.pdf')->middleware('auth');

// User routes
Route::resource('users', UserController::class)->middleware('auth');

// Activity Log routes
Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index')->middleware('auth');
Route::get('/logs/filter', [ActivityLogController::class, 'filter'])->name('logs.filter')->middleware('auth');
Route::get('/logs/{log}', [ActivityLogController::class, 'show'])->name('logs.show')->middleware('auth');
Route::delete('/logs/{log}', [ActivityLogController::class, 'destroy'])->name('logs.destroy')->middleware('auth');
Route::post('/logs/clear-old', [ActivityLogController::class, 'clearOldLogs'])->name('logs.clearOldLogs')->middleware('auth');

// Backup routes
Route::get('/backups', [BackupController::class, 'index'])->name('backups.index')->middleware('auth');
Route::post('/backups', [BackupController::class, 'create'])->name('backups.create')->middleware('auth');
Route::get('/backups/{backup}/download', [BackupController::class, 'download'])->name('backups.download')->middleware('auth');
Route::delete('/backups/{backup}', [BackupController::class, 'destroy'])->name('backups.destroy')->middleware('auth');
