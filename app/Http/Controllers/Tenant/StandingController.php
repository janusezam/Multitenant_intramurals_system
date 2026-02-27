<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Sport;
use Illuminate\Contracts\View\View;

class StandingController
{
    /**
     * Display standings for all sports.
     */
    public function index(): View
    {
        $university = app('current_university');

        $sports = Sport::with(['standings' => function ($q) {
            $q->with('team')
                ->orderByDesc('points')
                ->orderByDesc('wins')
                ->orderBy('losses');
        }])
            ->orderBy('name')
            ->get();

        return view('tenant.standings.index', [
            'university' => $university,
            'sports' => $sports,
        ]);
    }

    /**
     * Display standings for a specific sport.
     */
    public function show(string $university, Sport $sport): View
    {
        $university = app('current_university');

        $sport->load(['standings' => function ($q) {
            $q->with('team')
                ->orderByDesc('points')
                ->orderByDesc('wins')
                ->orderBy('losses');
        }]);

        return view('tenant.standings.show', [
            'university' => $university,
            'sport' => $sport,
        ]);
    }
}
