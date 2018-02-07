<?php

namespace App\Http\Controllers;

use App\UserUserRole;
use Illuminate\Http\Request;
use App\Http\Resources\UserRole as UserRoleResource;
use App\Http\Resources\UserRoleCollection;

class UserRoleController extends Controller
{

    /**
     * 列出所有角色
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserRoleCollection(UserRole::all());
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