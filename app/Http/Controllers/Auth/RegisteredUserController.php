<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $universities = University::where('is_active', true)
            ->withoutGlobalScopes()
            ->orderBy('name')
            ->get();

        return view('auth.register', [
            'universities' => $universities,
        ]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8'],
            'university_id' => ['required', 'exists:universities,id'],
            'role' => ['required', Rule::in(['sports-facilitator', 'team-coach', 'student-player'])],
        ]);

        // Check if university is active
        $university = University::withoutGlobalScopes()
            ->findOrFail($request->university_id);

        if (! $university->is_active) {
            return back()
                ->withInput()
                ->with('error', 'The selected university is not accepting new registrations.');
        }

        // Check user limits based on plan
        $userCount = User::where('university_id', $university->id)->count();

        if ($university->plan === 'basic' && $userCount >= 50) {
            return back()
                ->withInput()
                ->with('error', 'This university has reached the maximum user limit for the Basic Plan.');
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'university_id' => $request->university_id,
        ]);

        // Assign role
        $user->assignRole($request->role);

        // Fire Registered event
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // Redirect to tenant dashboard
        return redirect()->route('tenant.dashboard', ['university' => $university->slug]);
    }
}
