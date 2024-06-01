<?php

namespace App\Imports;

use App\Models\EstateIndicator;
use App\Models\Validity;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class EstateIndicatorImport implements  ToModel, WithHeadingRow
{
    protected $estateIndicator = 0;
    public function __construct($id)
    {
        $this->estateIndicator = $id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $validityId = Validity::where('validity', $row['vigencia'])->first();
        return new EstateIndicator([
            'validity_id' => $validityId->id,
            'estate_id' => $this->estateIndicator,
            'indicator_id' => $row['codigo_de_indicador'],
            'month' => $row['mes'],
            'goal' => $row['meta'],
            'execution_goals' => $row['ejecucion_de_meta'],
            'cicly_indicator' => 1
        ]);
    }
}
