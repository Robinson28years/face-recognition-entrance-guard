<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Time extends Resource
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
            'address_id' => $this->address_id,
            'time' => $this->time,
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
