<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BracketMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'bracket_id',
        'schedule_id',
        'round',
        'match_order',
        'team_a_id',
        'team_b_id',
        'winner_id',
        'next_match_id',
        'status',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
        static::creating(function (self $model): void {
            $model->university_id = app('current_university')->id;
        });
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function bracket(): BelongsTo
    {
        return $this->belongsTo(Bracket::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function teamA(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_a_id');
    }

    public function teamB(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_b_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'winner_id');
    }

    public function nextMatch(): BelongsTo
    {
        return $this->belongsTo(BracketMatch::class, 'next_match_id');
    }
}
