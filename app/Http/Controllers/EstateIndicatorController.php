<?php

namespace App\Http\Controllers;

use App\Models\EstateIndicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstateIndicatorController extends Controller
{
    public function show(Request $request){
        $estateIndicator = EstateIndicator::where('validity_id', $request->validity)->where('estate_id', Auth::user()->getEstateIndicatorResponsability->id)->with(['getIndicator'])->get();
        return response()->json($estateIndicator);
    }
}
