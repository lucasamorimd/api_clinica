<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'login',
            'unauthorized'
        ]]);
    }
    private $array = [
        'error' => '',
        'result' => []
    ];
    public function unauthorized()
    {
        return response()->json(['error' => 'Não autorizado', 401]);
    }
    public function login(Request $request)
    {
        $email = $request->email;
        $senha = $request->senha;
        $token = Auth::attempt([
            'email' => $email,
            'password' => $senha
        ]);
        if (!$token) {
            $this->array['error'] = 'E-mail e/ou senha invalidos';
            return $this->array;
        }
        $this->array['token'] = $token;
        return $this->array;
    }
    public function logout()
    {
        Auth::logout();
        $this->array['result'][] = [
            'msg' => 'Logout realizado'
        ];
        return $this->array;
    }
    public function refresh()
    {
        $token = Auth::refresh();
        $this->array['token'] = $token;
        return $this->array;
    }
}
