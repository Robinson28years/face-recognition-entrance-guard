<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;
use Illuminate\Support\Facades\Redis;
use Webpatser\Uuid\Uuid;
use App\User;
use Carbon\Carbon;
use App\Visit;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FaceController extends Controller
{
    public function pic_by_path($path)
    {   
        // $path = 'test2/Zq4dZ2K6dYMTUHlEbxBZgraxZV0uz2k5eJd8W029.jpeg';
        return (Storage::disk('local2')->get($path));
    }
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
        $path = $request->file('file')->store('','local2');

        $real_path = env('PIC_PATH').'/'.$path;

        $client = new \GuzzleHttp\Client();
        $result = $client->request('POST', 'http://127.0.0.1:5000/feature', [
            'form_params' => [
                'filePath' => $real_path
            ]
        ]);

        $user_id_final=null;
        $user_id_final_2=null;
        $user_id_final_3=null;
        $address_id_final=null;
        $pic_path=$path;

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
                $user_id_final_3 = $user->id;
                // dd($user->addresses);
                foreach ($user->addresses as $address) {
                    // var_dump($address->building->id);
                    if($address->building->id == $building->id) {
                        $address_id_final = $address->id;
                        $time = unserialize($address->pivot->time);
                        $week = Carbon::now()->dayOfWeek;
                        // dd(Carbon::now()->dayOfWeek);
                        if($time['date'][0]<=Carbon::now() && $time['date'][1]>=Carbon::now() && in_array($week,$time['week'])){
                            $user_id_final_2 = $user->id;
                            $flag = true;
                        }else{
                            // return "no";
                        }
                        // return Carbon::now()>$time['date'][0];
                        // dd($address->pivot->time);
                        
                        // $flag2 = 1;
                    }
                }
            //如果是最后一个人，flag又是false，加到访问表
                //如果flag是true加到随行表
            }else{
                // factory(User::class)->create(['role_id' => 2]);
                $user =  User::create(['face_id'=>$user_id]);
                $user_id_final_3 = $user->id;
                //加到随行表
            }
        }
        if($user_id_final_2!=null){
            $user_id_final = $user_id_final_2;
        }else{
            $user_id_final = $user_id_final_3;
        }

        if($flag) {
            Visit::create([
                'user_id'=>$user_id_final,
                'address_id'=>$address_id_final,
                'pic_path'=>$pic_path,
                'result'=>"通过"
            ]);
            return response()->json(['state'=>1,'open'=> true]);
        }elseif($person>0) {
            if($address_id_final!=null){
                $address_id_final = $building->addresses()->where('unit_id',0)->first()->id;
            }
            Visit::create([
                'user_id'=>$user_id_final,
                'address_id'=>$address_id_final,
                'pic_path'=>$pic_path,
                'result'=>"未通过"
            ]);
            return response()->json(['state'=>1,'open'=> false]);
        }else{
            return response()->json(['state'=>2]);
        }


    }

    public function face_auth(Request $request)
    {
        $path = $request->file('file')->store('auth','local2');

        $real_path = env('PIC_PATH').'/'.$path;

        $client = new \GuzzleHttp\Client();
        $result = $client->request('POST', 'http://127.0.0.1:5000/feature', [
            'form_params' => [
                'filePath' => $real_path
            ]
        ]);

        $faceInfo = json_decode($result->getBody()->getContents(), true);
        $person = count($faceInfo);
        for ($i=0; $i < $person; $i++) {
            $uuid = Uuid::generate();
            Redis::set($uuid,base64_decode($faceInfo[$i]));
            $user_id = $uuid->string;
            $client2 = new \GuzzleHttp\Client();
            // dd($uuid->string);
            $result2 = $client2->request('POST', 'http://127.0.0.1:5000/compare', [
                'form_params' => [
                    "user_id" => $user_id,
                ]
            ]);
    
            $compare = json_decode($result2->getBody()->getContents(), true);
            if($compare['similarity']>=0.75){

                Redis::del($uuid);
                $user = User::where('face_id',$compare['face_id'])->first();
                // dd($user);
                $auth = Auth::login($user);
                // dd($auth);
                return $this->auth->refresh();
            }else{

            }
        }
    }
}
