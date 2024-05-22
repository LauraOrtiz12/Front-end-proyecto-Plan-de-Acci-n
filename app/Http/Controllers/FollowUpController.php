<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowUpController extends Controller
{
    public function show(Request $request){
        return FollowUp::where('validity_id', $request->validity)->where('estate_id', Auth::user()->getEstateIndicatorResponsability->id)->orWhere('estate_id', Auth::user()->getEstateIndicatorAdviser->id)->get();
    }
}
