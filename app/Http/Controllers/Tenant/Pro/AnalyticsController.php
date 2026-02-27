<?php

namespace App\Http\Controllers\Tenant\Pro;

use App\Models\Schedule;
use App\Models\Sport;
use App\Models\Standing;
use App\Models\Venue;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
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

        // Chart data
        $chartData = [
            'sportLabels' => $sports->pluck('name'),
            'teamCounts' => $sports->pluck('teams_count'),
            'playerCounts' => $sports->pluck('players_count'),
            'venueLabels' => $venues->pluck('name'),
            'venueCounts' => $venues->pluck('schedules_count'),
        ];

        return view('tenant.pro.analytics.index', [
            'university' => $university,
            'sports' => $sports,
            'venues' => $venues,
            'topPerformers' => $topPerformers,
            'gameStats' => $gameStats,
            'chartData' => $chartData,
        ]);
    }

    /**
     * Export analytics to PDF.
     */
    public function exportPdf(string $university): BinaryFileResponse
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
