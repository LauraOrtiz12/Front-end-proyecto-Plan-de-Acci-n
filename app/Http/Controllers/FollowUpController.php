<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\EstateIndicator;
use App\Models\EstateIndicatorSave;
use App\Models\FollowClose;
use App\Models\FollowUp;
use App\Models\IndicatorMoney;
use App\Models\IndicatorMoneySave;
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
            "cicle" => $request->cicle,
            "responsible_id" => Auth::user()->id
        ]);
        if ($insert)
            return response()->json(['success' => true, 'id' => $request->id], 201);
        return response()->json(['success' => false], 200);
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            "id" => 'required',
            "observation_control" => 'required',
        ]);
        $insert = FollowUp::where('id', $request->id)->update([
            'observation_control' => $request->observation_control,
            'cicle' => 3,
            'advisor_id' => Auth::user()->id
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
    WHERE validity_id = :validity_id
)
SELECT m.month, c.cycle, COALESCE(f.count, 0) as count, f.status
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
    SELECT COUNT(*) as count, month, cicle as cycle, status
    FROM follow_ups
    WHERE validity_id = :validity_id
    GROUP BY month, cicle, status
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
                'status' => $row->status
            ];

            unset($this->month[array_search($row->month, $this->month)]);

        }
        return response()->json(['follow' => $output, 'months' => $this->month, 'followUpClose' => FollowClose::where('validity_id', $validity_id)->where('status', 'Activo')->get()->count()]);
    }

    public function createFollowUp(Request $request)
    {
        $request->validate([
            'validity_id' => 'required',
            'month' => 'required',
        ]);

        $estate = Estate::all();
        $followClose = FollowClose::create([
            'user_id' => Auth::user()->id,
            'validity_id' => $request->validity_id,
            'month' => $request->month
        ]);
        $data = [];
        $now = now();
        foreach ($estate as $e) {
            $data[] = [
                'validity_id' => $request->validity_id,
                'estate_id' => $e->id,
                'follow_close_id' => $followClose->id,
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

    public function closeFollowUp(Request $request){
        $request->validate([
            'validity_id' =>'required',
            'month' => 'required'
        ]);
        $now = date('Y-m-d H:m:s');
        $close = FollowClose::where('validity_id', $request->validity_id)->where('status', 'Activo')->first();
        $close->status = 'Inactivo';
        $close->save();

        $chunkSize = 1000;
        DB::transaction(function () use ($chunkSize, $request, $close, $now) {
            EstateIndicator::where('validity_id', $request->validity_id)->chunk($chunkSize, function ($estateInd) use ($close, $now) {
                $save = [];
                foreach ($estateInd as $estate) {
                    $save[] = [
                        'validity_id' => $estate->validity_id,
                        'follow_close_id' => $close->id,
                        'estate_id' => $estate->estate_id,
                        'indicator_id' => $estate->indicator_id,
                        'month' => $estate->month,
                        'start_date' => $estate->start_date,
                        'end_date' => $estate->end_date,
                        'goal' => $estate->goal,
                        'execution_goals' => $estate->execution_goals,
                        'cicly_indicator' => $estate->cicly_indicator,
                        'expected_goal' => $estate->expected_goal,
                        'physical_recursion' => $estate->physical_recursion,
                        'technical_recursion' => $estate->technical_recursion,
                        'human_resource' => $estate->human_resource,
                        'responsible_indicator' => $estate->responsible_indicator,
                        'post_responsible_indicator' => $estate->post_responsible_indicator,
                        'status' => $estate->status,
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                }
                EstateIndicatorSave::insert($save);
            });
        });

        DB::transaction(function () use ($chunkSize, $request, $close, $now) {
            IndicatorMoney::where('validity_id', $request->validity_id)->chunk($chunkSize, function ($indicatorMoney) use ($close, $now) {
                $save = [];
                foreach ($indicatorMoney as $money) {
                    $save[] = [
                        'validity_id' => $money->validity_id,
                        'follow_close_id' => $close->id,
                        'estate_id' => $money->estate_id,
                        'siif' => $money->siif,
                        'project_id' => $money->project_id,
                        'open_money' => $money->open_money,
                        'commitment' => $money->commitment,
                        'payments' => $money->payments,
                        'commitment_percentage' => $money->commitment_percentage,
                        'payment_execution' => $money->payment_execution,
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                }
                IndicatorMoneySave::insert($save);
            });
        });
        FollowUp::where('validity_id', $request->validity_id)->where('month', $request->month)->update(['status' => 'Inactivo']);
        return response()->json(['success' => true], 201);

    }
}
