<?php

namespace App\Http\Controllers;

use App\Visit;
use Illuminate\Http\Request;
use App\Http\Resources\VisitCollection;
use App\Http\Resources\Visit as VisitResource;
use App\User;
use App\Building;
use App\Address;
use App\UserAddress;

class VisitController extends Controller
{

    public function latest()
    {
        // dd(Visit::all()->last());
        return new VisitResource(Visit::all()->last());
    }

    /**
     * 列出所有访问记录
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($user->addresses);
        return new VisitCollection(Visit::all());
    }

    /**
     * 获取某个用户的所有访问记录
     *
     * @return \Illuminate\Http\Response
     */
    public function userIndex(User $user)
    {
        // dd($address2);
        return new VisitCollection($user->visits);
    }

    /**
     * 获取某个楼幢的所有访问记录
     *
     * @return \Illuminate\Http\Response
     */
    public function buildingIndex(Building $building)
    {
        // dd($address2);
        return new VisitCollection($building->visits);
    }

    /**
     * 获取某个住户地址的所有访问记录
     *
     * @return \Illuminate\Http\Response
     */
    public function addressIndex(Address $address)
    {
        // dd($address2);
        return new VisitCollection($address->visits);
    }

    /**
     * 列出某地址所有的用户以及角色和时间段
     *
     * @return \Illuminate\Http\Response
     */
    // public function userIndex(Address $address)
    // {
    //     // dd($address->users);
    //     return new AddressUserCollection($address->users);
    //     // return new UserAddressCollection($address->users);
    // }

    /**
     * 为地址注册用户并绑定权限和时间
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request,Address $address)
    {
        $visit = $address->visits()->create($request->all());
        // dd($visit);
        return new VisitResource($visit);
    }

    public function sendMsg(Request $request)
    {
        // dd($request->fd);
        $temp = Visit::create([
            'user_id'=>2,
            'address_id'=>1,
            'pic_path'=>'ZGWaEUXXm0s6OyXLMOnpKKScjoT1jHISIxNzrf5I.jpeg',
            'attendant_num'=>0,
            'result'=>'通过'
        ]);
        // dd($temp);
        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        $client->connect('127.0.0.1', 9998) || exit("connect failed. Error: {$client->errCode}\n");
        
        // 向服务端发送数据
        for ($i = 0; $i < 1; $i++) {
            $client->send(json_encode([
                'type'  =>  'scan',
                'uuid'    =>  $request->uuid,
            ]));
            //todo:解决开哪幢门问题
            $client->send(json_encode([
                'type'  =>  'open',
                'building_id' => $request->building_id
            ]));
        }
        $client->close(); 
    }

    public function switchAuth(Request $request)
    {
        // dd($request->fd);
        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        $client->connect('127.0.0.1', 10000) || exit("connect failed. Error: {$client->errCode}\n");
        
        // 向服务端发送数据
        if($request->type == "open"){
            for ($i = 0; $i < 1; $i++) {
                $client->send(json_encode([
                    'type'  =>  'open',
                    'building_id' => $request->building_id
                ]));
            }
        }else {
            for ($i = 0; $i < 1; $i++) {
                $client->send(json_encode([
                    'type'  =>  'close',
                    'building_id' => $request->building_id
                ]));
            }
        }
        $client->close(); 
    }

    public function autoOpen($building_id)
    {
        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        $client->connect('127.0.0.1', 10000) || exit("connect failed. Error: {$client->errCode}\n");

        for ($i = 0; $i < 1; $i++) {
            $client->send(json_encode([
                'type'  =>  'open',
                'building_id' => $building_id
            ]));
        }
        // return "ok";
    }

    public function changeState(Request $request)
    {
        // $time = "{"date":["2018-04-12","2018-04-28"],"week":[0,1,2,3,4,5,6,7]}";
        $time = UserAddress::first()->time;
        $address_id=$request->address_id;
        $user_id = $request->user_id;
        //todo:授权者
    //    $userAddress = UserAddress::updateOrCreate(['address_id'=>$address_id,
    //    'user_id'=>$user_id,
    //    'role_id' => 9,
    //    'grantor'=>1,
    //    'time'=>$time,
    //    ]);

        $userAddress = UserAddress::where(['address_id'=>$address_id,'user_id'=>$user_id])->first();
        if($userAddress==null){
            UserAddress::create([
                'user_id'=>$user_id,
                'address_id'=>$address_id,
                'role_id'=>9,
                'time'=>$time,
                'grantor'=>2
            ]);
        }else{
            // $userAddress->update([

            // ])
        }
    //    dd($time);
    //    $userAddress->update(['role_id' => 9]);
       $visit = Visit::where(['user_id'=>$user_id])->orderBy('created_at', 'desc')->first();
    //    dd($visit);
        $visit->update(['result'=>"通过",'address_id'=>$address_id]);
        return "ok";
    //    $userAddress->update('role_id',9);
    }

    
}
