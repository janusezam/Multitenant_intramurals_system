<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Sport;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SportController
{
    /**
     * Display a listing of sports.
     */
    public function index(): View
    {
        $university = app('current_university');

        $sports = Sport::withCount(['teams', 'schedules', 'players'])
            ->with('facilitator')
            ->paginate(10);

        return view('tenant.sports.index', [
            'university' => $university,
            'sports' => $sports,
        ]);
    }

    /**
     * Show the form for creating a new sport.
     */
    public function create(): View
    {
        $university = app('current_university');

        $facilitators = User::role('sports-facilitator')->get();

        return view('tenant.sports.create', [
            'university' => $university,
            'facilitators' => $facilitators,
        ]);
    }

    /**
     * Store a newly created sport in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('sports', 'name')
                    ->where('university_id', $university->id),
            ],
            'category' => 'required|in:team,individual',
            'bracket_type' => 'required|in:single_elimination,double_elimination,round_robin',
            'facilitator_id' => 'nullable|exists:users,id',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        Sport::create(array_merge($validated, [
            'university_id' => $university->id,
        ]));

        return redirect()->route('tenant.sports.index', ['university' => $university->slug])
            ->with('success', 'Sport created successfully.');
    }

    /**
     * Display the specified sport.
     */
    public function show(string $university, Sport $sport): View
    {
        $university = app('current_university');

        $sport->load([
            'schedules.homeTeam',
            'schedules.awayTeam',
            'schedules.venue',
            'facilitator',
            'standings.team',
            'brackets',
        ]);

        // Load teams with player count
        $teams = $sport->teams()->withCount('players')->get();

        $players = $sport->players;
        $schedules = $sport->schedules;
        $standings = $sport->standings->sortByDesc('points');
        $completedGames = $sport->schedules->where('status', 'completed');

        return view('tenant.sports.show', [
            'university' => $university,
            'sport' => $sport,
            'teams' => $teams,
            'players' => $players,
            'schedules' => $schedules,
            'standings' => $standings,
            'completedGames' => $completedGames,
        ]);
    }

    /**
     * Show the form for editing the specified sport.
     */
    public function edit(string $university, Sport $sport): View
    {
        $university = app('current_university');

        $facilitators = User::role('sports-facilitator')->get();

        return view('tenant.sports.edit', [
            'university' => $university,
            'sport' => $sport,
            'facilitators' => $facilitators,
        ]);
    }

    /**
     * Update the specified sport in storage.
     */
    public function update(Request $request, string $university, Sport $sport): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('sports', 'name')
                    ->where('university_id', $university->id)
                    ->ignore($sport->id),
            ],
            'category' => 'required|in:team,individual',
            'bracket_type' => 'required|in:single_elimination,double_elimination,round_robin',
            'facilitator_id' => 'nullable|exists:users,id',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        $sport->update($validated);

        return redirect()->route('tenant.sports.index', ['university' => $university->slug])
            ->with('success', 'Sport updated successfully.');
    }

    /**
     * Delete the specified sport from storage.
     */
    public function destroy(string $university, Sport $sport): RedirectResponse
    {
        $university = app('current_university');

        if ($sport->schedules()->where('status', 'ongoing')->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete sport with ongoing schedules.');
        }

        $sport->delete();

        return redirect()->route('tenant.sports.index', ['university' => $university->slug])
            ->with('success', 'Sport deleted successfully.');
    }
}
