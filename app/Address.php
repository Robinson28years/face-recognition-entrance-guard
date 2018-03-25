<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 获得此地址位于的楼幢。
     */
    public function building()
    {
        return $this->belongsTo('App\Building');
    }

    /**
     * 获得此地址绑定的用户。
     */
    public function users()
    {
        return $this->belongsToMany('App\User','user_addresses')->withPivot('created_at','role_id','nickname','time','grantor')->withTimestamps();
    }

    /**
     * 获得此地址的所有访问记录。
     */
    public function visits()
    {
        return $this->hasMany('App\Visit');
    }
}
