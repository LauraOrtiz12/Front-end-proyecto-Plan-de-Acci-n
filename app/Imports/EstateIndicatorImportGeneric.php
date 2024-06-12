<?php

namespace App\Imports;

use App\Models\EstateIndicator;
use App\Models\Validity;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

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
        $validityId = Validity::where('validity', $row['vigencia'])->first();
        return new EstateIndicator([
            'validity_id' => $validityId->id,
            'estate_id' =>  $row['dependencia'],
            'indicator_id' => $row['codigo_de_indicador'],
            'month' => $row['mes'],
            'start_date' => Carbon::createFromTimestamp(($row['fecha_inicial'] - 25569) * 86400)->format('Y-m-d') ?? '',
            'end_date' => Carbon::createFromTimestamp(($row['fecha_final'] - 25569) * 86400)->format('Y-m-d') ?? '',
            'goal' => $row['meta'],
            'execution_goals' => $row['ejecucion'] ?? 0,
            'expected_goal' => $row['esperado'] ?? 0,
            'cicly_indicator' => 1,
            'physical_recursion' => $row['recurso_fisico'],
            'technical_recursion' => $row['recurso_tecnico'],
            'human_resource' => $row['recurso_humano'],
            'responsible_indicator' => $row['responsable_indicador'],
            'post_responsible_indicator' => $row['cargo_responsable'],
        ]);
    }
}
