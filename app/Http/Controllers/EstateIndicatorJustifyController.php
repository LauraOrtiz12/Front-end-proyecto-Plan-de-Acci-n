<?php

namespace App\Http\Controllers;

use App\Models\EstateIndicator;
use App\Models\EstateIndicatorJustify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class EstateIndicatorJustifyController extends Controller
{
    public function show(Request $request){
        $params = EstateIndicator::where('id', $request->id)->with(['getIndicator'])->first();
        return Inertia::render('Validate/JustifyIndicator', ['params' => $params, 'dataIndicator' => EstateIndicatorJustify::where('estate_indicator_id', $request->id)->get()]);
    }

    public function store(Request $request){
        $request->validate([
            'estate_indicator_id'=> 'required',
            'observation_goal'=> 'required',
            'justification_goals_budget'=> 'required',
            'initial_date'=> 'required',
            'final_date'=> 'required',
            'physical_resource'=> 'required',
            'technical_resource'=> 'required',
            'human_resource'=> 'required'
        ],[
            'estate_indicator_id'=> 'required',
            'observation_goal.required'=> 'Observación de Meta',
            'justification_goals_budget'=> 'Observación de Meta Propuesta',
            'initial_date'=> 'Fecha Inicial',
            'final_date'=> 'Fecha Final',
            'physical_resource'=> 'Recurso Físico',
            'technical_resource'=> 'Recurso Técnico',
            'human_resource'=> 'Recurso Humano'
        ]);

        $insert = EstateIndicatorJustify::create($request->all());
        if($insert)
            EstateIndicator::whereId($request->estate_indicator_id)->update([
                'cicly_indicator' => 2
            ]);

        return to_route('justifyIndicator', ['']);

    }
}
