<?php

namespace App\Exports;

use App\Models\Estate;
use App\Models\EstateIndicator;
use App\Models\FollowUp;
use App\Models\Validity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EstateIndicatorJustifyExport implements FromView
{
    protected $validity = 0;
    public function __construct($validity){
        $this->validity = $validity;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $validity = Validity::all()->keyBy('id');
        $estates = Estate::all()->keyBy('id');
        $followupComplete = FollowUp::where('validity_id', $this->validity)
            ->where('cicle', 3)
            ->with(['getEstateIndicator.getIndicator'])
            ->get()
            ->flatMap(function($item) use ($validity, $estates) {
                return $item->getEstateIndicator->map(function($indicator) use ($item, $validity, $estates) {
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

        $followupIncomplete = FollowUp::where('validity_id', $this->validity)
            ->whereIn('cicle', [1,2])
            ->with(['getEstateIndicator.getIndicator'])
            ->get()
            ->flatMap(function($item) use ($validity, $estates) {
                return $item->getEstateIndicator->map(function($indicator) use ($item, $validity, $estates) {
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

        $followOutIndicators = FollowUp::where('validity_id', $this->validity)
            ->whereIn('cicle', [1,2])
            ->get()->map(function($indicator) use ($validity, $estates) {
                return [
                    'cod_dep' => $indicator->estate_id,
                    'Dependence' => $estates[$indicator->estate_id]->dependence ?? null,
                    'validity' => $validity[$indicator->validity_id]->validity ?? null,
                    'justify_estate_indicator' => $indicator->justify_estate_indicator,
                    'justify_estate_money' => $indicator->justify_estate_money,
                    'observation_control' => $indicator->observation_control,
                    'assesor' => $indicator->assesor,
                ];


            });

        $props = [
            'followupComplete' => $followupComplete,
            'followupIncomplete' => $followupIncomplete,
            'followOutIndicators' => $followOutIndicators,
            'viability' => Validity::all(),
        ];

        return view('Export.EstateIndicatorJustify', $props);
    }
}
