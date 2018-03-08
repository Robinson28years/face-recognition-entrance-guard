<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserAddressCollection;
use App\Http\Resources\UserAddress as UserAddressResource;
use App\User;
use App\Address;
use App\Http\Resources\AddressUser as AddressUserResource;
use App\Http\Resources\AddressUserCollection;

class UserAddressController extends Controller
{

    /**
     * 列出某用户所有的地址以及角色和时间段
     *
     * @return \Illuminate\Http\Response
     */
    public function addressIndex(User $user)
    {
        // dd($user->addresses);
        return new UserAddressCollection($user->addresses);
    }

    /**
     * 列出某用户在某地址拥有的角色和时间段
     *
     * @return \Illuminate\Http\Response
     */
    public function userAddress(User $user,Address $address)
    {
        $address2 = $user->addresses()->find($address->id);
        // dd($address2);
        return new UserAddressResource($address2);
    }

    /**
     * 列出某地址所有的用户以及角色和时间段
     *
     * @return \Illuminate\Http\Response
     */
    public function userIndex(Address $address)
    {
        // dd($address->users);
        return new AddressUserCollection($address->users);
        // return new UserAddressCollection($address->users);
    }

    /**
     * 为地址注册用户并绑定权限和时间
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request,Address $address)
    {
        $address->users()->attach($request->user_id,[
            // 'address_id' => $request->address_id,
            'role_id' => $request->role_id,
            'time' => $request->time,
            'grantor' => $request->grantor,
        ]);

        $user = User::find($request->user_id);
        $address2 = $user->addresses()->find($address->id);
        return new UserAddressResource($address2);
    }

     /**
     * 更新绑定权限和时间
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,User $user,Address $address)
    {
        $user->addresses()->updateExistingPivot($address->id,$request->all());
        $address2 = $user->addresses()->find($address->id);
        return new UserAddressResource($address2);
    }   

    /**
     * 删除某用户与地址的绑定
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user,Address $address)
    {
        $user->addresses()->detach($address->id);
        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * 测试时间接收
     */
    public function test(Request $request)
    {
        dd($request);
        return null;
    }
}