<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Activity;

class ActivityController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'subject_type' => 'required|string',
            'subject_id' => 'required|integer',
        ]);

        $validated['user_id'] = auth()->id();

        Activity::create($validated);

        return back()->with('success', 'Activity added successfully.');
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'completed' => 'boolean',
        ]);

        $activity->update($validated);

        return back()->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return back()->with('success', 'Activity deleted successfully.');
    }
}
