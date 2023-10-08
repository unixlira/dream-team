<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerTeamResource extends JsonResource
{
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'public_id'  => $this->public_id,
            'reset'      => $this->reset,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'team'       => TeamResource::make($this->whenLoaded('team')),
        ];
    }
}
