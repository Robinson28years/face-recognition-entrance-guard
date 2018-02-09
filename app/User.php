<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * 获得此用户的角色。
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role','user_roles');
    }

    /**
     * 获得此用户的绑定的地址。
     */
    public function addresses()
    {
        return $this->belongsToMany('App\Address','user_addresses');
    }

    /**
     * 获得此用户的识别码。
     */
    public function code()
    {
        return $this->hasOne('App\UserCode');
    }
}
