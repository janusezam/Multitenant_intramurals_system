<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'sport_id',
        'name',
        'coach_id',
        'logo',
        'color',
        'status',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function homeSchedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'home_team_id');
    }

    public function awaySchedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'away_team_id');
    }

    public function matchResults(): HasMany
    {
        return $this->hasMany(MatchResult::class, 'winner_team_id');
    }

    public function standing(): BelongsTo
    {
        return $this->belongsTo(Standing::class);
    }
}
