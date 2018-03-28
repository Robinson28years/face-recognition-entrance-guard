<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserPropertyResource extends Resource
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
            'email' => $this->email,
            'role' => $this->role,
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
