<?php

namespace App\Http\Controllers;

use App\Imports\EstateIndicatorImportGeneric;
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
        $fileName = time().'_'.$request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
        $fileFullPath = Storage::disk('public')->path($filePath);
        $validityId = collect(Validity::all());
        $status = Excel::import(new EstateIndicatorImportGeneric($validityId), $fileFullPath);
        if($status){
            return response()->json(['success'=>'File imported successfully.'], 201);
        }
        return response()->json(['error'=>'File not imported.'], 200);
    }
}
