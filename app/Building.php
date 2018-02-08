<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 获得此楼幢的所有地址。
     */
    public function addresses()
    {
        return $this->hasMany('App\Address');
    }
}
