<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'address',
        'logo',
        'plan',
        'plan_expires_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'plan_expires_at' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function sports(): HasMany
    {
        return $this->hasMany(Sport::class);
    }

    public function venues(): HasMany
    {
        return $this->hasMany(Venue::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function matchResults(): HasMany
    {
        return $this->hasMany(MatchResult::class);
    }

    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

    public function brackets(): HasMany
    {
        return $this->hasMany(Bracket::class);
    }

    public function bracketMatches(): HasMany
    {
        return $this->hasMany(BracketMatch::class);
    }
}
