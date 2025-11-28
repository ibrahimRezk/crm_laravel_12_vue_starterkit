<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Deal;
use App\Models\Contact;
use App\Models\User;
use Inertia\Inertia;

class DealController extends Controller
{
    public function index(Request $request)
    {
        $deals = Deal::query()
            ->with(['contact', 'assignedTo'])
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->get(); // For Kanban, we might want all deals or grouped by stage.

        return Inertia::render('Deals/Index', [
            'deals' => $deals,
        ]);
    }

    public function create()
    {
        return Inertia::render('Deals/Create', [
            'contacts' => Contact::all(['id', 'name']),
            'users' => User::all(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'contact_id' => 'required|exists:contacts,id',
            'assigned_to' => 'nullable|exists:users,id',
            'stage' => 'required|string',
        ]);

        Deal::create($validated);

        return redirect()->route('deals.index')->with('success', 'Deal created successfully.');
    }

    public function update(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'value' => 'sometimes|numeric|min:0',
            'stage' => 'sometimes|string',
            'contact_id' => 'sometimes|exists:contacts,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $deal->update($validated);

        return back()->with('success', 'Deal updated successfully.');
    }

    public function destroy(Deal $deal)
    {
        $deal->delete();
        return redirect()->route('deals.index')->with('success', 'Deal deleted successfully.');
    }
}
