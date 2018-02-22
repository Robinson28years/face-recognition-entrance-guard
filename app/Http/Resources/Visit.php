<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Visit extends Resource
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
            'time' => $this->time,
            'user_id' => $this->user_id,
            'grantor' => $this->grantor,
            'address_id' => $this->address_id,
            'result' => $this->result,
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
