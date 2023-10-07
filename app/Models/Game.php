<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    use HasFactory, GeneratesUuid;

    protected $fillable = [
        'public_id',
        'team_a_id',
        'team_b_id',
        'game_at',
    ];

    protected $casts = [
        'game_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::bootGeneratesUuid();
    }

    public function teamA(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_a_id', 'id');
    }

    public function teamB(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_b_id', 'id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_games', 'game_id', 'team_id');
    }

}
