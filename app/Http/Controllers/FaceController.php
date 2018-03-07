<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;
use Illuminate\Support\Facades\Redis;
use Webpatser\Uuid\Uuid;
use App\User;

class FaceController extends Controller
{
    public function request_by_curl($url, $data) {
        $postdata = http_build_query(
            $data
        );

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function auth(Building $building, Request $request)
    {
        $path = $request->file('file')->store('test2','local2');

        $real_path = env('PIC_PATH').'/'.$path;

        $client = new \GuzzleHttp\Client();
        $result = $client->request('POST', 'http://127.0.0.1:5000/feature', [
            'form_params' => [
                'filePath' => $real_path
            ]
        ]);

        $faceInfo = json_decode($result->getBody()->getContents(), true);
        $person = count($faceInfo);
        $flag = false;
        $flag2 = -1;
        for ($i=0; $i < $person; $i++) {
            $uuid = Uuid::generate();
            Redis::set($uuid,base64_decode($faceInfo[$i]));
            $user_id = $uuid->string;
            $client2 = new \GuzzleHttp\Client();
            // dd($uuid->string);
            $result2 = $client2->request('POST', 'http://127.0.0.1:5000/compare', [
                'form_params' => [
                    "user_id" => $user_id,
                    // "user_id" => $uuid,
    //                "FeatureB" => $featureB,
                ]
            ]);
    
            $compare = json_decode($result2->getBody()->getContents(), true);
            // return (string)$result->getBody();
            // $q = array_keys($compare, max($compare));
            // return max($compare);
            // return $q;
            // dd()
            if($compare['similarity']>=0.75){
                // $flag=0;
                Redis::del($uuid);
                // var_dump($uuid);
                $user = User::where('face_id',$compare['face_id'])->first();
                //如果是最后一个人，flag又是false，加到访问表
                //如果flag是true加到随行表
                // dd($user->addresses);
                foreach ($user->addresses as $address) {
                    var_dump($address->building->id);
                    if($address->building->id == $building->id) {
                        $flag = true;
                        // $flag2 = 1;
                    }
                }
            }else{
                // factory(User::class)->create(['role_id' => 2]);
                User::create(['face_id'=>$user_id]);
                //加到随行表
            }
        }
        if($flag) {
            return response()->json(['state'=>1,'open'=> true]);
        }elseif($person>0) {
            return response()->json(['state'=>1,'open'=> false]);
        }else{
            return response()->json(['state'=>2]);
        }


    }
}
