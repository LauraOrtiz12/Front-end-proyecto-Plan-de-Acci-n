<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\User;
use App\Models\Validity;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;


class EstateController extends Controller
{
    public function index(Request $request)
    {
        $estates = Cache::rememberForever('estates_with_relations', function () {
            return Estate::with(['getAdviser', 'getResponsible'])->get();
        });
        return Inertia::render('Estate/ListEstates', ['estates' => $estates, 'users' => User::all(), 'edit' => $request->edit ?? 0, 'validity' => Validity::all()]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'cod_reg' => 'required',
            'cod_dep' => 'required',
            'dependence' => 'required',
            'responsible_id' => 'required',
            'adviser_id' => 'required',
        ]);
        $id =  (int)$request->id;
        $data = [
            'cod_reg' => $request->cod_reg,
            'cod_dep' => $request->cod_dep,
            'dependence' => $request->dependence,
            'responsible_id' => $request->responsible_id,
            'adviser_id' => $request->adviser_id,
        ];
        Cache::forget('estates_with_relations');
        if($id == 0){
           Estate::insert($data);

        }else{
            Estate::where('id', $request->id)->update($data);
        }
        return to_route('listEstates');
    }
}
