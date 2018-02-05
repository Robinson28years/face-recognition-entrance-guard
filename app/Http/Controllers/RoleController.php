<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\RoleCollection;

class RoleController extends Controller
{

    /**
     * 列出所有角色
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RoleCollection(Role::all());
    }

    /**
     * 新建一个角色
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $role = Role::create($request->all());
        // dd($role->id);
        return new RoleResource($role);

    }

    /**
     * 获取某个角色的信息
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * 更新某个资源
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update($request->all());
        return new RoleResource($role);
    }

    /**
     * 删除某个角色
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $r = $role->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}
