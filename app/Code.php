<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];
    
    // /**
    //  * 获得此识别码的用户。
    //  */
    // public function user()
    // {
    //     return $this->belongsTo('App\UserCode');
    // }
}
