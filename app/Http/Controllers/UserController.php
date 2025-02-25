<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;



class UserController extends Controller
{

    public function show(Request $request){
        $role = Role::getAllRole();
        $users = Cache::rememberForever('users_with_relations', function () {
            return User::where('id', '>', 1)
                ->with(['getAdviserOffice.getEstate', 'getRole'])
                ->get();
        });
        $estates = Cache::rememberForever('estates_with_relations', function () {
            return Estate::with(['getAdviser', 'getResponsible'])->get();
        });
        $props = ['role' => $role, 'users' => $users, 'estates' => $estates];
        return Inertia::render('Users/ListUsers', $props);
    }

    public function store(Request $request){
        Validator::make($request->all(), [
            'code' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
            'role_id' => ['required'],
        ])->validate();

        User::create([
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);
        Cache::forget('users_with_relations');
        return Inertia::render('Users/Create', [
            'successMessage' => 'El usuario se ha creado correctamente.'
        ]);
    }

    public function edit(Request $request){
        Validator::make($request->all(), [
            'id' => ['required', 'integer'],
            'code' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role_id' => ['required'],
        ])->validate();

        if($request->password)
            User::whereId($request->id)->update([
                'code' => $request->code,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id
            ]);
        if(!$request->password)
            User::whereId($request->id)->update([
                'code' => $request->code,
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id
            ]);

        Cache::forget('users_with_relations');
        return Inertia::render('Users/Create', [
            'successMessage' => 'El usuario se ha actualizado correctamente.'
        ]);
    }

    public function editStatus(Request $request){
        $request->validate([
            'id' => ['required', 'integer'],
            'status' => ['required', 'string'],
        ]);
        $update = User::where('id', $request->id)->update([
            'status' => $request->status
        ]);
        Cache::forget('users_with_relations');
        if($update)
            return response()->json(['status' => true], 201);
        return response()->json(['status' => false], 200);
    }


}
