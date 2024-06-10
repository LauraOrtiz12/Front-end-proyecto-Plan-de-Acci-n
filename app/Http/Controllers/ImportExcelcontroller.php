<?php

namespace App\Http\Controllers;

use App\Imports\EstateIndicatorImportGeneric;
use App\Imports\EstateIndicatorMoneyImport;
use App\Models\EstateIndicator;
use App\Models\Validity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelcontroller extends Controller
{
    public function index(Request $request){
        $fileName = time().'_'.$request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
        $fileFullPath = Storage::disk('public')->path($filePath);
        $status = Excel::import(new EstateIndicatorImport($request->estate_id), $fileFullPath);
        if($status){
            return response()->json(['success'=>'File imported successfully.'], 201);
        }
        return response()->json(['error'=>'File not imported.'], 200);
    }

    public function indexGen(Request $request){
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'addornew' => 'required'
        ]);
        $fileName = time().'_gestion_'.$request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
        $fileFullPath = Storage::disk('public')->path($filePath);
        $validityId = collect(Validity::all());
        $state = $request->addornew;
        if($state == 'false')
            EstateIndicator::query()->update(['status' => 'Inactivo']);
        $status = Excel::import(new EstateIndicatorImportGeneric($validityId), $fileFullPath);
        if($status){
            return response()->json(['success'=>'File imported successfully.'], 201);
        }
        return response()->json(['error'=>'File not imported.'], 200);
    }

    public function indexMoney(Request $request){
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'addornew' => 'required'
        ]);
        $fileName = time().'_presupuesto_'.$request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
        $fileFullPath = Storage::disk('public')->path($filePath);
        $validityId = collect(Validity::all());
        //$state = $request->addornew;
        //if($state == 'false')
           // EstateIndicator::query()->update(['status' => 'Inactivo']);
        $status = Excel::import(new EstateIndicatorMoneyImport($validityId), $fileFullPath);
        if($status){
            return response()->json(['success'=>'File imported successfully.'], 201);
        }
        return response()->json(['error'=>'File not imported.'], 200);
    }
}
