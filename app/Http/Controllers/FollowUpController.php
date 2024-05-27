<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FollowUpController extends Controller
{
    public function show(Request $request){
        return FollowUp::where('validity_id', $request->validity)->where('estate_id', Auth::user()->getEstateIndicatorResponsability->id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            "estate_indicator_id" => 'required',
            "validity_id" => 'required',
            "cicle" => 'required',
            "justify_estate_indicator" => 'required',
            "justify_estate_money" => 'required'
        ]);
        $insert = FollowUp::create([
            "estate_id" => $request->estate_indicator_id,
            "validity_id" => $request->validity_id,
            "cicle" => $request->cicle,
            "justify_estate_indicator" => $request->justify_estate_indicator,
            "justify_estate_money" => $request->justify_estate_money,
            "responsible_id" => Auth::user()->id,
        ]);
        return Inertia::share('success', 'El formulario se ha enviado correctamente.\n Codigo: ' . $insert->id);
        return  ["dataInsert" => $insert];
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            "id" => 'required',
            "observation_control" => 'required',
        ]);
        $insert = FollowUp::where('id', $request->id)->update([
            'observation_control' => $request->observation_control,
            'cicle' => 3
        ]);
        return Inertia::share('success', 'Se ha actualizado correctamente.\n Codigo: ' . $request->id);

    }
}
