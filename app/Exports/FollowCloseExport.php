<?php

namespace App\Exports;

use App\Models\Estate;
use App\Models\EstateIndicator;
use App\Models\FollowClose;
use App\Models\FollowUp;
use App\Models\Validity;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FollowCloseExport implements FromView
{
    protected $validity = 0;
    protected $month = "";
    public function __construct($validity, $month){
        $this->validity = $validity;
        $this->month = $month;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $followClose = FollowClose::where('validity_id', $this->validity)->where('month', $this->month)->first();
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
                        'Dependence' => $estates[$indicator->estate_id]->dependence ?? null,
                        'validity' => strval($validity[$indicator->validity_id]->validity ?? ''),
                        'cod_indicator' => $indicator->getIndicator->id,
                        'name_indicator' => $indicator->getIndicator->name_indicator,
                        'month' => $indicator->month,
                        'goal' => $indicator->goal,
                        'execution_goals' => $indicator->execution_goals,
                        'per' => (number_format($indicator->execution_goals/$indicator->goal,2)),
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
