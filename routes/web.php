<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

Route::middleware(['auth'])->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Jika sudah login, redirect ke dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    // Jika belum login, redirect ke login
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if ($user->role === 'support') {
        return redirect()->route('dashboard.support');
    }
    return redirect()->route('dashboard.user');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.update-role');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});

Route::middleware(['auth', 'is_support'])->group(function () {
    Route::get('/dashboard/support', [DashboardController::class, 'supportDashboard'])->name('dashboard.support');
    Route::get('/support/tickets', [TicketController::class, 'all'])->name('support.tickets');
    Route::get('/support/tickets/{id}/assign', [TicketController::class, 'assignForm'])->name('tickets.assign.form');
    Route::post('/support/tickets/{id}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
    Route::patch('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/user', [DashboardController::class, 'userDashboard'])->name('dashboard.user');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
