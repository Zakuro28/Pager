<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WaitlistController;
use App\Support\Milestones;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ui-kit', function () {
    return view('ui-kit');
})->name('ui-kit');

// Guest-only auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return view('dashboard', [
            'entries'         => $user->journalEntries()->latest()->take(10)->get(),
            'milestoneGroups' => Milestones::groupsFor($user->parent_type),
            'checkedKeys'     => $user->milestoneChecks()->pluck('milestone_key')->all(),
            'onWaitlist'      => $user->waitlistSignup()->exists(),
        ]);
    })->name('dashboard');

    Route::post('/journal', [JournalController::class, 'store'])->name('journal.store');
    Route::delete('/journal/{entry}', [JournalController::class, 'destroy'])->name('journal.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/milestones', [MilestoneController::class, 'toggle'])->name('milestones.toggle');

    Route::post('/arrival', [ArrivalController::class, 'confirm'])->name('arrival.confirm');
    Route::post('/arrival/snooze', [ArrivalController::class, 'snooze'])->name('arrival.snooze');

    Route::post('/waitlist', [WaitlistController::class, 'store'])->name('waitlist.store');
});

// Admin routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
