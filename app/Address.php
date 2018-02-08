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
}
