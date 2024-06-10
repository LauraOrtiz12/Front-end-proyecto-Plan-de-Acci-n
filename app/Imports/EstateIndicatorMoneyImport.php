<?php

namespace App\Imports;

use App\Models\IndicatorMoney;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstateIndicatorMoneyImport implements ToModel, WithHeadingRow
{

    protected $validityId;
    public function __construct($validityId){
        $this->validityId = $validityId;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new IndicatorMoney([
            'validity_id' => $this->validityId->where('validity', $row['vigencia'])->first()->id,
            'estate_id' => $row['dependencia'],
            'siif' => $row['siif'],
            'project_id' => $row['cruce_proyecto'],
            'open_money' => $row['apertura_vigencia'],
            'commitment' => $row['compromiso'],
            'payments' => $row['pagos'],
            'commitment_percentage' => $row['por_ejec_compromiso'],
            'payment_execution' => $row['por_ejec_pagos'],
        ]);
    }
}
