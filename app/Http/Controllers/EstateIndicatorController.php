<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\EstateIndicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstateIndicatorController extends Controller
{
    public function show(Request $request){
        $estateIndicator = EstateIndicator::where('validity_id', $request->validity)->where('estate_id', Auth::user()->getEstateIndicatorResponsability->id ?? 0)->with(['getIndicator'])->get();
        return response()->json($estateIndicator);
    }

    public function showControl(Request $request){

        $ids = Estate::select('id')->where('adviser_id',Auth::user()->id)->get()->map(function ($item) {
            return $item->id;
        });
        $estateIndicator = EstateIndicator::where('validity_id', $request->validity)->where('cicly_indicator', 2)->whereIn('estate_id', $ids)->with(['getIndicator', 'getEstate'])->get();
        return response()->json($estateIndicator);
    }

    public function showAdmin(Request $request){
        $estateIndicator = EstateIndicator::where('validity_id', $request->validity)->where('estate_id', $request->estate_id)->with(['getIndicator'])->get();
        return response()->json($estateIndicator);
    }

    public function store(Request $request)
    {
        $request->validate([
            'validity_id' => 'required',
            'estate_id' => 'required',
            'indicator_id' => 'required',
        ]);

    }

}
