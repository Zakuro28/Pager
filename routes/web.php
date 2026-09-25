<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WaitlistController;
use App\Support\Milestones;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email')->middleware('throttle:5,1');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
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

    // Email verification (soft: unverified users can still use the app, the dashboard nudges them)
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->to(route('dashboard') . '?verified=1');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        if (! $request->user()->hasVerifiedEmail()) {
            $request->user()->sendEmailVerificationNotification();
        }
        return back()->with('verification_sent', true);
    })->middleware('throttle:6,1')->name('verification.send');
});

// Admin routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post')->middleware('throttle:5,1');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
});
