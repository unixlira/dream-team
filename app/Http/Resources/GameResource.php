<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'public_id'    => $this->public_id,
            'game_at'      => $this->game_at,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,

            'teamA'        => TeamResource::make($this->whenLoaded('teamA')),
            'teamB'        => TeamResource::make($this->whenLoaded('teamA')),
        ];
    }
}
