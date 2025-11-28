<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Deal;
use App\Models\Activity;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'total_contacts' => Contact::count(),
                'total_deals' => Deal::count(),
                'won_deals_value' => Deal::where('stage', 'won')->sum('value'),
                'active_deals' => Deal::whereNotIn('stage', ['won', 'lost'])->count(),
            ],
            'recent_activities' => Activity::with(['subject', 'user'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($activity) {
                    return [
                        'id' => $activity->id,
                        'description' => $activity->description,
                        'type' => $activity->type,
                        'created_at' => $activity->created_at,
                        'user' => $activity->user ? ['name' => $activity->user->name] : null,
                        'subject' => $activity->subject ? [
                            'name' => $activity->subject->name ?? $activity->subject->title ?? 'Unknown',
                            'type' => class_basename($activity->subject_type),
                        ] : null,
                    ];
                }),
        ]);
    }
}
