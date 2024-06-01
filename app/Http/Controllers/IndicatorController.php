<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\Indicator;
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
        return Inertia::render('Pa/ListIndicators', ['indicators' => Indicator::all()]);
    }

    public function viewAll(Request $request)
    {
        $estate = Estate::where('id', $request->id)->first();
        return Inertia::render('Pa/ListIndicatorsAssoc', ['indicators' => Indicator::all(), 'viability' => Validity::all(), 'estate' => $estate]);
    }
}
