<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kjmtrue\VietnamZone\Models\District;
use Kjmtrue\VietnamZone\Models\Ward;

class LocationController extends Controller
{
    public function getDistricts($provinceId)
    {
        return response()->json(District::where('province_id', $provinceId)->get());
    }

    public function getWards($districtId)
    {
        return response()->json(Ward::where('district_id', $districtId)->get());
    }
}
