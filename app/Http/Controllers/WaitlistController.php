<?php

namespace App\Http\Controllers;

use App\Models\WaitlistSignup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Expert consultations aren't live yet; this collects interest instead of a dead "Book" button. */
class WaitlistController extends Controller
{
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'topics'   => ['nullable', 'array'],
            'topics.*' => ['string', Rule::in(WaitlistSignup::TOPICS)],
        ]);

        $request->user()->waitlistSignup()->updateOrCreate([], [
            'topics' => array_values($validated['topics'] ?? []),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['joined' => true]);
        }

        return redirect()->to(route('dashboard') . '#experts')->with('waitlist_joined', true);
    }
}
