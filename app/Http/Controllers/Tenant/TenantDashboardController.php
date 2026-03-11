<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Schedule;
use App\Models\Sport;
use App\Models\Standing;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Contracts\View\View;

class TenantDashboardController extends Controller
{
    public function index(): View
    {
        $university = app('current_university');
        $user = auth()->user();

        if ($user->hasRole('university-admin')) {
            return $this->adminDashboard($university);
        }

        if ($user->hasRole('sports-facilitator')) {
            return $this->facilitatorDashboard($university, $user);
        }

        if ($user->hasRole('team-coach')) {
            return $this->coachDashboard($university, $user);
        }

        if ($user->hasRole('student-player')) {
            return $this->playerDashboard($university, $user);
        }

        // Fallback for any unrecognized role
        return $this->adminDashboard($university);
    }

    // ─────────────────────────────────────
    // UNIVERSITY ADMIN
    // Full system overview and management
    // ─────────────────────────────────────
    private function adminDashboard($university): View
    {
        $stats = [
            'total_sports' => Sport::count(),
            'total_teams' => Team::count(),
            'total_players' => Player::count(),
            'total_venues' => Venue::count(),
            'upcoming_schedules' => Schedule::where('status', 'scheduled')->count(),
            'ongoing_sports' => Sport::where('status', 'ongoing')->count(),
        ];

        $upcomingSchedules = Schedule::with([
            'sport', 'venue', 'homeTeam', 'awayTeam',
        ])
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        $sports = Sport::with(['teams', 'standings.team'])
            ->withCount(['teams', 'players', 'schedules'])
            ->get();

        $standings = Standing::with('team', 'sport')
            ->orderBy('points', 'desc')
            ->get()
            ->groupBy('sport_id');

        return view('tenant.dashboard.admin', compact(
            'university', 'stats',
            'upcomingSchedules', 'sports', 'standings'
        ));
    }

    // ─────────────────────────────────────
    // SPORTS FACILITATOR
    // Only sees their assigned sport
    // ─────────────────────────────────────
    private function facilitatorDashboard($university, $user): View
    {
        // Get the sport assigned to this facilitator
        $mySport = Sport::with([
            'teams.players',
            'schedules.homeTeam',
            'schedules.awayTeam',
            'schedules.venue',
        ])
            ->withCount(['teams', 'players', 'schedules'])
            ->where('facilitator_id', $user->id)
            ->first();

        $upcomingSchedules = collect();
        $standings = collect();

        if ($mySport) {
            $upcomingSchedules = Schedule::with([
                'homeTeam', 'awayTeam', 'venue',
            ])
                ->where('sport_id', $mySport->id)
                ->where('status', 'scheduled')
                ->orderBy('scheduled_at')
                ->take(5)
                ->get();

            $standings = Standing::with('team')
                ->where('sport_id', $mySport->id)
                ->orderBy('points', 'desc')
                ->orderBy('wins', 'desc')
                ->get();
        }

        $stats = [
            'total_teams' => $mySport?->teams_count ?? 0,
            'total_players' => $mySport?->players_count ?? 0,
            'total_schedules' => $mySport?->schedules_count ?? 0,
            'completed_games' => $mySport
                ? Schedule::where('sport_id', $mySport->id)
                    ->where('status', 'completed')
                    ->count()
                : 0,
        ];

        return view('tenant.dashboard.facilitator', compact(
            'university', 'user', 'mySport',
            'upcomingSchedules', 'standings', 'stats'
        ));
    }

    // ─────────────────────────────────────
    // TEAM COACH
    // Only sees their assigned team
    // ─────────────────────────────────────
    private function coachDashboard($university, $user): View
    {
        // Get the team assigned to this coach
        $myTeam = Team::with([
            'sport',
            'players.user',
        ])
            ->withCount('players')
            ->where('coach_id', $user->id)
            ->first();

        $upcomingSchedules = collect();
        $standing = null;

        if ($myTeam) {
            // Get games where this team is home OR away
            $upcomingSchedules = Schedule::with([
                'homeTeam', 'awayTeam', 'venue', 'sport',
            ])
                ->where(function ($query) use ($myTeam) {
                    $query->where('home_team_id', $myTeam->id)
                        ->orWhere('away_team_id', $myTeam->id);
                })
                ->where('status', 'scheduled')
                ->orderBy('scheduled_at')
                ->take(5)
                ->get();

            $standing = Standing::where('team_id', $myTeam->id)
                ->first();
        }

        return view('tenant.dashboard.coach', compact(
            'university', 'user', 'myTeam',
            'upcomingSchedules', 'standing'
        ));
    }

    // ─────────────────────────────────────
    // STUDENT PLAYER
    // Only sees their own profile and team
    // ─────────────────────────────────────
    private function playerDashboard($university, $user): View
    {
        // Get the player profile for this user
        $myPlayer = Player::with([
            'team.sport',
            'team.coach',
        ])
            ->where('user_id', $user->id)
            ->first();

        $upcomingSchedules = collect();
        $standing = null;
        $allStandings = collect();

        if ($myPlayer && $myPlayer->team) {
            $upcomingSchedules = Schedule::with([
                'homeTeam', 'awayTeam', 'venue', 'sport',
            ])
                ->where(function ($query) use ($myPlayer) {
                    $query->where('home_team_id', $myPlayer->team_id)
                        ->orWhere('away_team_id', $myPlayer->team_id);
                })
                ->where('status', 'scheduled')
                ->orderBy('scheduled_at')
                ->take(3)
                ->get();

            $standing = Standing::with('team')
                ->where('team_id', $myPlayer->team_id)
                ->first();

            // Full standings for their sport (read only)
            $allStandings = Standing::with('team')
                ->where('sport_id', $myPlayer->team->sport_id)
                ->orderBy('points', 'desc')
                ->orderBy('wins', 'desc')
                ->get();
        }

        return view('tenant.dashboard.player', compact(
            'university', 'user', 'myPlayer',
            'upcomingSchedules', 'standing', 'allStandings'
        ));
    }
}
