<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Player;
use App\Models\Schedule;
use App\Models\Sport;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Contracts\View\View;

class TenantDashboardController
{
    /**
     * Display the tenant dashboard.
     */
    public function index(): View
    {
        $university = app('current_university');

        $stats = [
            'total_sports' => Sport::count(),
            'total_venues' => Venue::count(),
            'total_teams' => Team::count(),
            'total_players' => Player::count(),
            'upcoming_schedules' => Schedule::where('status', 'scheduled')
                ->where('scheduled_at', '>=', now())
                ->count(),
            'ongoing_sports' => Sport::where('status', 'ongoing')->count(),
            'completed_sports' => Sport::where('status', 'completed')->count(),
        ];

        $recentSchedules = Schedule::with(['homeTeam', 'awayTeam', 'venue', 'sport'])
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        $sportsWithStandings = Sport::with(['standings' => function ($q) {
            $q->with('team')
                ->orderByDesc('points')
                ->orderByDesc('wins');
        }])
            ->where('status', 'ongoing')
            ->get();

        return view('tenant.dashboard', [
            'university' => $university,
            'stats' => $stats,
            'recentSchedules' => $recentSchedules,
            'sportsWithStandings' => $sportsWithStandings,
        ]);
    }
}
