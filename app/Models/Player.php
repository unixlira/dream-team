<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Player
 * @package App\Models
 *
 * @property int    $id
 * @property string $public_id
 * @property string $name
 * @property int    $skill_level
 * @property bool   $is_goalkeeper
 *
 * @property Presence $presence
 */
class Player extends Model
{
    use HasFactory, GeneratesUuid;

    protected $fillable = [
        'public_id',
        'name',
        'skill_level',
        'is_goalkeeper',
        'is_presence'
    ];

    protected $casts = [
        'is_goalkeeper' => 'boolean',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::bootGeneratesUuid();
    }

}

