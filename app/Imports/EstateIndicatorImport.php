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
            'start_date' => $row['fecha_inicial'],
            'end_date' => $row['fecha_final'],
            'goal' => $row['meta'],
            'execution_goals' => $row['ejecucion'],
            'expected_goal' => $row['esperado'],
            'cicly_indicator' => 1,
            'physical_recursion' => $row['recurso_fisico'],
            'technical_recursion' => $row['recurso_tecnico'],
            'human_resource' => $row['recurso_humano'],
            'responsible_indicator' => $row['responsable_indicador'],
            'post_responsible_indicator' => $row['cargo_responsable'],


        ]);
    }
}
