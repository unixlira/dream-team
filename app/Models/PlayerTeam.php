<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlayerTeam extends Model
{
    use HasFactory, GeneratesUuid;

    protected $fillable = [
        'public_id',
        'player_id',
        'team_id',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::bootGeneratesUuid();
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
}
