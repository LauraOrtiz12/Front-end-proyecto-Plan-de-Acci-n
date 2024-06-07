<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\Indicator;
use App\Models\IndicatorMoney;
use App\Models\Project;
use App\Models\Validity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndicatorController extends Controller
{
    public function getAll()
    {
        return response()->json(Indicator::where('status', 'Activo')->get());
    }
    public function index(Request $request)
    {
        $indicatorsMoney = IndicatorMoney::get();
        $projects = collect(Project::get())->unique('code');
        $allMoney = [];

        foreach ($indicatorsMoney as $indicatorM) {
            $allMoney[] = [
                'id' => $indicatorM->id,
                'siif' => $indicatorM->siif,
                'project_id' => $indicatorM->project_id,
               'project' => $projects->where('code', $indicatorM->project_id)->first()->project,
            ];
        }
        return Inertia::render('Pa/ListIndicators', ['indicators' => Indicator::all(), 'indicatorMoney' => $allMoney]);
    }

    public function viewAll(Request $request)
    {
        $estate = Estate::where('id', $request->id)->first();
        return Inertia::render('Pa/ListIndicatorsAssoc', ['indicators' => Indicator::all(), 'viability' => Validity::all(), 'estate' => $estate]);
    }
}
