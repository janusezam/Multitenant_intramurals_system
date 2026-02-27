<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PlayerController
{
    /**
     * Display a listing of players.
     */
    public function index(): View
    {
        $university = app('current_university');

        $players = Player::with(['user', 'team.sport'])->paginate(10);

        return view('tenant.players.index', [
            'university' => $university,
            'players' => $players,
        ]);
    }

    /**
     * Show the form for creating a new player.
     */
    public function create(): View
    {
        $university = app('current_university');

        $teams = Team::with('sport')->orderBy('name')->get();

        $existingPlayerUserIds = Player::pluck('user_id')->toArray();
        $availableUsers = User::whereNotIn('id', $existingPlayerUserIds)
            ->orderBy('name')
            ->get();

        return view('tenant.players.create', [
            'university' => $university,
            'teams' => $teams,
            'availableUsers' => $availableUsers,
        ]);
    }

    /**
     * Store a newly created player in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:players,user_id',
            'team_id' => 'required|exists:teams,id',
            'jersey_number' => 'nullable|string|max:10',
            'position' => 'nullable|string|max:50',
        ]);

        // Check jersey number uniqueness per team
        if ($validated['jersey_number']) {
            $jerseyExists = Player::where('team_id', $validated['team_id'])
                ->where('jersey_number', $validated['jersey_number'])
                ->exists();

            if ($jerseyExists) {
                return back()
                    ->withInput()
                    ->with('error', 'Jersey number already taken in this team.');
            }
        }

        // Check player limit for basic plan
        if ($university->plan === 'basic') {
            $playerCount = Player::where('university_id', $university->id)->count();

            if ($playerCount >= 200) {
                return back()
                    ->withInput()
                    ->with('error', 'This university has reached the maximum player limit for the Basic Plan (200 players).');
            }
        }

        Player::create(array_merge($validated, [
            'university_id' => $university->id,
            'sport_id' => Team::find($validated['team_id'])->sport_id,
            'status' => 'active',
        ]));

        return redirect()->route('tenant.players.index', ['university' => $university->slug])
            ->with('success', 'Player registered successfully.');
    }

    /**
     * Display the specified player.
     */
    public function show(string $university, Player $player): View
    {
        $university = app('current_university');

        $player->load(['user', 'team.sport']);

        return view('tenant.players.show', [
            'university' => $university,
            'player' => $player,
        ]);
    }

    /**
     * Show the form for editing the specified player.
     */
    public function edit(string $university, Player $player): View
    {
        $university = app('current_university');

        $teams = Team::with('sport')->orderBy('name')->get();

        return view('tenant.players.edit', [
            'university' => $university,
            'player' => $player,
            'teams' => $teams,
        ]);
    }

    /**
     * Update the specified player in storage.
     */
    public function update(Request $request, string $university, Player $player): RedirectResponse
    {
        $university = app('current_university');

        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'jersey_number' => 'nullable|string|max:10',
            'position' => 'nullable|string|max:50',
        ]);

        // Check jersey number uniqueness excluding current player
        if ($validated['jersey_number']) {
            $jerseyExists = Player::where('team_id', $validated['team_id'])
                ->where('jersey_number', $validated['jersey_number'])
                ->where('id', '!=', $player->id)
                ->exists();

            if ($jerseyExists) {
                return back()
                    ->withInput()
                    ->with('error', 'Jersey number already taken in this team.');
            }
        }

        $player->update(array_merge($validated, [
            'sport_id' => Team::find($validated['team_id'])->sport_id,
        ]));

        return redirect()->route('tenant.players.index', ['university' => $university->slug])
            ->with('success', 'Player updated successfully.');
    }

    /**
     * Delete the specified player from storage.
     */
    public function destroy(string $university, Player $player): RedirectResponse
    {
        $university = app('current_university');

        $player->delete();

        return redirect()->route('tenant.players.index', ['university' => $university->slug])
            ->with('success', 'Player removed successfully.');
    }
}
