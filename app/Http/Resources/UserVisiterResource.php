<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Address as AddressResource;
use App\Address;
use App\User;
use App\Role;

class UserVisiterResource extends Resource
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
            'nickname' => $this->nickname,
            'address' => new AddressResource(Address::find($this->address_id)),
            'grantor' => User::find($this->grantor)->name,
            'role' => Role::find($this->role_id)->alias,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
