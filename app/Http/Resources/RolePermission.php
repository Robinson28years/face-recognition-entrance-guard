<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RolePermission extends Resource
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
            'role_id' => $this->role_id,
            'permission_id' => $this->permission_id,
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
