<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\FollowUp;
use App\Models\Validity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia;

class FollowUpController extends Controller
{

    protected $month = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
    public function show(Request $request)
    {
        return FollowUp::where('validity_id', $request->validity)
            ->where('estate_id', Auth::user()->getEstateIndicatorResponsability->id)
            ->orderBy('id', 'ASC')
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            "estate_indicator_id" => 'required',
            "validity_id" => 'required',
            "cicle" => 'required',
            "justify_estate_indicator" => 'required',
            "justify_estate_money" => 'required'
        ]);
        $insert = FollowUp::where('id', $request->id)->update([
            "justify_estate_indicator" => $request->justify_estate_indicator,
            "justify_estate_money" => $request->justify_estate_money,
            "cicle" => $request->cicle
        ]);
        if($insert)
                return response()->json(['success' => true, 'id' => $request->id], 201);
        return response()->json(['success' => false], 200);
        //return Inertia::share(['success' => 'El formulario se ha enviado correctamente.\n Codigo: ', 'id' => $request->id]);
        return ["dataInsert" => $insert];
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            "id" => 'required',
            "observation_control" => 'required',
        ]);
        $insert = FollowUp::where('id', $request->id)->update([
            'observation_control' => $request->observation_control,
            'cicle' => 3
        ]);
        return Inertia::share('success', 'Se ha actualizado correctamente.\n Codigo: ' . $request->id);

    }

    public function storeUpdateState(Request $request)
    {
        $request->validate([
            "id" => 'required',
            "cicle" => 'required',
        ]);
        $insert = FollowUp::where('id', $request->id)->update([
            'cicle' => $request->cicle,
        ]);
        return Inertia::share('success', 'Se ha actualizado correctamente.\n Codigo: ' . $request->id);
    }



    public function showCreateFollowUp(Request $request)
    {
        $props = [
            'validity' => Validity::all(),
        ];
        return Inertia::render('FollowUp/CreateFollowUp', $props);
    }

    public function consultFollowUp(Request $request)
    {
        $request->validate([
            'validity_id' => 'required'
        ]);
        $validity_id = $request->validity_id;

        $sql = "
    WITH months AS (
        SELECT DISTINCT month
        FROM follow_ups
        WHERE validity_id = :validity_id AND justify_status = 'Activo'
    )
    SELECT m.month, c.cycle, COALESCE(f.count, 0) as count
    FROM
    (
        SELECT 1 as cycle UNION ALL
        SELECT 2 UNION ALL
        SELECT 3
    ) as c
    CROSS JOIN
    months m
    LEFT JOIN
    (
        SELECT COUNT(*) as count, month, cicle as cycle
        FROM follow_ups
        WHERE validity_id = :validity_id AND justify_status = 'Activo'
        GROUP BY month, cicle
    ) as f
    ON m.month = f.month AND c.cycle = f.cycle
";

        $data = DB::select($sql, ['validity_id' => $validity_id]);

        $output = [];
        foreach ($data as $row) {

            $output[$row->month][] = [
                'cicle' => $row->cycle,
                'count' => $row->count,
                'month' => $row->month,
            ];

            unset($this->month[array_search($row->month, $this->month)]);

        }
        return response()->json(['follow' => $output, 'months' => $this->month]);
    }

    public function createFollowUp(Request $request)
    {
        $request->validate([
            'validity_id' => 'required',
            'month' => 'required',
        ]);

        $estate = Estate::all();

        $data = [];
        $now = now();
        foreach ($estate as $e) {
            $data[] = [
                'validity_id' => $request->validity_id,
                'estate_id' => $e->id,
                'cicle' => 1,
                'month' => $request->month,
                "justify_estate_indicator" => '-',
                "justify_estate_money" => '-',
                'responsible_id' => $e->responsible_id,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $follow = FollowUp::insert($data);
        if ($follow)
            return response()->json(["success" => 'Se ha registrado correctamente.'], 201);
        return response()->json(["error" => 'No se ha registrado correctamente.'], 200);
    }
}
