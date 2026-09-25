<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/** Admin panel. Access is limited to users with is_admin = true (see EnsureUserIsAdmin). */
class AdminController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->user()?->is_admin) {
            return redirect()->route('admin.index');
        }
        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Only admins may sign in here; everyone else gets the same generic error.
        if (Auth::attempt($credentials + ['is_admin' => true])) {
            $request->session()->regenerate();

            // Only return to a remembered page if it was an admin page, not e.g. /dashboard.
            $intended = $request->session()->pull('url.intended');
            $adminUrl = route('admin.index');

            return redirect()->to($intended && str_starts_with($intended, $adminUrl) ? $intended : $adminUrl);
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function index(): View
    {
        $users = User::query()->withCount('journalEntries')->latest()->get();

        $totalUsers      = $users->count();
        $verifiedUsers   = $users->whereNotNull('email_verified_at')->count();
        $newUsers7d      = $users->where('created_at', '>=', now()->subDays(7))->count();
        $unverifiedUsers = $totalUsers - $verifiedUsers;
        $totalEntries    = JournalEntry::count();
        $entriesThisWeek = JournalEntry::where('created_at', '>=', now()->subDays(7))->count();

        $verifiedRate    = $totalUsers > 0 ? (int) round(($verifiedUsers   / $totalUsers) * 100) : 0;
        $newUserRate     = $totalUsers > 0 ? (int) round(($newUsers7d      / $totalUsers) * 100) : 0;
        $unverifiedRate  = $totalUsers > 0 ? (int) round(($unverifiedUsers / $totalUsers) * 100) : 0;

        return view('admin', [
            'users' => $users,
            'stats' => [
                'total_users'      => $totalUsers,
                'verified_users'   => $verifiedUsers,
                'new_users_7d'     => $newUsers7d,
                'unverified_users' => $unverifiedUsers,
                'total_entries'    => $totalEntries,
                'entries_this_week'=> $entriesThisWeek,
                'verified_rate'    => $verifiedRate,
                'new_user_rate'    => $newUserRate,
                'unverified_rate'  => $unverifiedRate,
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.index')
            ->with('status', 'Account added successfully.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['delete' => "You can't remove your own admin account from here."]);
        }

        $user->delete();

        return redirect()
            ->route('admin.index')
            ->with('status', 'Account removed successfully.');
    }
}
