<?php

namespace App\Http\Controllers;

use App\Support\Milestones;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MilestoneController extends Controller
{
    public function toggle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'key'     => ['required', 'string', Rule::in(Milestones::allKeys())],
            'checked' => ['required', 'boolean'],
        ]);

        $checks = $request->user()->milestoneChecks();

        if ($validated['checked']) {
            $checks->firstOrCreate(['milestone_key' => $validated['key']]);
        } else {
            $checks->where('milestone_key', $validated['key'])->delete();
        }

        return response()->json(['checked' => (bool) $validated['checked']]);
    }
}
