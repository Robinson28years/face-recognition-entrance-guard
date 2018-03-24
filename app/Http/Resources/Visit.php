<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Address as AddressResource;
use App\Address;
use App\User;

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
            // 'time' => $this->created_at->format('Y-m-d H:i:s'),
            'user' => new UserResource(User::find($this->user_id)),
            'address' => new AddressResource(Address::find($this->address_id)),
            'pic' => 'pic/'.$this->pic_path,
            'result' => $this->result,
            'visit_time' => $this->created_at->toDateTimeString(),
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
