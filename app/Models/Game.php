<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Game
 * @package App\Models
 *
 * @property int    $id
 * @property string $public_id
 * @property string $team_a_id
 * @property int    $team_b_id
 * @property Carbon $game_at
 * @property Carbon $game_date_at
 * @property Carbon $game_time_at
 *
 * @property Team $teamA
 * @property Team $teamB
 * @property Team $teams
 */
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
