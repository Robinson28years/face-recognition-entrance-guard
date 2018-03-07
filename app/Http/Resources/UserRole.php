<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserRole extends Resource
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
            "user" => $this->user_id,
            "role" => $this->role_id,
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
