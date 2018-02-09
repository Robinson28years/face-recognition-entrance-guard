<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 获取拜访者信息。
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * 获取拜访者的授权人。
     */
    public function grantor()
    {
        return $this->belongsTo('App\User','authorized_officer');
    }
}
