<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Role;
use App\User;
use App\Http\Resources\Role as RoleResource;

class AddressUser extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $role = Role::find($this->pivot->role_id);
        $nickname = $this->pivot->nickname;
        if($nickname==null){
            $nickname = User::find($this->id)->name;
        }
        // $pic_path = $this->visits->last()->pic_path;
        if($this->visits->last()) {
            $pic_path = $this->visits->first()->pic_path;
            // var_dump($pic_path);
        }else {
            $pic_path = null;
        }
        // dd($pic_path);
        return [
            'user_id' => $this->id,
            'nickname' => $nickname,
            'role' => new RoleResource($role),
            'time' => $this->whenPivotLoaded('user_addresses',function () {
                return unserialize($this->pivot->time);
            }),
            'pic' => "pic/$pic_path",
            'created_at' => $this->pivot->created_at->toDateTimeString(),
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
