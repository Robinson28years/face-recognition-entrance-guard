<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserAddressCollection;
use App\Http\Resources\UserAddress as UserAddressResource;
use App\User;
use App\Address;
use App\Http\Resources\AddressUser as AddressUserResource;
use App\Http\Resources\AddressUserCollection;
use function GuzzleHttp\json_decode;
use App\UserAddress;

class UserAddressController extends Controller
{

    /**
     * 列出某用户所有的地址以及角色和时间段
     *
     * @return \Illuminate\Http\Response
     */
    public function addressIndex(User $user)
    {
        // dd($user->addresses);
        return new UserAddressCollection($user->addresses);
    }

    /**
     * 列出某用户在某地址拥有的角色和时间段
     *
     * @return \Illuminate\Http\Response
     */
    public function userAddress(User $user,Address $address)
    {
        $address2 = $user->addresses()->find($address->id);
        // dd($address2);
        return new UserAddressResource($address2);
    }

    /**
     * 列出某地址所有的用户以及角色和时间段
     *
     * @return \Illuminate\Http\Response
     */
    public function userIndex(Address $address)
    {
        // dd($address->users);
        return new AddressUserCollection($address->users);
        // return new UserAddressCollection($address->users);
    }

    /**
     * 为地址注册用户并绑定权限和时间
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request,Address $address)
    {
        $address->users()->attach($request->user_id,[
            // 'address_id' => $request->address_id,
            'role_id' => $request->role_id,
            'time' => serialize($request->time),
            'grantor' => $request->grantor,
        ]);

        $user = User::find($request->user_id);
        $address2 = $user->addresses()->find($address->id);
        return new UserAddressResource($address2);
    }

     /**
     * 更新绑定权限和时间
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,User $user,Address $address)
    {
        // return "0";
        // return $request->time;
        // var_dump($request->date);
        // $staff=array("name"=>"洪七","number"=>"101","sex"=>"男","job"=>"总经理");
                // dd($staff);
        // UserAddress::where(['user_id'=>$user->id,'address_id'=>$address_id])
        // dd($request->all());
        // dd(json_decode($request->time,true));
        // if($request->time!=null){
        //     $request->all()['time']=serialize(json_decode($request->time,true));
        // }
        // dd($request->all());
        $user->addresses()->updateExistingPivot($address->id,$request->all());
        // $time = $request->time;
        // dd(json_decode($time,false));
        // dd($request);
        if($request->time!=null){
            $user->addresses()->updateExistingPivot($address->id,['time'=>serialize(json_decode($request->time,true))]);
        }else{
            // $user->addresses()->updateExistingPivot($address->id,$request->all());
        }
        $address2 = $user->addresses()->find($address->id);
        return new UserAddressResource($address2);
    }   

    /**
     * 删除某用户与地址的绑定
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user,Address $address)
    {
        $user->addresses()->detach($address->id);
        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * 测试时间接收
     */
    public function test(Request $request)
    {
        // dd($request);
        $date_serialize = serialize($request->all());            // 序列化成字符串
        // $date_json = json_encode($date);               // JSON编码数组成字符串
        var_dump($date_serialize);
        return "ok";
    }
}