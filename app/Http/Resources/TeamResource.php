<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'public_id'     => $this->public_id,
            'name'          => $this->name,
            'max_players'   => $this->max_players,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,

            'players'       => PlayerResource::collection($this->whenLoaded('players')),
        ];
    }
}
