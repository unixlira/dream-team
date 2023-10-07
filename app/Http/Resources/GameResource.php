<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        $gameDateTime = Carbon::parse($this->game_at);

        return [
            'public_id'    => $this->public_id,
            'game_date_at' => $gameDateTime->format('d-m-Y'),
            'game_time_at' => $gameDateTime->format('H:i'),
            'game_at'      => $this->game_at,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,

            'teamA'      => TeamResource::make($this->whenLoaded('teamA')),
            'teamB'      => TeamResource::make($this->whenLoaded('teamA')),
        ];
    }
}
