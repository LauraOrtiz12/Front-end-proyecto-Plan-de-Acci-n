<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndicatorController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Pa/ListIndicators', ['indicators' => Indicator::all()]);
    }
}
