<?php

namespace App\Http\Controllers;

use App\Exports\FollowCloseExport;
use App\Exports\FollowIndicatorCloseMoney;
use App\Exports\FollowIndicatorsDep;
use App\Exports\FollowOpen;
use App\Models\Estate;
use App\Models\FollowClose;
use App\Models\FollowUp;
use App\Models\IndicatorMoney;
use App\Models\IndicatorMoneySave;
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
        return Excel::download(new FollowCloseExport($request->validity, $request->month), time() . '_Seguimiento_Vigencia_Gestion.xlsx');
    }

    public function downloadFollowCloseMoney(Request $request)
    {
        return Excel::download(new FollowIndicatorCloseMoney($request->validity, $request->month), time() . '_Seguimiento_Vigencia_presupuesto.xlsx');
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

    public function viewDownloadFollowDep(Request $request){
        //0 Open / 1 Close
        $r = $request->relation;
        $relation = $request->relation == 0 ? 'getEstateIndicator.getIndicator' : 'getEstateIndicatorClose.getIndicator';
        $relationMoney = $request->relation == 0 ? 'getIndicatorMoney.getProject' : 'getIndicatorMoneyClose.getProject';
        $validity = Validity::all()->keyBy('id');
        $estates = Estate::with(['getAdviser'])->get()->keyBy('id');
        $followupComplete = FollowUp::where('id', $request->id)
            ->with([$relation, $relationMoney])
            ->get()
            ->flatMap(function($item) use ($validity, $estates, $r) {
                $relationModel = match ($r){
                    '0' => $item->getEstateIndicator,
                    '1' => $item->getEstateIndicatorClose,
                };

                $out[0] = $relationModel->map(function($indicator) use ($item, $validity, $estates) {
                    return [
                        'cod_reg' => $estates[$indicator->estate_id]->cod_reg ?? null,
                        'cod_control' => $estates[$indicator->estate_id]->control ?? null,
                        'cod_dep' => $indicator->estate_id,
                        'Dependence' => " ".$estates[$indicator->estate_id]->dependence ?? null,
                        'validity' =>  $validity[$item->validity_id]->validity ?? null,
                        'cod_indicator' => $indicator->getIndicator->id,
                        'name_indicator' => $indicator->getIndicator->name_indicator,
                        'month' => $indicator->month,
                        'goal' => $indicator->goal,
                        'execution_goals' => $indicator->execution_goals,
                        'per' => ($indicator->execution_goals != 0 && $indicator->goal != 0) ? (string)(number_format($indicator->execution_goals/$indicator->goal,2)) : "0",
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
                $relationModelMoney = match ($r){
                    '0' => $item->getIndicatorMoney,
                    '1' => $item->getIndicatorMoneyClose,
                };
                $out[1] = $relationModelMoney->map(function($indicator) use ($item, $validity, $estates){
                    return [
                        'cod_reg' => $estates[$indicator->estate_id]->cod_reg ?? null,
                        'cod_control' => $estates[$indicator->estate_id]->control ?? null,
                        'cod_dep' => $indicator->estate_id,
                        'dependence' => " ".$estates[$indicator->estate_id]->dependence ?? null,
                        'validity' =>  $validity[$item->validity_id]->validity ?? null,
                        'siif' => $indicator->siif,
                        'project_id' => $indicator->project_id,
                        'project' => $indicator->getProject->project,
                        'open_money' => $indicator->open_money,
                        'commitment' => $indicator->commitment,
                        'payments' => $indicator->payments,
                        'commitment_percentage' => $indicator->commitment_percentage,
                        'payment_execution' => $indicator->payment_execution,
                    ];
                });
                return $out;
            });
        //dd($followupComplete[1]);
        $props = [
            'followupComplete' => $followupComplete[0],
            'money' => $followupComplete[1],
            'viability' => Validity::all(),
        ];
        return view('Export.follow-close-export-two', $props);
    }

    public function downloadFollowDep(Request $request){
        return Excel::download(new FollowIndicatorsDep($request), 'Seguimiento_Vigencia_dependencia.xlsx');
    }

    public function viewReportOpen(Request $request){
        $close = FollowClose::where('validity_id', $request->validity)->where('month', $request->month)->first();
        $props = [ 'follow' => FollowUp::where('follow_close_id', $close->id)->with(['getEstateOnly.getResponsible', 'getEstateOnly.getAdviser'])->get()];
        return view('Export.follow-open', compact('props'));
    }

    public function downloadReportOpen(Request $request){
        return Excel::download(new FollowOpen($request->validity, $request->month), time() .'Seguimiento_Vigencia_dependencia_proceso.xlsx');
    }
}
