<?php

namespace App\Http\Controllers\Tenant;

use App\Models\MatchResult;
use App\Models\Schedule;
use App\Models\Sport;
use App\Models\Standing;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MatchResultController
{
    /**
     * Show the form for creating a new match result.
     */
    public function create(string $university, Schedule $schedule): View
    {
        $university = app('current_university');
        $user = auth()->user();

        // Only admin and facilitator can manage results
        if (! $user->hasAnyRole([
            'university-admin',
            'sports-facilitator',
        ])) {
            abort(403, 'Only admins and facilitators can manage match results.');
        }

        // Facilitator can only record results for their own sport
        if ($user->hasRole('sports-facilitator')) {
            $sport = Sport::where('facilitator_id', auth()->id())->first();

            if (! $sport || $schedule->sport_id !== $sport->id) {
                abort(403, 'You can only record results for your sport\'s games.');
            }
        }

        if ($schedule->matchResult) {
            return redirect()->route('tenant.schedules.show', [
                'university' => $university->slug,
                'schedule' => $schedule->id,
            ])->with('error', 'Result already recorded for this game. Use edit to update.');
        }

        if ($schedule->status === 'cancelled') {
            return redirect()->back()
                ->with('error', 'Cannot record result for a cancelled game.');
        }

        $schedule->load(['sport', 'homeTeam', 'awayTeam', 'venue']);

        return view('tenant.results.create', [
            'university' => $university,
            'schedule' => $schedule,
        ]);
    }

    /**
     * Store a newly created match result in storage.
     */
    public function store(Request $request, string $university, Schedule $schedule): RedirectResponse
    {
        $university = app('current_university');
        $user = auth()->user();

        // Only admin and facilitator can manage results
        if (! $user->hasAnyRole([
            'university-admin',
            'sports-facilitator',
        ])) {
            abort(403, 'Only admins and facilitators can manage match results.');
        }

        // Facilitator can only record results for their own sport
        if ($user->hasRole('sports-facilitator')) {
            $sport = Sport::where('facilitator_id', auth()->id())->first();

            if (! $sport || $schedule->sport_id !== $sport->id) {
                abort(403, 'You can only record results for your sport\'s games.');
            }
        }

        $validated = $request->validate([
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Determine winner
        $winnerTeamId = null;
        if ($validated['home_score'] > $validated['away_score']) {
            $winnerTeamId = $schedule->home_team_id;
        } elseif ($validated['away_score'] > $validated['home_score']) {
            $winnerTeamId = $schedule->away_team_id;
        }

        // Create match result
        MatchResult::create([
            'university_id' => $university->id,
            'schedule_id' => $schedule->id,
            'home_score' => $validated['home_score'],
            'away_score' => $validated['away_score'],
            'winner_team_id' => $winnerTeamId,
            'remarks' => $validated['remarks'],
            'recorded_by' => auth()->id(),
        ]);

        // Update schedule status
        $schedule->update(['status' => 'completed']);

        // Update standings
        $this->updateStandings($schedule, $winnerTeamId);

        return redirect()->route('tenant.schedules.show', [
            'university' => $university->slug,
            'schedule' => $schedule->id,
        ])->with('success', 'Match result recorded successfully. Standings have been updated.');
    }

    /**
     * Show the form for editing the specified match result.
     */
    public function edit(string $university, Schedule $schedule): View
    {
        $university = app('current_university');
        $user = auth()->user();

        // Only admin and facilitator can manage results
        if (! $user->hasAnyRole([
            'university-admin',
            'sports-facilitator',
        ])) {
            abort(403, 'Only admins and facilitators can manage match results.');
        }

        // Facilitator can only edit results for their own sport
        if ($user->hasRole('sports-facilitator')) {
            $sport = Sport::where('facilitator_id', auth()->id())->first();

            if (! $sport || $schedule->sport_id !== $sport->id) {
                abort(403, 'You can only edit results for your sport\'s games.');
            }
        }

        $schedule->load('matchResult');

        if (! $schedule->matchResult) {
            return redirect()->back()
                ->with('error', 'No result found for this schedule.');
        }

        return view('tenant.results.edit', [
            'university' => $university,
            'schedule' => $schedule,
        ]);
    }

    /**
     * Update the specified match result in storage.
     */
    public function update(Request $request, string $university, Schedule $schedule): RedirectResponse
    {
        $university = app('current_university');
        $user = auth()->user();

        // Only admin and facilitator can manage results
        if (! $user->hasAnyRole([
            'university-admin',
            'sports-facilitator',
        ])) {
            abort(403, 'Only admins and facilitators can manage match results.');
        }

        // Facilitator can only update results for their own sport
        if ($user->hasRole('sports-facilitator')) {
            $sport = Sport::where('facilitator_id', auth()->id())->first();

            if (! $sport || $schedule->sport_id !== $sport->id) {
                abort(403, 'You can only update results for your sport\'s games.');
            }
        }

        $validated = $request->validate([
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0',
            'remarks' => 'nullable|string|max:500',
        ]);

        $matchResult = $schedule->matchResult;

        // Reverse previous standings
        $this->reverseStandings($schedule, $matchResult->winner_team_id);

        // Determine new winner
        $newWinnerId = null;
        if ($validated['home_score'] > $validated['away_score']) {
            $newWinnerId = $schedule->home_team_id;
        } elseif ($validated['away_score'] > $validated['home_score']) {
            $newWinnerId = $schedule->away_team_id;
        }

        // Update match result
        $matchResult->update([
            'home_score' => $validated['home_score'],
            'away_score' => $validated['away_score'],
            'winner_team_id' => $newWinnerId,
            'remarks' => $validated['remarks'],
        ]);

        // Re-apply standings with new result
        $this->updateStandings($schedule, $newWinnerId);

        return redirect()->route('tenant.schedules.show', [
            'university' => $university->slug,
            'schedule' => $schedule->id,
        ])->with('success', 'Match result updated. Standings recalculated.');
    }

    /**
     * Update standings after a match.
     */
    private function updateStandings(Schedule $schedule, ?int $winnerTeamId): void
    {
        $homeTeamStanding = Standing::updateOrCreate(
            [
                'university_id' => $schedule->university_id,
                'sport_id' => $schedule->sport_id,
                'team_id' => $schedule->home_team_id,
            ],
            [
                'wins' => 0,
                'losses' => 0,
                'draws' => 0,
                'points' => 0,
            ]
        );

        $awayTeamStanding = Standing::updateOrCreate(
            [
                'university_id' => $schedule->university_id,
                'sport_id' => $schedule->sport_id,
                'team_id' => $schedule->away_team_id,
            ],
            [
                'wins' => 0,
                'losses' => 0,
                'draws' => 0,
                'points' => 0,
            ]
        );

        if ($winnerTeamId) {
            // Not a draw
            if ($winnerTeamId === $schedule->home_team_id) {
                $homeTeamStanding->increment('wins');
                $homeTeamStanding->increment('points', 3);
                $awayTeamStanding->increment('losses');
            } else {
                $awayTeamStanding->increment('wins');
                $awayTeamStanding->increment('points', 3);
                $homeTeamStanding->increment('losses');
            }
        } else {
            // Draw
            $homeTeamStanding->increment('draws');
            $homeTeamStanding->increment('points');
            $awayTeamStanding->increment('draws');
            $awayTeamStanding->increment('points');
        }
    }

    /**
     * Reverse standings after a match result.
     */
    private function reverseStandings(Schedule $schedule, ?int $previousWinnerId): void
    {
        $homeTeamStanding = Standing::where([
            'university_id' => $schedule->university_id,
            'sport_id' => $schedule->sport_id,
            'team_id' => $schedule->home_team_id,
        ])->first();

        $awayTeamStanding = Standing::where([
            'university_id' => $schedule->university_id,
            'sport_id' => $schedule->sport_id,
            'team_id' => $schedule->away_team_id,
        ])->first();

        if ($homeTeamStanding && $awayTeamStanding) {
            if ($previousWinnerId) {
                // Reverse previous win/loss
                if ($previousWinnerId === $schedule->home_team_id) {
                    $homeTeamStanding->decrement('wins');
                    $homeTeamStanding->decrement('points', 3);
                    $awayTeamStanding->decrement('losses');
                } else {
                    $awayTeamStanding->decrement('wins');
                    $awayTeamStanding->decrement('points', 3);
                    $homeTeamStanding->decrement('losses');
                }
            } else {
                // Reverse previous draw
                $homeTeamStanding->decrement('draws');
                $homeTeamStanding->decrement('points');
                $awayTeamStanding->decrement('draws');
                $awayTeamStanding->decrement('points');
            }
        }
    }
}
