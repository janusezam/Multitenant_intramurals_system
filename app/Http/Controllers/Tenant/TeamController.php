<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Sport;
use App\Models\Standing;
use App\Models\Team;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TeamController
{
    /**
     * Display a listing of teams.
     */
    public function index(): View
    {
        $university = app('current_university');

        $teams = Team::with(['sport', 'coach'])
            ->withCount('players')
            ->paginate(10);

        return view('tenant.teams.index', [
            'university' => $university,
            'teams' => $teams,
        ]);
    }

    /**
     * Show the form for creating a new team.
     */
    public function create(): View
    {
        $university = app('current_university');

        $sports = Sport::orderBy('name')->get();
        $coaches = User::role('team-coach')->orderBy('name')->get();

        return view('tenant.teams.create', [
            'university' => $university,
            'sports' => $sports,
            'coaches' => $coaches,
        ]);
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'sport_id' => 'required|exists:sports,id',
            'coach_id' => 'nullable|exists:users,id',
        ]);

        // Check team limit for basic plan
        if ($university->plan === 'basic') {
            $teamCount = Team::where('sport_id', $validated['sport_id'])->count();

            if ($teamCount >= 10) {
                return back()
                    ->withInput()
                    ->with('error', 'This sport has reached the maximum team limit for the Basic Plan (10 teams).');
            }
        }

        Team::create(array_merge($validated, [
            'university_id' => $university->id,
        ]));

        return redirect()->route('tenant.teams.index', ['university' => $university->slug])
            ->with('success', 'Team created successfully.');
    }

    /**
     * Display the specified team.
     */
    public function show(string $university, Team $team): View
    {
        $university = app('current_university');

        $team->load([
            'sport',
            'coach',
            'homeSchedules.venue',
            'homeSchedules.awayTeam',
            'awaySchedules.venue',
            'awaySchedules.homeTeam',
        ]);

        $standing = Standing::where('team_id', $team->id)->first();

        // Fetch players with user relationship
        $players = $team->players()->with('user')->get();

        // Merge home and away schedules
        $schedules = $team->homeSchedules->merge($team->awaySchedules)->sortBy('scheduled_at');

        return view('tenant.teams.show', [
            'university' => $university,
            'team' => $team,
            'standing' => $standing,
            'players' => $players,
            'schedules' => $schedules,
        ]);
    }

    /**
     * Show the form for editing the specified team.
     */
    public function edit(string $university, Team $team): View
    {
        $university = app('current_university');

        $sports = Sport::orderBy('name')->get();
        $coaches = User::role('team-coach')->orderBy('name')->get();

        return view('tenant.teams.edit', [
            'university' => $university,
            'team' => $team,
            'sports' => $sports,
            'coaches' => $coaches,
        ]);
    }

    /**
     * Update the specified team in storage.
     */
    public function update(Request $request, string $university, Team $team): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'sport_id' => 'required|exists:sports,id',
            'coach_id' => 'nullable|exists:users,id',
        ]);

        $team->update($validated);

        return redirect()->route('tenant.teams.index', ['university' => $university->slug])
            ->with('success', 'Team updated successfully.');
    }

    /**
     * Delete the specified team from storage.
     */
    public function destroy(string $university, Team $team): RedirectResponse
    {
        $university = app('current_university');

        $hasActiveSchedules = $team->homeSchedules()
            ->whereIn('status', ['scheduled', 'ongoing'])
            ->exists() || $team->awaySchedules()
            ->whereIn('status', ['scheduled', 'ongoing'])
            ->exists();

        if ($hasActiveSchedules) {
            return redirect()->back()
                ->with('error', 'Cannot delete team with active or scheduled games.');
        }

        $team->delete();

        return redirect()->route('tenant.teams.index', ['university' => $university->slug])
            ->with('success', 'Team deleted successfully.');
    }
}
