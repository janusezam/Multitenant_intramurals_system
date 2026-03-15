<?php

namespace App\Http\Controllers\Tenant\Pro;

use App\Models\MatchResult;
use App\Models\Player;
use App\Models\Schedule;
use App\Models\Sport;
use App\Models\Standing;
use App\Models\Team;
use App\Models\Venue;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AnalyticsController
{
    /**
     * Display analytics dashboard.
     */
    public function index(): View
    {
        $university = app('current_university');

        // ─────────────────────────────────────
        // KPI STATS
        // ─────────────────────────────────────
        $totalPlayers = Player::count();
        $totalTeams = Team::count();
        $totalSports = Sport::count();
        $totalVenues = Venue::count();

        $gamesPlayed = Schedule::where('status', 'completed')->count();
        $gamesScheduled = Schedule::where('status', 'scheduled')->count();
        $gamesCancelled = Schedule::where('status', 'cancelled')->count();
        $gamesOngoing = Schedule::where('status', 'ongoing')->count();
        $totalGames = $gamesPlayed + $gamesScheduled
                    + $gamesCancelled + $gamesOngoing;

        $completionRate = $totalGames > 0
            ? round(($gamesPlayed / $totalGames) * 100)
            : 0;

        $kpis = [
            'total_players' => $totalPlayers,
            'total_teams' => $totalTeams,
            'total_sports' => $totalSports,
            'completion_rate' => $completionRate,
        ];

        // ─────────────────────────────────────
        // GAME ACTIVITY (for doughnut chart)
        // ─────────────────────────────────────
        $gameActivity = [
            'completed' => $gamesPlayed,
            'scheduled' => $gamesScheduled,
            'cancelled' => $gamesCancelled,
            'ongoing' => $gamesOngoing,
        ];

        // ─────────────────────────────────────
        // SPORTS PARTICIPATION (for bar chart)
        // ─────────────────────────────────────
        $sports = Sport::withCount(['teams', 'players', 'schedules'])
            ->get();

        $sportLabels = $sports->pluck('name')->toArray();
        $teamCounts = $sports->pluck('teams_count')->toArray();
        $playerCounts = $sports->pluck('players_count')->toArray();

        // ─────────────────────────────────────
        // SCHEDULE ACTIVITY PER SPORT (bar)
        // ─────────────────────────────────────
        $scheduleActivity = $sports->map(function ($sport) {
            return [
                'sport' => $sport->name,
                'completed' => Schedule::where('sport_id', $sport->id)
                    ->where('status', 'completed')->count(),
                'scheduled' => Schedule::where('sport_id', $sport->id)
                    ->where('status', 'scheduled')->count(),
                'cancelled' => Schedule::where('sport_id', $sport->id)
                    ->where('status', 'cancelled')->count(),
            ];
        });

        // ─────────────────────────────────────
        // TOP PERFORMING TEAMS (leaderboard)
        // ─────────────────────────────────────
        $topTeams = Standing::with(['team.sport'])
            ->orderBy('points', 'desc')
            ->orderBy('wins', 'desc')
            ->orderBy('losses', 'asc')
            ->take(10)
            ->get();

        // ─────────────────────────────────────
        // VENUE UTILIZATION
        // ─────────────────────────────────────
        $venues = Venue::withCount('schedules')
            ->orderBy('schedules_count', 'desc')
            ->get();

        $maxVenueCount = $venues->max('schedules_count') ?: 1;

        // ─────────────────────────────────────
        // SPORTS HEALTH TABLE
        // ─────────────────────────────────────
        $sportsHealth = Sport::with(['facilitator'])
            ->withCount([
                'teams',
                'players',
                'schedules',
                'schedules as completed_count' => fn ($q) => $q->where('status', 'completed'),
                'schedules as scheduled_count' => fn ($q) => $q->where('status', 'scheduled'),
            ])
            ->get()
            ->map(function ($sport) {
                $total = $sport->schedules_count;
                $sport->completion_pct = $total > 0
                    ? round(($sport->completed_count / $total) * 100)
                    : 0;

                return $sport;
            });

        // ─────────────────────────────────────
        // RECENT RESULTS FEED
        // ─────────────────────────────────────
        $recentResults = MatchResult::with([
            'schedule.sport',
            'schedule.homeTeam',
            'schedule.awayTeam',
            'schedule.venue',
            'winnerTeam',
        ])
            ->latest()
            ->take(5)
            ->get();

        // ─────────────────────────────────────
        // CHART DATA (passed as JSON to blade)
        // ─────────────────────────────────────
        $chartData = [
            'sport_labels' => $sportLabels,
            'team_counts' => $teamCounts,
            'player_counts' => $playerCounts,
            'game_activity' => $gameActivity,
            'schedule_activity' => $scheduleActivity,
        ];

        return view('tenant.pro.analytics.index', compact(
            'university',
            'kpis',
            'chartData',
            'gameActivity',
            'topTeams',
            'venues',
            'maxVenueCount',
            'sportsHealth',
            'recentResults',
            'completionRate',
            'totalGames',
        ));
    }

    /**
     * Export analytics to PDF.
     */
    public function exportPdf(string $university): Response
    {
        $university = app('current_university');

        // Sports analytics
        $sports = Sport::withCount(['teams', 'players', 'schedules'])
            ->with(['standings' => function ($q) {
                $q->with('team')->orderByDesc('points');
            }])
            ->get();

        // Venue analytics
        $venues = Venue::withCount('schedules')
            ->orderByDesc('schedules_count')
            ->get();

        // Game statistics
        $gameStats = [
            'completed' => Schedule::where('status', 'completed')->count(),
            'scheduled' => Schedule::where('status', 'scheduled')->count(),
            'cancelled' => Schedule::where('status', 'cancelled')->count(),
        ];

        // Top performers
        $topPerformers = Standing::with(['team', 'sport'])
            ->orderByDesc('points')
            ->orderByDesc('wins')
            ->take(10)
            ->get();

        $pdf = Pdf::loadView('tenant.pro.analytics.pdf', compact(
            'university',
            'sports',
            'venues',
            'topPerformers',
            'gameStats'
        ));

        return $pdf->download(
            $university->slug.'_analytics_'.now()->format('Y-m-d').'.pdf'
        );
    }

    /**
     * Export analytics to Excel.
     */
    public function exportExcel(string $university): BinaryFileResponse
    {
        $university = app('current_university');

        return Excel::download(
            new \App\Exports\AnalyticsExport($university),
            $university->slug.'_analytics_'.now()->format('Y-m-d').'.xlsx'
        );
    }
}
