<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Team
 * @package App\Models
 *
 * @property int    $id
 * @property string $public_id
 * @property string $name
 * @property int    $max_players
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $game_time_at
 *
 * @property Player $players
 */
class Team extends Model
{
    use HasFactory, GeneratesUuid;

    protected $fillable = [
        'public_id',
        'name',
        'max_players',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::bootGeneratesUuid();
    }

    public function players(): HasMany
    {
        return $this->hasMany(PlayerTeam::class, 'team_id', 'id')->with('player');
    }

}
