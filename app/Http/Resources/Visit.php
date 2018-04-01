<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Address as AddressResource;
use App\Address;
use App\User;
use App\Role;
use App\Http\Resources\Role as RoleResource;

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
        $user = User::find($this->user_id);
        $address = $user->addresses()->find($this->address_id);
        if($address==null){
            $address = Address::find($this->address_id);
            if($user->name){
                $nickname = $user->name;
            }else{
                $nickname = "未知";
            }
            $role = Role::find(11);
        }else{
            $role = Role::find($address->pivot->role_id);
            if($user->name){
                $nickname = $user->name;
            }else{
                $nickname = $address->pivot->nickname;
            }
            
        }

        return [
            'id' => $this->id,
            // 'time' => $this->created_at->format('Y-m-d H:i:s'),
            'user_id' => $user->id,
            'nickname' => $nickname,
            'role' => new RoleResource($role),
            'address' => new AddressResource($address),
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
