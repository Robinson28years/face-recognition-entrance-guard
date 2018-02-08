<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 获得此角色的用户。
     */
    public function users()
    {
        return $this->belongsToMany('App\User','user_roles');
    }

    /**
     * 获得此角色的权限。
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission','role_permissions');
    }
}
