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

class FollowOpen implements FromView
{

    protected $validity, $month;

    public function __construct($validity, $month){
        $this->validity = $validity;
        $this->month = $month;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $close = FollowClose::where('validity_id', $this->validity)->where('month', $this->month)->first();
        $props = [ 'follow' => FollowUp::where('follow_close_id', $close->id)->with(['getEstateOnly.getResponsible', 'getEstateOnly.getAdviser'])->get()];
        return view('Export.follow-open', compact('props'));
    }
}
