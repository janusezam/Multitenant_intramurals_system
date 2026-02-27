<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Schedule;
use App\Models\Sport;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ScheduleController
{
    /**
     * Display a listing of schedules.
     */
    public function index(): View
    {
        $university = app('current_university');

        $schedules = Schedule::with(['sport', 'homeTeam', 'awayTeam', 'venue'])
            ->orderBy('scheduled_at', 'asc')
            ->paginate(10);

        return view('tenant.schedules.index', [
            'university' => $university,
            'schedules' => $schedules,
        ]);
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create(): View
    {
        $university = app('current_university');

        $sports = Sport::orderBy('name')->get();
        $venues = Venue::orderBy('name')->get();
        $teams = Team::with('sport')->orderBy('name')->get();

        return view('tenant.schedules.create', [
            'university' => $university,
            'sports' => $sports,
            'venues' => $venues,
            'teams' => $teams,
        ]);
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'venue_id' => 'required|exists:venues,id',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'scheduled_at' => 'required|date|after:now',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
        ]);

        // Check venue conflict
        $venueConflict = Schedule::where('venue_id', $validated['venue_id'])
            ->where('scheduled_at', $validated['scheduled_at'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($venueConflict) {
            return back()
                ->withInput()
                ->with('error', 'This venue is already booked at the selected date and time. Please choose another time.');
        }

        // Check team conflict
        $teamConflict = Schedule::where('scheduled_at', $validated['scheduled_at'])
            ->where(function ($q) use ($validated) {
                $q->where('home_team_id', $validated['home_team_id'])
                    ->orWhere('away_team_id', $validated['home_team_id'])
                    ->orWhere('home_team_id', $validated['away_team_id'])
                    ->orWhere('away_team_id', $validated['away_team_id']);
            })
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($teamConflict) {
            return back()
                ->withInput()
                ->with('error', 'One or more selected teams already have a game scheduled at this time.');
        }

        Schedule::create(array_merge($validated, [
            'university_id' => $university->id,
        ]));

        return redirect()->route('tenant.schedules.index', ['university' => $university->slug])
            ->with('success', 'Game scheduled successfully.');
    }

    /**
     * Display the specified schedule.
     */
    public function show(string $university, Schedule $schedule): View
    {
        $university = app('current_university');

        $schedule->load(['sport', 'homeTeam', 'awayTeam', 'venue', 'matchResult']);

        return view('tenant.schedules.show', [
            'university' => $university,
            'schedule' => $schedule,
        ]);
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit(string $university, Schedule $schedule): View
    {
        $university = app('current_university');

        if (in_array($schedule->status, ['completed', 'cancelled'])) {
            return redirect()->back()
                ->with('error', 'Cannot edit a completed or cancelled schedule.');
        }

        $sports = Sport::orderBy('name')->get();
        $venues = Venue::orderBy('name')->get();
        $teams = Team::with('sport')->orderBy('name')->get();

        return view('tenant.schedules.edit', [
            'university' => $university,
            'schedule' => $schedule,
            'sports' => $sports,
            'venues' => $venues,
            'teams' => $teams,
        ]);
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(Request $request, string $university, Schedule $schedule): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'venue_id' => 'required|exists:venues,id',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'scheduled_at' => 'required|date',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
        ]);

        // Check venue conflict excluding current schedule
        $venueConflict = Schedule::where('venue_id', $validated['venue_id'])
            ->where('scheduled_at', $validated['scheduled_at'])
            ->where('status', '!=', 'cancelled')
            ->where('id', '!=', $schedule->id)
            ->exists();

        if ($venueConflict) {
            return back()
                ->withInput()
                ->with('error', 'This venue is already booked at the selected date and time. Please choose another time.');
        }

        // Check team conflict excluding current schedule
        $teamConflict = Schedule::where('scheduled_at', $validated['scheduled_at'])
            ->where(function ($q) use ($validated) {
                $q->where('home_team_id', $validated['home_team_id'])
                    ->orWhere('away_team_id', $validated['home_team_id'])
                    ->orWhere('home_team_id', $validated['away_team_id'])
                    ->orWhere('away_team_id', $validated['away_team_id']);
            })
            ->where('status', '!=', 'cancelled')
            ->where('id', '!=', $schedule->id)
            ->exists();

        if ($teamConflict) {
            return back()
                ->withInput()
                ->with('error', 'One or more selected teams already have a game scheduled at this time.');
        }

        $schedule->update($validated);

        return redirect()->route('tenant.schedules.index', ['university' => $university->slug])
            ->with('success', 'Schedule updated successfully.');
    }

    /**
     * Delete the specified schedule from storage.
     */
    public function destroy(string $university, Schedule $schedule): RedirectResponse
    {
        $university = app('current_university');

        if ($schedule->matchResult) {
            return redirect()->back()
                ->with('error', 'Cannot delete schedule with recorded results.');
        }

        if ($schedule->status === 'ongoing') {
            return redirect()->back()
                ->with('error', 'Cannot delete an ongoing game.');
        }

        $schedule->delete();

        return redirect()->route('tenant.schedules.index', ['university' => $university->slug])
            ->with('success', 'Schedule deleted successfully.');
    }
}
