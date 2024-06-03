<?php

namespace App\Imports;

use App\Models\EstateIndicator;
use App\Models\Validity;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class EstateIndicatorImportGeneric implements  ToModel, WithHeadingRow
{
    protected $estateIndicator = 0;
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
        return new EstateIndicator([
            'validity_id' => $this->validityId->where('validity', $row['vigencia'])->first()->id,
            'estate_id' => $row['dependencia'],
            'indicator_id' => $row['codigo_de_indicador'],
            'month' => $row['mes'],
            'goal' => $row['meta'],
            'execution_goals' => $row['ejecucion_de_meta'],
            'cicly_indicator' => 1
        ]);
    }
}
