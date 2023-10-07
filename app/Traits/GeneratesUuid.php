<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait GeneratesUuid
{
    public static function bootGeneratesUuid(): void
    {
        static::creating(function ($model) {
            $model->public_id = Uuid::uuid4()->toString();
        });
    }
}
