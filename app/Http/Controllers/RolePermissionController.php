<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Http\Resources\PermissionCollection;
use App\Permission;

class RolePermissionController extends Controller
{

    /**
     * 列出某角色所有权限
     *
     * @return \Illuminate\Http\Response
     */
    public function permissionIndex(Role $role)
    {
        return new PermissionCollection($role->permissions);
    }

    /**
     * 赋予某角色某权限
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
