<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\FollowUp;
use App\Models\User;
use App\Models\Validity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExportController extends Controller
{
    public function getExport(){
        $props = [
            'viability' => Validity::all(),
        ];
        return Inertia::render('Export/PrepareExport', $props);
    }
}
