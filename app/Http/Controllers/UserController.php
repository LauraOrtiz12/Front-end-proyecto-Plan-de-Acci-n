<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function store(Request $request){
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
            'role_id' => ['required'],
        ])->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return Inertia::render('Users/Create', [
            'successMessage' => 'El usuario se ha creado correctamente.'
        ]);
    }

    public function show(Request $request){
        $role = Role::all();
        $users = User::where('id', '>',  1)->get();
        $props = ['role' => $role, 'users' => $users];
        return Inertia::render('Users/ListUsers', $props);
    }
}
