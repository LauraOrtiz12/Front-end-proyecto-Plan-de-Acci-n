<?php

namespace App\Http\Controllers;

use App\Models\AdvisorOffices;
use App\Models\Estate;
use App\Models\IndicatorMoney;
use App\Models\User;
use App\Models\EstateIndicator;
use App\Models\FollowUp;
use App\Models\Validity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ValidityController extends Controller
{
    public function index(){
        $props = [
            'viability' => Validity::all(),
            'followUp' => [],
            'estates' => Estate::where('responsible_id', Auth::user()->id ?? 0)->with(['getAdviser'])->first() ?? [],
            'estatesControl' => Estate::where('adviser_id', Auth::user()->id ?? 0)->get() ?? [],
        ];
        return Inertia::render('Validate/ValidateViability', $props);
    }

    public function indexControl(){
        $props = [
            'user' => User::where('id', Auth::user()->id)->with(['getRole', 'getEstateIndicatorAdviser'])->first(),
            'viability' => Validity::all(),
            'followUp' => FollowUp::where('estate_id', Auth::user()->getEstateIndicatorResponsability->id ?? 0)->get(),
            'estates' => Estate::where('responsible_id', Auth::user()->id ?? 0)->with(['getAdviser'])->first() ?? [],
            'estatesControl' => Estate::where('adviser_id', Auth::user()->id ?? 0)->get() ?? [],
        ];
        return Inertia::render('Validate/ValidateViabilityControl', $props);
    }

    public function getDataAdviser(Request $request){
        $followUps = FollowUp::whereIn('cicle', [2,3])->where('validity_id', $request->validity)->whereIn('estate_id', $request->adviser)->with(['getFollowClose'])->get();
        $estateIndicator = EstateIndicator::where('validity_id', $request->validity)->whereIn('estate_id', $request->adviser)->with(['getIndicator', 'getEstate'])->get();
        $indicatorMoney = IndicatorMoney::where('validity_id', $request->validity)->whereIn('estate_id', $request->adviser)->with(['getProject', 'getEstate'])->get();
        return response()->json(['followups' => $followUps, 'indicator' => $estateIndicator, 'indicatorMoney' => $indicatorMoney]);
    }

    public function getDataAdviserAssesor(Request $request){

        $dependences = AdvisorOffices::where('advisor_id', Auth::user()->id)->get()->map(function($advisor){
            return $advisor->estate_id;
        });
        $followUps = FollowUp::whereIn('cicle', [1,2,3])->where('validity_id', $request->validity)->whereIn('estate_id', $dependences)->with(['getFollowClose', 'getEstateOnly'])->get();
        $estateIndicator = EstateIndicator::where('validity_id', $request->validity)->whereIn('estate_id', $dependences)->with(['getIndicator', 'getEstate'])->get();
        $indicatorMoney = IndicatorMoney::where('validity_id', $request->validity)->whereIn('estate_id', $dependences)->with(['getProject', 'getEstate'])->get();
        return response()->json(['followups' => $followUps, 'indicator' => $estateIndicator, 'indicatorMoney' => $indicatorMoney]);
    }
}
