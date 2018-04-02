<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JPush\Client as JPush;

class JPushController extends Controller
{
    public function PushTest()
    {
        $client = new JPush(env('jpush_app_key'), env('jpush_master_secret'), null);
        // $push = $client->push();
        $client->push()
        ->setPlatform('all')
        ->addAllAudience()
        ->setNotificationAlert('有人来访问你家啦！')
        ->send();

        return "ok";
    }
}
