<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\Validity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ValidityController extends Controller
{
    public function index(){
        $props = [
            'viability' => Validity::all(),
            'estates' => Estate::where('responsible_id', Auth::user()->id)->with(['getAdviser'])->first()
        ];
        return Inertia::render('Validate/ValidateViability', $props);
    }
}
