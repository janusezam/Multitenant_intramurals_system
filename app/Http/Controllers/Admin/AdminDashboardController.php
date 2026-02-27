<?php

namespace App\Http\Controllers\Admin;

use App\Models\Player;
use App\Models\Sport;
use App\Models\University;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class AdminDashboardController
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $totalUniversities = University::withoutGlobalScopes()->count();
        $activeUniversities = University::withoutGlobalScopes()->where('is_active', true)->count();
        $basicPlanUniversities = University::withoutGlobalScopes()->where('plan', 'basic')->count();
        $proPlanUniversities = University::withoutGlobalScopes()->where('plan', 'pro')->count();

        $totalUsers = User::whereNull('university_id')->orWhereHas('university', function ($query) {
            $query->withoutGlobalScopes();
        })->count();

        $totalSports = Sport::withoutGlobalScopes()->count();
        $totalPlayers = Player::withoutGlobalScopes()->count();

        $recentUniversities = University::withoutGlobalScopes()
            ->with('subscription')
            ->latest()
            ->take(5)
            ->get();

        $expiringUniversities = University::withoutGlobalScopes()
            ->whereBetween('plan_expires_at', [
                Carbon::now(),
                Carbon::now()->addDays(30),
            ])
            ->get();

        return view('admin.dashboard', [
            'totalUniversities' => $totalUniversities,
            'activeUniversities' => $activeUniversities,
            'basicPlanUniversities' => $basicPlanUniversities,
            'proPlanUniversities' => $proPlanUniversities,
            'totalUsers' => $totalUsers,
            'totalSports' => $totalSports,
            'totalPlayers' => $totalPlayers,
            'recentUniversities' => $recentUniversities,
            'expiringUniversities' => $expiringUniversities,
        ]);
    }
}
