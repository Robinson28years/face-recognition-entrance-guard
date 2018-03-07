<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Code extends Resource
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
            'user_id' => $this->id,
            'code' => $this->code,
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
