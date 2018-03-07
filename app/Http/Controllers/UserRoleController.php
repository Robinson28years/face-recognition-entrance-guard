<?php

namespace App\Http\Controllers;

use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Resources\UserRole as UserRoleResource;
use App\Http\Resources\UserRoleCollection;
use App\User;
use App\Role;
use App\Http\Resources\UserCollection;
use App\Http\Resources\RoleCollection;

class UserRoleController extends Controller
{

    /**
     * 列出某用户所有角色
     *
     * @return \Illuminate\Http\Response
     */
    public function roleIndex(User $user)
    {
        return new RoleCollection($user->roles);
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
     * 赋予某用户某角色
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request,User $user)
    {
        // dd($request->role_id);
        $user->roles()->attach($request->role_id);
        // $role = UserRole::create($request->all());
        // dd($role->id);
        return new RoleCollection($user->roles);

    }


    /**
     * 删除某用户的某个角色
     *
     * @param  \App\UserRole  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user,Role $role)
    {
        $user->roles()->detach($role->id);
        return response()->json([
            'success' => true,
        ]);
    }
}