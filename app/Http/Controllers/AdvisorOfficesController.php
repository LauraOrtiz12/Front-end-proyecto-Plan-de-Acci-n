<?php

namespace App\Http\Controllers;

use App\Models\AdvisorOffices;
use App\Models\FollowUp;
use App\Models\Validity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdvisorOfficesController extends Controller
{
    public function index()
    {
        $props = [
            'validity' => Validity::all()
        ];
        return Inertia::render('AdvisorOffices/AdvisorOffices', $props);
    }

    public function getAdvisorOffices(Request $request)
    {
        $advisorOffices = AdvisorOffices::where('advisor_id', Auth::user()->id)->get();

    }

    public function updateAdvisorOfficesAssesor(Request $request)
    {
        $request->validate([
            'observation_control' => 'required',
            'id' => 'required',
        ]);
        FollowUp::where('id', $request->id)->update([
            'assesor' => $request->observation_control
        ]);
        return response(['success' => true, 'id' => $request->id], 201);
    }

    public function store(Request $request)
    {
        $request->validate([
            'advisor_id' => 'required',
            'estate_id' => 'required'
        ]);
        $data = [];

        foreach ($request->estate_id as $value)
            $data[] = [
                'advisor_id' => $request->advisor_id,
                'estate_id' => $value
            ];
        return AdvisorOffices::insert($data);
    }

    public function deleteAdvisorOffices(Request $request){
        $request->validate([
            'id' => 'required',
        ]);
        AdvisorOffices::whereId($request->id)->delete();
        return response(['success' => true], 200);
    }
}
