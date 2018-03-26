<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PicPath extends Resource
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
            'user_id' => $this->user_id,
            'pic' => 'pic/'+$this->pic_path,
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
