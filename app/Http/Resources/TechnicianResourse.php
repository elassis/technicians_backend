<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TechnicianResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'user_id' => $this->user_id,
          'type' => $this->user->type,
          'first_name' => $this->user->first_name,
          'last_name' => $this->user->last_name,
          'email' => $this->user->email,
          'address' => $this->user->getAddress(),
          'registered_since' => $this->user->created_at,
          'available' => $this->available,
          'rankingAvg' => $this->getRankingAvg(),
          'professions' => $this->getProfessionsData(),
        ];
    }
}
