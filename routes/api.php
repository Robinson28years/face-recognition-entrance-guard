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
// Route::resource('/roles','RoleController');
Route::get('/roles','RoleController@all');
Route::post('/roles','RoleController@store');
Route::get('/roles/{id}','RoleController@show');
Route::put('roles/{id}','RoleController@update');
