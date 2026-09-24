<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/** Handles the "Has your baby arrived?" prompt shown to expecting parents after their due date. */
class ArrivalController extends Controller
{
    public function confirm(Request $request): RedirectResponse
    {
        $request->user()->update([
            'parent_type'           => 'new_parent',
            'arrival_snoozed_until' => null,
        ]);

        return redirect()->route('dashboard')->with('arrival_confirmed', true);
    }

    public function snooze(Request $request): RedirectResponse
    {
        $request->user()->update(['arrival_snoozed_until' => today()->addWeek()]);

        return redirect()->route('dashboard');
    }
}
