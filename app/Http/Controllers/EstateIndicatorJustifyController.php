<?php

namespace App\Http\Controllers;

use App\Models\EstateIndicator;
use App\Models\EstateIndicatorJustify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EstateIndicatorJustifyController extends Controller
{
    public function show(Request $request){
        $params = EstateIndicator::where('id', $request->id)->with(['getIndicator'])->first();
        return Inertia::render('Validate/JustifyIndicator', ['params' => $params, 'dataIndicator' => EstateIndicatorJustify::where('estate_indicator_id', $request->id)->get()]);
    }

    public function store(Request $request){

    }
}
