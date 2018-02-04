<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Role extends Resource
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
            // 'alias' => $this->alias,
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
