<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VenueController
{
    /**
     * Display a listing of venues.
     */
    public function index(): View
    {
        $university = app('current_university');

        $venues = Venue::withCount('schedules')->paginate(10);

        return view('tenant.venues.index', [
            'university' => $university,
            'venues' => $venues,
        ]);
    }

    /**
     * Show the form for creating a new venue.
     */
    public function create(): View
    {
        $university = app('current_university');

        return view('tenant.venues.create', [
            'university' => $university,
        ]);
    }

    /**
     * Store a newly created venue in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
        ]);

        Venue::create(array_merge($validated, [
            'university_id' => $university->id,
        ]));

        return redirect()->route('tenant.venues.index', ['university' => $university->slug])
            ->with('success', 'Venue created successfully.');
    }

    /**
     * Display the specified venue.
     */
    public function show(string $university, Venue $venue): View
    {
        $university = app('current_university');

        $venue->load(['schedules' => function ($q) {
            $q->with(['sport', 'homeTeam', 'awayTeam'])
                ->where('scheduled_at', '>=', Carbon::now())
                ->orderBy('scheduled_at')
                ->take(10);
        }]);

        $schedules = $venue->schedules;

        return view('tenant.venues.show', [
            'university' => $university,
            'venue' => $venue,
            'schedules' => $schedules,
        ]);
    }

    /**
     * Show the form for editing the specified venue.
     */
    public function edit(string $university, Venue $venue): View
    {
        $university = app('current_university');

        return view('tenant.venues.edit', [
            'university' => $university,
            'venue' => $venue,
        ]);
    }

    /**
     * Update the specified venue in storage.
     */
    public function update(Request $request, string $university, Venue $venue): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $venue->update($validated);

        return redirect()->route('tenant.venues.index', ['university' => $university->slug])
            ->with('success', 'Venue updated successfully.');
    }

    /**
     * Delete the specified venue from storage.
     */
    public function destroy(string $university, Venue $venue): RedirectResponse
    {
        $university = app('current_university');

        if ($venue->schedules()->where('scheduled_at', '>=', Carbon::now())->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete venue with upcoming schedules.');
        }

        $venue->delete();

        return redirect()->route('tenant.venues.index', ['university' => $university->slug])
            ->with('success', 'Venue deleted successfully.');
    }
}
