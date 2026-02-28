<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'name',
        'description',
        'category',
        'bracket_type',
        'facilitator_id',
        'max_teams',
        'status',
        'logo',
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

    public function facilitator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'facilitator_id');
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

    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

    public function brackets(): HasMany
    {
        return $this->hasMany(Bracket::class);
    }
}
