<?php

namespace App\Http\Controllers;

use App\Building;
use Illuminate\Http\Request;
use App\Http\Resources\Building as BuildingResource;
use App\Http\Resources\BuildingCollection;

class BuildingController extends Controller
{

    /**
     * 列出所有楼幢
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new BuildingCollection(Building::all());
    }

    /**
     * 新建一个楼幢
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $building = Building::create($request->all());
        // dd($building->id);
        return new BuildingResource($building);

    }

    /**
     * 获取某个楼幢的信息
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function show(Building $building)
    {
        return new BuildingResource($building);
    }

    /**
     * 更新某个资源
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Building $building)
    {
        $building->update($request->all());
        return new BuildingResource($building);
    }

    /**
     * 删除某个楼幢
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function destroy(Building $building)
    {
        $r = $building->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}
