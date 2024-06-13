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

class FollowIndicatorCloseMoney implements FromView
{
    protected $validity = 0;
    protected $month = "";

    public function __construct($validity, $month)
    {
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
            ->with(['getIndicatorMoneyClose.getProject'])
            ->get()
            ->flatMap(function ($item) use ($validity, $estates) {
                return $item->getIndicatorMoneyClose->map(function($indicator) use ($item, $validity, $estates){
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
            });

        $props = [
            'money' => $followupComplete,
            'viability' => Validity::all(),
        ];
        return view('Export.follow-close-export-money', $props);
    }
}
