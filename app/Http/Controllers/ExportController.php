<?php

namespace App\Http\Controllers;

use App\Exports\FollowCloseExport;
use App\Models\Estate;
use App\Models\FollowUp;
use App\Models\User;
use App\Models\Validity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EstateIndicatorJustifyExport;

class ExportController extends Controller
{
    public function getExport(Request $request)
    {
        $validity = Validity::all()->keyBy('id');
        $estates = Estate::all()->keyBy('id');
        $followupComplete = FollowUp::where('validity_id', $request->validity)
            ->where('cicle', 3)
            ->with(['getEstateIndicator.getIndicator'])
            ->get()
            ->flatMap(function ($item) use ($validity, $estates) {
                return $item->getEstateIndicator->map(function ($indicator) use ($item, $validity, $estates) {
                    return [
                        'cod_dep' => $indicator->estate_id,
                        'Dependence' => $estates[$indicator->estate_id]->dependence ?? null,
                        'validity' => $validity[$indicator->validity_id]->validity ?? null,
                        'cod_indicator' => $indicator->getIndicator->id,
                        'name_indicator' => $indicator->getIndicator->name_indicator,
                        'perspective' => $indicator->getIndicator->perspective,
                        'name_perspective' => $indicator->getIndicator->name_perspective,
                        'objective_strategy' => $indicator->getIndicator->objective_strategy,
                        'name_strategy' => $indicator->getIndicator->name_strategy,
                        'indicator_strategy' => $indicator->getIndicator->indicator_strategy,
                        'name_indicator_strategy' => $indicator->getIndicator->name_indicator_strategy,
                        'month' => $indicator->month,
                        'goal' => $indicator->goal,
                        'execution_goals' => $indicator->execution_goals,
                        'justify_estate_indicator' => $item->justify_estate_indicator,
                        'justify_estate_money' => $item->justify_estate_money,
                        'observation_control' => $item->observation_control,
                        'assesor' => $item->assesor,
                    ];
                });
            });

        $followupIncomplete = FollowUp::where('validity_id', $request->validity)
            ->whereIn('cicle', [1, 2])
            ->with(['getEstateIndicator.getIndicator'])
            ->get()
            ->flatMap(function ($item) use ($validity, $estates) {
                return $item->getEstateIndicator->map(function ($indicator) use ($item, $validity, $estates) {
                    return [
                        'cod_dep' => $indicator->estate_id,
                        'Dependence' => $estates[$indicator->estate_id]->dependence ?? null,
                        'validity' => $validity[$indicator->validity_id]->validity ?? null,
                        'cod_indicator' => $indicator->getIndicator->id,
                        'name_indicator' => $indicator->getIndicator->name_indicator,
                        'perspective' => $indicator->getIndicator->perspective,
                        'name_perspective' => $indicator->getIndicator->name_perspective,
                        'objective_strategy' => $indicator->getIndicator->objective_strategy,
                        'name_strategy' => $indicator->getIndicator->name_strategy,
                        'indicator_strategy' => $indicator->getIndicator->indicator_strategy,
                        'name_indicator_strategy' => $indicator->getIndicator->name_indicator_strategy,
                        'month' => $indicator->month,
                        'goal' => $indicator->goal,
                        'execution_goals' => $indicator->execution_goals,
                        'justify_estate_indicator' => $item->justify_estate_indicator,
                        'justify_estate_money' => $item->justify_estate_money,
                        'observation_control' => $item->observation_control,
                        'assesor' => $item->assesor,
                    ];
                });
            });
        $props = [
            'followupComplete' => $followupComplete,
            'followupIncomplete' => $followupIncomplete,
            'viability' => Validity::all(),
        ];
        return Inertia::render('Export/PrepareExport', $props);
    }

    public function download(Request $request)
    {
        return Excel::download(new EstateIndicatorJustifyExport($request->validity), 'Seguimiento_Vigencia_.xlsx');
    }

    public function downloadFollowClose(Request $request)
    {
        return Excel::download(new FollowCloseExport($request->validity, $request->month), 'Seguimiento_Vigencia_.xlsx');
    }
}
