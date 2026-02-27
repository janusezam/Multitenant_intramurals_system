<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'plan',
        'academic_year',
        'starts_at',
        'expires_at',
        'amount_paid',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'date',
            'expires_at' => 'date',
            'amount_paid' => 'decimal:2',
        ];
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
}
