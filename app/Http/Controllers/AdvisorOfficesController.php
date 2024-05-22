<?php

namespace App\Http\Controllers;

use App\Models\AdvisorOffices;
use Illuminate\Http\Request;

class AdvisorOfficesController extends Controller
{
    public function store(Request $request){
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
}
