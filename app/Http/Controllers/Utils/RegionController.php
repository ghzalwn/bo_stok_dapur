<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    function getCityByProvId($id)
    {
        $city = City::where('province_id', $id)->get();
        if (isset($city) && !empty($city)) {
            return response()->json(['status' => true, 'data' => $city, 'message' => '']);
        }
        return response()->json(['status' => false, 'data' => [], 'message' => 'data not found!']);
    }

    function getDistrictByCityId($id)
    {
        $city = District::where('city_id', $id)->get();
        if (isset($city) && !empty($city)) {
            return response()->json(['status' => true, 'data' => $city, 'message' => '']);
        }
        return response()->json(['status' => false, 'data' => [], 'message' => 'data not found!']);
    }
}
