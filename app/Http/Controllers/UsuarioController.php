<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'store'
        ]]);
    }

    private $array = [
        'error' => '',
        'result' => []
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'rg' => 'required',
            'data_nascimento' => 'required',
            'telefone' => 'required',
            'email' => 'required|email',
            'endereco' => 'required',
            'cep' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'login' => 'required',
            'senha' => 'required',
            'sexo' => 'required',
        ]);

        if (!$validator->fails()) {
            $emailExists = Usuario::where('email', $request->email)->count();
            if ($emailExists === 0) {
                $hash = password_hash($request->senha, PASSWORD_DEFAULT);
                $novo_usuario = new Usuario();
                $novo_usuario->nome = $request->nome;
                $novo_usuario->rg = $request->rg;
                $novo_usuario->data_nascimento = $request->data_nascimento;
                $novo_usuario->telefone = $request->telefone;
                $novo_usuario->email = $request->email;
                $novo_usuario->endereco = $request->endereco;
                $novo_usuario->cep = $request->cep;
                $novo_usuario->cidade = $request->cidade;
                $novo_usuario->estado = $request->estado;
                $novo_usuario->login = $request->login;
                $novo_usuario->senha = $hash;
                $novo_usuario->password = $hash;
                $novo_usuario->sexo = $request->sexo;
                $novo_usuario->status = 1;
                $novo_usuario->save();
                $token = Auth::attempt([
                    'email' => $request->email,
                    'password' => $request->senha
                ]);
                if (!$token) {
                    $this->array['error'] = 'Ocorreu algum erro!';
                    return $this->array;
                }

                $this->array['token'] = $token;
            } else {
                $this->array['error'] = 'E-mail já cadastrado';
                return $this->array;
            }
        } else {
            $this->array['error'] = 'Algum Campo foi digitado errado';
            foreach ($validator->errors()->all() as $erro) {
                $this->array['error_validate'][] = [
                    'erro' => $erro
                ];
            }
            return $this->array;
        }
        return $this->array;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
