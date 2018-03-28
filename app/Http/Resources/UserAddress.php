<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserAddress extends Resource
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
            'address' => [
                'address_id' => $this->id,
                'building_id' => $this->building_id,
                'unit_id' => $this->unit_id,
                'room_id' => $this->room_id,
            ],
            'role_id' => $this->whenPivotLoaded('user_addresses',function () {
                return $this->pivot->role_id;
            }),
            'time' => $this->whenPivotLoaded('user_addresses',function () {
                return unserialize($this->pivot->time);
            }),
            'grantor' => $this->whenPivotLoaded('user_addresses',function () {
                return $this->pivot->grantor;
            }),
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
