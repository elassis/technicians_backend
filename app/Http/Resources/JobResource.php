<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'technician_id' => $this->technician_id,
            'technician_name' => $this->technician->user->first_name . ' ' . $this->technician->user->last_name,
            'profesion_id' => $this->profession_id,
            'profession' => $this->profession->name,
        ];
    }
}
