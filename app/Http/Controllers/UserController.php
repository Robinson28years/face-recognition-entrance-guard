<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserInfo;
use App\Http\Resources\UserOwnerResource;

class UserController extends Controller
{
    /**
     * 根据token获取用户信息
     *
     * @return \Illuminate\Http\Response
     */
    public function user_info()
    {
        return new UserInfo(Auth::user());
    }
    /**
     * 管理员获取所有业主信息
     *
     * @return \Illuminate\Http\Response
     */
    public function user_owner()
    {
        // dd(Auth::user()->roles);
        $flag = false;
        foreach(Auth::user()->roles as $role) {
            if($role->name == 'admin' || $role->name == 'property'){
                $flag = true;
                break;
            }
        }
        if($flag){
            $userCollection = collect([]);
            foreach(User::all() as $user) {
                foreach($user->addresses as $address) {
                    if($address->pivot->role_id == 5){
                        $user->address_1 = $address;
                        $user->visiter_num = count($address->users)-1;
                        $userCollection->push($user);
                    }
                }
            }
            // dd($userCollection);
            return  UserOwnerResource::collection($userCollection);
        }
        // return new UserInfo(Auth::user());
        return "false";
    }

    public function user_property()
    {
        // dd(Auth::user()->roles);
        $flag = false;
        foreach(Auth::user()->roles as $role) {
            if($role->name == 'admin' || $role->name == 'property'){
                $flag = true;
                break;
            }
        }
        if($flag){
            $userCollection = collect([]);
            foreach(User::all() as $user) {
                if($user->roles->has(2))
                foreach($user->addresses as $address) {
                    if($address->pivot->role_id == 5){
                        $user->address_1 = $address;
                        $user->visiter_num = count($address->users)-1;
                        $userCollection->push($user);
                    }
                }
            }
            // dd($userCollection);
            return  UserOwnerResource::collection($userCollection);
        }
        // return new UserInfo(Auth::user());
        return "false";
    }
    

    /**
     * 列出所有用户
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserCollection(User::all());
    }

    /**
     * 新建一个用户
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $user = User::create($request->all());
        // dd($User->id);
        return new UserResource($user);

    }

    /**
     * 获取某个用户的信息
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * 更新某个资源
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return new UserResource($user);
    }

    /**
     * 删除某个用户
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $result = $user->delete();
        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * 列出所有用户
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::user();
        return $user->name;
    }
}
