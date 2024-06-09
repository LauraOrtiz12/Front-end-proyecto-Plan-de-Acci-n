<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request)
    {
        if(strpos($request->email, '@')){
            $credentials = $request->only('email', 'password');
        }else{
            $credentials = [
                'email' => User::whereCode($request->email)->first()->email ?? 'local',
                'password' => $request->password,
            ];
        }



        if (Auth::attempt($credentials)) {
            if(Auth::user()->status != 'Activo')
                return redirect()->intended('/');
            $request->session()->regenerate();

            // Cargar la relación personalizada
            $user = Auth::user()->load('getEstateIndicatorAdviser', 'getEstateIndicatorResponsability');

            return redirect()->intended('dashboard')->with([
                'user' => $user,
                'estateIndicatorsAdviser' => $user->getEstateIndicatorAdviser,
                'estateIndicatorsResponsability' => $user->getEstateIndicatorResponsability
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
