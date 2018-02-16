<?php

namespace App\Http\Controllers;

use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Resources\UserRole as UserRoleResource;
use App\Http\Resources\UserRoleCollection;
use App\User;
use App\Role;
use App\Http\Resources\UserCollection;

class UserRoleController extends Controller
{

    /**
     * 列出某用户所有角色
     *
     * @return \Illuminate\Http\Response
     */
    public function roleIndex(User $user)
    {
        return $user->roles;
    }

    /**
     * 列出某角色所有用户
     *
     * @return \Illuminate\Http\Response
     */
    public function userIndex(Role $role)
    {
        return new UserCollection($role->users);
    }

    /**
     * 新建一个角色
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $role = UserRole::create($request->all());
        // dd($role->id);
        return new UserRoleResource($role);

    }

    /**
     * 获取某个角色的信息
     *
     * @param  \App\UserRole  $role
     * @return \Illuminate\Http\Response
     */
    public function show(UserRole $role)
    {
        return new UserRoleResource($role);
    }

    /**
     * 更新某个资源
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserRole  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRole $role)
    {
        $role->update($request->all());
        return new UserRoleResource($role);
    }

    /**
     * 删除某个角色
     *
     * @param  \App\UserRole  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRole $role)
    {
        $r = $role->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}