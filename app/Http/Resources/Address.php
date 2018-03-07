<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Address extends Resource
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
            'building_id' => $this->building_id,
            'unit_id' => $this->unit_id,
            'room_id' => $this->room_id,
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
