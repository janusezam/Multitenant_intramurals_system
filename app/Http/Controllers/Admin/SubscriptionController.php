<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscription;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubscriptionController
{
    /**
     * Display a listing of subscriptions.
     */
    public function index(): View
    {
        $subscriptions = Subscription::withoutGlobalScopes()
            ->with('university')
            ->orderBy('expires_at', 'asc')
            ->paginate(10);

        return view('admin.subscriptions.index', [
            'subscriptions' => $subscriptions,
        ]);
    }

    /**
     * Show the form for editing the specified subscription.
     */
    public function edit(Subscription $subscription): View
    {
        $subscription->load('university');

        return view('admin.subscriptions.edit', [
            'subscription' => $subscription,
        ]);
    }

    /**
     * Update the specified subscription in storage.
     */
    public function update(Request $request, Subscription $subscription): RedirectResponse
    {
        $validated = $request->validate([
            'plan' => 'required|in:basic,pro',
            'academic_year' => 'required|string|max:20',
            'expires_at' => 'required|date|after:today',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        $subscription->update($validated);

        $subscription->university->update([
            'plan' => $validated['plan'],
            'plan_expires_at' => $validated['expires_at'],
        ]);

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription updated successfully.');
    }
}
