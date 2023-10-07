<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'public_id'     => $this->public_id,
            'name'          => $this->name,
            'skill_level'   => $this->skill_level,
            'is_goalkeeper' => $this->is_goalkeeper,
            'is_presence'   => $this->is_presence,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
