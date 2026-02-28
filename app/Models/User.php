<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'university_id',
        'student_id',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function facilitatedSports(): HasMany
    {
        return $this->hasMany(Sport::class, 'facilitator_id');
    }

    public function coachedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'coach_id');
    }

    public function recordedResults(): HasMany
    {
        return $this->hasMany(MatchResult::class, 'recorded_by');
    }

    /**
     * Get the redirect route and parameters for this user based on their role.
     * Returns array with 'route' name and 'params' for dashboard redirect.
     */
    public function getDashboardRedirect(): array
    {
        if ($this->hasRole('super-admin')) {
            return [
                'route' => 'admin.dashboard',
                'params' => [],
            ];
        }

        if ($this->university) {
            return [
                'route' => 'tenant.dashboard',
                'params' => ['university' => $this->university->slug],
            ];
        }

        // Fallback
        return [
            'route' => 'home',
            'params' => [],
        ];
    }
}
