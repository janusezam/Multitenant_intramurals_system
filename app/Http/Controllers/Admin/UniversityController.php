<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscription;
use App\Models\Team;
use App\Models\University;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UniversityController
{
    /**
     * Display a listing of universities.
     */
    public function index(): View
    {
        $universities = University::withoutGlobalScopes()
            ->with('subscription')
            ->paginate(10);

        return view('admin.universities.index', [
            'universities' => $universities,
        ]);
    }

    /**
     * Show the form for creating a new university.
     */
    public function create(): View
    {
        return view('admin.universities.create');
    }

    /**
     * Store a newly created university in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:universities,slug|max:100|regex:/^[a-z0-9-]+$/',
            'email' => 'required|email|unique:universities,email',
            'plan' => 'required|in:basic,pro',
            'plan_expires_at' => 'required|date|after:today',
        ]);

        $university = University::create(array_merge($validated, [
            'is_active' => true,
        ]));

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;

        Subscription::create([
            'university_id' => $university->id,
            'plan' => $validated['plan'],
            'academic_year' => "$currentYear-$nextYear",
            'starts_at' => Carbon::now(),
            'expires_at' => $validated['plan_expires_at'],
            'amount_paid' => 0.00,
            'status' => 'active',
        ]);

        return redirect()->route('admin.universities.index')
            ->with('success', 'University created successfully.');
    }

    /**
     * Display the specified university.
     */
    public function show(University $university): View
    {
        $university->load([
            'subscription',
            'users',
            'sports' => fn ($query) => $query->withoutGlobalScopes(),
        ]);

        $totalUsers = $university->users()->withoutGlobalScopes()->count();
        $totalSports = $university->sports()->withoutGlobalScopes()->count();
        $totalTeams = Team::withoutGlobalScopes()
            ->where('university_id', $university->id)
            ->count();
        $totalPlayers = $university->players()->withoutGlobalScopes()->count();

        $stats = [
            'total_users' => $totalUsers,
            'total_sports' => $totalSports,
            'total_teams' => $totalTeams,
            'total_players' => $totalPlayers,
        ];

        return view('admin.universities.show', [
            'university' => $university,
            'stats' => $stats,
            'users' => $university->users,
            'sports' => $university->sports,
        ]);
    }

    /**
     * Show the form for editing the specified university.
     */
    public function edit(University $university): View
    {
        return view('admin.universities.edit', [
            'university' => $university,
        ]);
    }

    /**
     * Update the specified university in storage.
     */
    public function update(Request $request, University $university): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9-]+$/', Rule::unique('universities', 'slug')->ignore($university->id)],
            'email' => ['required', 'email', Rule::unique('universities', 'email')->ignore($university->id)],
            'plan' => 'required|in:basic,pro',
            'plan_expires_at' => 'nullable|date|after:today',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'email' => $validated['email'],
            'plan' => $validated['plan'],
        ];

        if ($validated['plan_expires_at']) {
            $updateData['plan_expires_at'] = $validated['plan_expires_at'];
        }

        $university->update($updateData);

        if ($validated['plan_expires_at']) {
            $university->subscription?->update([
                'expires_at' => $validated['plan_expires_at'],
            ]);
        }

        return redirect()->route('admin.universities.index')
            ->with('success', 'University updated successfully.');
    }

    /**
     * Delete the specified university from storage.
     */
    public function destroy(University $university): RedirectResponse
    {
        $activeUsers = $university->users()->withoutGlobalScopes()->count();

        if ($activeUsers > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete university with active users.');
        }

        $university->delete();

        return redirect()->route('admin.universities.index')
            ->with('success', 'University deleted successfully.');
    }

    /**
     * Toggle the active status of a university.
     */
    public function toggleActive(University $university): RedirectResponse
    {
        $university->update([
            'is_active' => ! $university->is_active,
        ]);

        $message = $university->is_active ? 'University activated.' : 'University deactivated.';

        return redirect()->back()
            ->with('success', $message);
    }
}
