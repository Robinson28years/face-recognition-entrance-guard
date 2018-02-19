<?php

use Illuminate\Http\Request;
// use Symfony\Component\Routing\Annotation\Route;
use App\Http\Resources\RoleCollection;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;
use App\Role;
use App\Http\Resources\Role as RoleResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//角色
Route::get('/roles','RoleController@index');
Route::get('/roles/{role}','RoleController@show');
Route::post('/roles','RoleController@store');
Route::patch('/roles/{role}','RoleController@update');
Route::delete('/roles/{role}','RoleController@destroy');

//权限
Route::get('/permissions','PermissionController@index');
Route::get('/permissions/{permission}','PermissionController@show');
Route::post('/permissions','PermissionController@store');
Route::patch('/permissions/{permission}','PermissionController@update');
Route::delete('/permissions/{permission}','PermissionController@destroy');

//用户
Route::get('/users','UserController@index');
Route::get('/users/{user}','UserController@show');
Route::post('/users','UserController@store');
Route::patch('/users/{user}','UserController@update');
Route::delete('/users/{user}','UserController@destroy');

//楼幢
Route::get('/buildings','BuildingController@index');
Route::get('/buildings/{building}','BuildingController@show');
Route::post('/buildings','BuildingController@store');
Route::patch('/buildings/{building}','BuildingController@update');
Route::delete('/buildings/{building}','BuildingController@destroy');

//用户与角色
Route::get('/users/{user}/roles','UserRoleController@roleIndex');
Route::get('/roles/{role}/users','UserRoleController@userIndex');
Route::post('/users/{user}/roles','UserRoleController@store');
Route::delete('/users/{user}/roles/{role}','UserRoleController@destroy');

//角色与权限
Route::get('/roles/{role}/permissions','RolePermissionController@permissionIndex');
Route::post('/roles/{role}/permissions','RolePermissionController@store');
Route::delete('/roles/{role}/permissions/{permission}','RolePermissionController@destroy');

//楼幢与住户地址
Route::get('/buildings/{building}/addresses','AddressController@addressIndex');
Route::post('/addresses','AddressController@store');
Route::delete('/addresses/{address}','AddressController@destroy');

//用户与地址
Route::get('/users/{user}/addresses','UserAddressController@addressIndex');
Route::get('/users/{user}/addresses/{address}','UserAddressController@userAddress');
Route::get('/addresses/{address}/users','UserAddressController@userIndex');