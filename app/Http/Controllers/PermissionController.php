<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Resources\Permission as PermissionResource;
use App\Http\Resources\PermissionCollection;

class PermissionController extends Controller
{
    /**
     * 列出所有角色
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PermissionCollection(Permission::all());
    }

    /**
     * 新建一个角色
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $permission = Permission::create($request->all());
        // dd($permission->id);
        return new PermissionResource($permission);

    }

    /**
     * 获取某个角色的信息
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    /**
     * 更新某个资源
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $permission->update($request->all());
        return new PermissionResource($permission);
    }

    /**
     * 删除某个角色
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $r = $permission->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}
