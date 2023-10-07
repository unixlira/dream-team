<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
