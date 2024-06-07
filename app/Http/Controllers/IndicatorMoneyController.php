<?php

namespace App\Http\Controllers;

use App\Models\IndicatorMoney;
use Illuminate\Http\Request;

class IndicatorMoneyController extends Controller
{
    public function index(Request $request){
        $indicatorMoney = IndicatorMoney::where('estate_id', $request->estate_id)->where('validity_id', $request->validity)->with(['getProject'])->get();
        return response()->json($indicatorMoney);
    }
}
