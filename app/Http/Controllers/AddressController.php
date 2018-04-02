<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use App\Building;
use App\Http\Resources\BuildingCollection;
use App\Http\Resources\AddressCollection;
use App\Http\Resources\Address as AddressResource;

class AddressController extends Controller
{

    /**
     * 列出某楼幢所有住户地址
     *
     * @return \Illuminate\Http\Response
     */
    public function addressIndex(Building $building)
    {
        return new AddressCollection($building->addresses);
    }

    /**
     * 列出所有住户地址
     *
     * @return \Illuminate\Http\Response
     */
    public function addressAll()
    {
        return new AddressCollection(Address::all());
    }

    /**
     * 将某地址绑定到楼幢上
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $address = Address::create($request->all());
        return new AddressResource($address);

    }

    /**
     * 删除某用户的某个角色
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}

