<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bracket extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'sport_id',
        'name',
        'type',
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

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(BracketMatch::class);
    }
}
