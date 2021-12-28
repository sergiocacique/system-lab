<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('Login/Login');
    }

    public function create()
    {
        return Inertia::render('Login/Register');
    }

    public function register(Request $request)
    {

        Validator::make($request->all(), [
            'name_aluno' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ], [], [
            'name_aluno' => 'nome do aluno'
        ])
            ->validate();


        $user = DB::transaction(function () use ($request) {

            $credentials = $request->except('name_aluno');
            $credentials['password'] = Hash::make($credentials['password']);

            $user = User::create($credentials)->assignRole('aluno');
            $user->aluno()->create([
                'name' => $request['name_aluno']
            ]);

            return [
                'email' => $user->email,
                'password' => $request->password,
            ];
        });

        if (Auth::attempt($user)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard.index');
        }

        return back();
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard.index');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.index');
    }
}
