<?php

namespace App\Exports;

use App\Models\Estate;
use App\Models\EstateIndicator;
use App\Models\FollowClose;
use App\Models\FollowUp;
use App\Models\IndicatorMoney;
use App\Models\IndicatorMoneySave;
use App\Models\Validity;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FollowIndicatorsDep implements FromView
{
    protected $request;

    public function __construct($request){
        $this->request = $request;
    }
    public function view(): View
    {
        //0 Open / 1 Close
        $r = $this->request->relation;
        $relation = $r === '0' ? 'getEstateIndicator.getIndicator' : 'getEstateIndicatorClose.getIndicator';
        $relationMoney = $r === '0' ? 'getIndicatorMoney.getProject' : 'getIndicatorMoneyClose.getProject';
        $validity = Validity::all()->keyBy('id');
        $estates = Estate::with(['getAdviser'])->get()->keyBy('id');
        $followupComplete = FollowUp::where('id', $this->request->id)
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
                        'area' => $indicator->getIndicator->area
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
        $props = [
            'followupComplete' => $followupComplete[0],
            'money' => $followupComplete[1],
            'viability' => Validity::all(),
        ];
        return view('Export.follow-close-export-two', $props);
    }
}
