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
     * 某地址所有的用户及角色和时间段
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request,Role $role)
    {
        $role->permissions()->attach($request->permission_id);
        return new PermissionCollection($role->permissions);

    }

    /**
     * 删除某用户的某个角色
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role,Permission $permission)
    {
        $role->permissions()->detach($permission->id);
        return response()->json([
            'success' => true,
        ]);
    }
}