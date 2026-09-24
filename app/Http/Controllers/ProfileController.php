<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'parent_type' => ['required', 'string', Rule::in(User::PARENT_TYPES)],
            'child_date'  => ['nullable', 'date'],
        ]);

        $user = $request->user();

        // Changing stage resets any "not yet" snooze on the arrival prompt.
        if ($validated['parent_type'] !== $user->parent_type) {
            $validated['arrival_snoozed_until'] = null;
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('profile_saved', true);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
