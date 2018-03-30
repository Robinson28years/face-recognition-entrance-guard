<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Address as AddressResource;
use App\Http\Resources\AddressCollection;
use App\Http\Resources\AddressUser as AddressUserResource;
use App\Address;
use App\UserAddress;

class UserInfo extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $roles = array();
        $flag=false;
        $address=null;
        foreach($this->roles as $role) {
            if($role->name == 'owner'){
                $flag = true;
            }
            array_push($roles,$role->name);
        };
        if($flag){
            $userAddress = UserAddress::where(['user_id'=>$this->id,'role_id'=>5])->first();
            $address = Address::find($userAddress->address_id);
            // dd($address);
        }
        // dd($address);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'roles' => $roles,
            // 'address' => new AddressResource($address),
            'address' => $this->when($flag , function ()use($address) {
                return new AddressResource($address);
            }),
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
