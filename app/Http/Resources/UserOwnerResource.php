<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Address as AddressResource;

class UserOwnerResource extends Resource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => new AddressResource($this->address_1),
            'created_at' => $this->created_at->toDateTimeString()
            // 'roles' => $roles,
            // 'addresses' => AddressUserResource::collection($this->addresses),
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
