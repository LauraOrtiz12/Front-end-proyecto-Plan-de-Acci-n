<?php

namespace App\Http\Controllers;

use App\Exports\FollowCloseExport;
use App\Models\Estate;
use App\Models\FollowClose;
use App\Models\FollowUp;
use App\Models\User;
use App\Models\Validity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EstateIndicatorJustifyExport;

class ExportController extends Controller
{
    public function getExport(Request $request)
    {
        $validity = Validity::where('id', $request->validity)->first();
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
                        'validity' => $validity->validity,
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

    public function viewData(Request $request){
        $followClose = FollowClose::where('validity_id', 2)->where('month', 'Marzo')->first();
        $validity = Validity::all()->keyBy('id');
        $estates = Estate::with(['getAdviser'])->get()->keyBy('id');
        $followupComplete = FollowUp::where('validity_id', 2)
            ->where('follow_close_id', $followClose->id)
            ->with(['getEstateIndicatorClose.getIndicator'])
            ->get()
            ->flatMap(function($item) use ($validity, $estates) {
                return $item->getEstateIndicator->map(function($indicator) use ($item, $validity, $estates) {
                    return [
                        'cod_reg' => $estates[$indicator->estate_id]->cod_reg ?? null,
                        'cod_control' => $estates[$indicator->estate_id]->control ?? null,
                        'cod_dep' => $indicator->estate_id,
                        'Dependence' => " ".$estates[$indicator->estate_id]->dependence ?? null,
                        'validity' => settype($validity[$indicator->validity_id]->validity, "string"),
                        'cod_indicator' => $indicator->getIndicator->id,
                        'name_indicator' => $indicator->getIndicator->name_indicator,
                        'month' => $indicator->month,
                        'goal' => $indicator->goal,
                        'execution_goals' => $indicator->execution_goals,
                        'per' => (string)(number_format($indicator->execution_goals/$indicator->goal,2)),
                        'expected_goal' => $indicator->expected_goal,
                        'perspective' => $indicator->getIndicator->perspective,
                        'name_perspective' => $indicator->getIndicator->name_perspective,
                        'start_date' => Carbon::parse($indicator->start_date)->format('Y-m-d'),
                        'end_date' => Carbon::parse($indicator->end_date)->format('Y-m-d'),
                        'physical_recursion' => $indicator->physical_recursion,
                        'technical_recursion' => $indicator->technical_recursion,
                        'human_resource' => $indicator->human_resource,
                        'responsible_indicator' => $indicator->responsible_indicator,
                        'post_responsible_indicator' => $indicator->post_responsible_indicator,
                        'objective_strategy' => $indicator->getIndicator->objective_strategy,
                        'name_strategy' => $indicator->getIndicator->indicator_strategy,
                        'indicator_strategy' => $indicator->getIndicator->indicator_strategy,
                        'name_indicator_strategy' => $indicator->getIndicator->name_indicator_strategy,
                        'month' => $indicator->month,
                        'justify_estate_indicator' => $item->justify_estate_indicator,
                        'justify_estate_money' => $item->justify_estate_money,
                        'observation_control' => $item->observation_control,
                        'assesor' => $item->assesor,
                    ];
                });
            });




        $props = [
            'followupComplete' => $followupComplete,
            'viability' => Validity::all(),
        ];

        return view('Export.follow-close-export', $props);
    }
}
