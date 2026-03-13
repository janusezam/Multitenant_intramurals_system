<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tenant\MatchResultController;
use App\Http\Controllers\Tenant\PlayerController;
use App\Http\Controllers\Tenant\Pro\AnalyticsController;
use App\Http\Controllers\Tenant\Pro\BracketController;
use App\Http\Controllers\Tenant\ScheduleController;
use App\Http\Controllers\Tenant\SportController;
use App\Http\Controllers\Tenant\StandingController;
use App\Http\Controllers\Tenant\TeamController;
use App\Http\Controllers\Tenant\TenantDashboardController;
use App\Http\Controllers\Tenant\VenueController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', function () {
    if (auth()->check()) {
        // If user is super-admin, go to admin dashboard
        if (auth()->user()->hasRole('super-admin')) {
            return redirect('/admin/dashboard');
        }
        // Otherwise, go to tenant dashboard
        $university = auth()->user()->university;
        if ($university) {
            return redirect('/'.$university->slug.'/dashboard');
        }

        // Fallback to logout if no university
        return redirect('/login');
    }

    // If not authenticated, redirect to login
    return redirect('/login');
})->name('home');

// Custom Register Routes (Override Breeze Defaults)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Admin Routes (Super Admin Only)
Route::middleware(['auth', 'role:super-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // University Admin Account Creation Routes
        Route::get('universities/{university}/create-admin', [UniversityController::class, 'createAdmin'])
            ->name('universities.create-admin');
        Route::post('universities/{university}/store-admin', [UniversityController::class, 'storeAdmin'])
            ->name('universities.store-admin');

        // Existing universities routes
        Route::resource('universities', UniversityController::class);
        Route::patch('universities/{university}/toggle-active', [UniversityController::class, 'toggleActive'])
            ->name('universities.toggleActive');

        Route::resource('subscriptions', SubscriptionController::class)
            ->only(['index', 'edit', 'update']);
    });

// Tenant Routes
Route::middleware(['auth', 'tenant'])
    ->prefix('{university}')
    ->name('tenant.')
    ->group(function () {
        Route::get('/dashboard', [TenantDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('sports', SportController::class);
        Route::resource('venues', VenueController::class);
        Route::resource('teams', TeamController::class);
        Route::resource('players', PlayerController::class);
        Route::resource('schedules', ScheduleController::class);

        // Match Results (Nested under Schedules)
        Route::get('schedules/{schedule}/results/create', [MatchResultController::class, 'create'])
            ->name('results.create');
        Route::post('schedules/{schedule}/results', [MatchResultController::class, 'store'])
            ->name('results.store');
        Route::get('schedules/{schedule}/results/edit', [MatchResultController::class, 'edit'])
            ->name('results.edit');
        Route::put('schedules/{schedule}/results', [MatchResultController::class, 'update'])
            ->name('results.update');

        // Standings (Read-Only)
        Route::get('standings', [StandingController::class, 'index'])
            ->name('standings.index');
        Route::get('standings/{sport}', [StandingController::class, 'show'])
            ->name('standings.show');

        // Profile (Tenant-scoped)
        Route::get('profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])
            ->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');
    });

// Pro Plan Routes
Route::middleware(['auth', 'tenant', 'pro.plan'])
    ->prefix('{university}')
    ->name('tenant.')
    ->group(function () {
        // Analytics
        Route::get('analytics', [AnalyticsController::class, 'index'])
            ->name('analytics.index');
        Route::get('analytics/export-pdf', [AnalyticsController::class, 'exportPdf'])
            ->name('analytics.exportPdf');
        Route::get('analytics/export-excel', [AnalyticsController::class, 'exportExcel'])
            ->name('analytics.exportExcel');

        // Brackets
        Route::get('brackets', [BracketController::class, 'index'])
            ->name('brackets.index');
        Route::post('brackets/generate', [BracketController::class, 'generate'])
            ->name('brackets.generate');
        Route::get('brackets/{sport}', [BracketController::class, 'show'])
            ->name('brackets.show');
        Route::patch('brackets/matches/{bracketMatch}', [BracketController::class, 'updateMatch'])
            ->name('brackets.updateMatch');
        Route::delete('brackets/{sport}/reset', [BracketController::class, 'reset'])
            ->name('brackets.reset');
    });

require __DIR__.'/auth.php';
