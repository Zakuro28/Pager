<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    private function requireAdminAuth(): ?RedirectResponse
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    public function showLogin(): View|RedirectResponse
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.index');
        }
        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if ($request->username === 'admin' && $request->password === 'admin123') {
            $request->session()->put('admin_logged_in', true);
            return redirect()->route('admin.index');
        }

        return back()->withErrors(['username' => 'Invalid username or password.'])->onlyInput('username');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function index(): View|RedirectResponse
    {
        if ($redirect = $this->requireAdminAuth()) return $redirect;

        $users = User::query()->latest()->get();

        $totalUsers = $users->count();
        $verifiedUsers = $users->whereNotNull('email_verified_at')->count();
        $newUsers7d = $users->where('created_at', '>=', now()->subDays(7))->count();
        $unverifiedUsers = $totalUsers - $verifiedUsers;

        $verifiedRate = $totalUsers > 0 ? (int) round(($verifiedUsers / $totalUsers) * 100) : 0;
        $newUserRate = $totalUsers > 0 ? (int) round(($newUsers7d / $totalUsers) * 100) : 0;
        $unverifiedRate = $totalUsers > 0 ? (int) round(($unverifiedUsers / $totalUsers) * 100) : 0;

        return view('admin', [
            'users' => $users,
            'stats' => [
                'total_users' => $totalUsers,
                'verified_users' => $verifiedUsers,
                'new_users_7d' => $newUsers7d,
                'unverified_users' => $unverifiedUsers,
                'verified_rate' => $verifiedRate,
                'new_user_rate' => $newUserRate,
                'unverified_rate' => $unverifiedRate,
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse|View
    {
        if ($redirect = $this->requireAdminAuth()) return $redirect;

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

    public function destroy(User $user): RedirectResponse
    {
        if ($redirect = $this->requireAdminAuth()) return $redirect;

        $user->delete();

        return redirect()
            ->route('admin.index')
            ->with('status', 'Account removed successfully.');
    }
}
