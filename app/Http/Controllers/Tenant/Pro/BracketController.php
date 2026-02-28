<?php

namespace App\Http\Controllers\Tenant\Pro;

use App\Models\Bracket;
use App\Models\BracketMatch;
use App\Models\Sport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BracketController
{
    /**
     * Display all sports with their brackets.
     */
    public function index(): View
    {
        $university = app('current_university');

        $sports = Sport::with(['brackets.bracketMatches' => function ($q) {
            $q->with(['teamA', 'teamB', 'winner', 'schedule']);
        }])->get();

        return view('tenant.pro.brackets.index', [
            'university' => $university,
            'sports' => $sports,
        ]);
    }

    /**
     * Generate a new bracket for a sport.
     */
    public function generate(Request $request, string $university): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'type' => 'required|in:single_elimination,double_elimination,round_robin',
        ]);

        $sport = Sport::with('teams')->findOrFail($validated['sport_id']);

        // Check if bracket already exists
        if ($sport->bracket) {
            return back()
                ->with('error', 'A bracket already exists for this sport. Reset it first before generating a new one.');
        }

        // Check minimum teams
        if ($sport->teams->count() < 2) {
            return back()
                ->with('error', 'Need at least 2 teams to generate a bracket.');
        }

        // Create bracket
        $bracket = Bracket::create([
            'university_id' => $university->id,
            'sport_id' => $sport->id,
            'type' => $validated['type'],
            'status' => 'active',
        ]);

        // Generate matches
        $this->generateMatches($bracket, $sport->teams);

        return redirect()->route('tenant.pro.brackets.show', [
            'university' => $university->slug,
            'sport' => $sport->id,
        ])->with('success', 'Bracket generated successfully.');
    }

    /**
     * Display bracket for a specific sport.
     */
    public function show(string $university, Sport $sport): View
    {
        $university = app('current_university');

        $sport->load(['bracket.bracketMatches' => function ($q) {
            $q->with(['teamA', 'teamB', 'winner', 'schedule'])
                ->orderBy('round')
                ->orderBy('id');
        }, 'teams']);

        $matchesByRound = $sport->bracket
            ? $sport->bracket->bracketMatches->groupBy('round')
            : collect();

        return view('tenant.pro.brackets.show', [
            'university' => $university,
            'sport' => $sport,
            'matchesByRound' => $matchesByRound,
        ]);
    }

    /**
     * Update a bracket match result.
     */
    public function updateMatch(Request $request, string $university, BracketMatch $bracketMatch): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'winner_id' => 'required|exists:teams,id',
        ]);

        // Verify winner is one of the teams
        if ($validated['winner_id'] !== $bracketMatch->team_a_id && $validated['winner_id'] !== $bracketMatch->team_b_id) {
            return back()
                ->with('error', 'Winner must be one of the teams in this match.');
        }

        $bracketMatch->update(['winner_id' => $validated['winner_id']]);

        // Advance winners if all matches in round are completed (for single elimination)
        if ($bracketMatch->bracket->type === 'single_elimination') {
            $bracket = $bracketMatch->bracket;
            $currentRoundMatches = $bracket->bracketMatches()
                ->where('round', $bracketMatch->round)
                ->get();

            if ($currentRoundMatches->every(fn ($match) => $match->winner_id)) {
                $this->advanceWinners($bracket);
            }
        }

        return redirect()->back()
            ->with('success', 'Match result updated.');
    }

    /**
     * Reset bracket for a sport.
     */
    public function reset(string $university, Sport $sport): RedirectResponse
    {
        $university = app('current_university');

        if ($sport->bracket) {
            $sport->bracket->bracketMatches()->delete();
            $sport->bracket()->delete();
        }

        return redirect()->route('tenant.pro.brackets.index', [
            'university' => $university->slug,
        ])->with('success', 'Bracket has been reset.');
    }

    /**
     * Generate bracket matches.
     */
    private function generateMatches(Bracket $bracket, $teams): void
    {
        $teams = $teams->shuffle()->values();

        if ($bracket->type === 'single_elimination') {
            $teamCount = $teams->count();
            $matchNumber = 1;

            for ($i = 0; $i < $teamCount; $i += 2) {
                $teamA = $teams[$i];
                $teamB = isset($teams[$i + 1]) ? $teams[$i + 1] : null;

                BracketMatch::create([
                    'bracket_id' => $bracket->id,
                    'team_a_id' => $teamA->id,
                    'team_b_id' => $teamB?->id,
                    'round' => 1,
                    'match_number' => $matchNumber++,
                ]);
            }
        } elseif ($bracket->type === 'round_robin') {
            $teamArray = $teams->toArray();
            $teamCount = count($teamArray);
            $matchNumber = 1;

            for ($i = 0; $i < $teamCount; $i++) {
                for ($j = $i + 1; $j < $teamCount; $j++) {
                    BracketMatch::create([
                        'bracket_id' => $bracket->id,
                        'team_a_id' => $teamArray[$i]['id'],
                        'team_b_id' => $teamArray[$j]['id'],
                        'round' => 1,
                        'match_number' => $matchNumber++,
                    ]);
                }
            }
        }
    }

    /**
     * Advance winners to the next round.
     */
    private function advanceWinners(Bracket $bracket): void
    {
        $currentRound = $bracket->bracketMatches()
            ->max('round');

        $winners = $bracket->bracketMatches()
            ->where('round', $currentRound)
            ->pluck('winner_id')
            ->toArray();

        // If only 1 winner, bracket is complete
        if (count($winners) === 1) {
            $bracket->update(['status' => 'completed']);

            return;
        }

        // Create next round matches
        $winners = array_values($winners);
        $matchNumber = 1;

        for ($i = 0; $i < count($winners); $i += 2) {
            $teamA = $winners[$i];
            $teamB = isset($winners[$i + 1]) ? $winners[$i + 1] : null;

            BracketMatch::create([
                'bracket_id' => $bracket->id,
                'team_a_id' => $teamA,
                'team_b_id' => $teamB,
                'round' => $currentRound + 1,
                'match_number' => $matchNumber++,
            ]);
        }
    }
}
