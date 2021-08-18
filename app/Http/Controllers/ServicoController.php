<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Unidade;
use App\Models\Unidade_servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicoController extends Controller
{
    private $loggedUser;
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->loggedUser = Auth::user();
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
    public function index($id_unidade, $servico)
    {
        $id_servicos = Unidade_servico::where('id_unidade', $id_unidade)->where('nome_servico', $servico)->select('id_servico')->get()->toArray();
        $servicos = Servico::whereIn('id_servico', $id_servicos)->get()->toArray();
        foreach ($servicos as $servico) {
            $this->array['result'][] = [
                'id' => $servico['id_servico'],
                'nome' => $servico['nome_servico'],
                'tipo' => $servico['tipo_servico'],
                'nome_foto' => $servico['foto_principal'],
                'duracao' => $servico['tempo_estimado'],
                'preco' => $servico['preco_servico'],
                'descricao' => $servico['descricao_servico']

            ];
        }
        return $this->array;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tipo_servico, $id_servico, $id_unidade)
    {
        $servico = Servico::where('id_servico', $id_servico)->get();
        $unidade = Unidade::where('id_unidade', $id_unidade)->get();
        $this->array['result'][] = [
            'servico' => $servico,
            'unidade' => $unidade,
            'tipo_servico' => $tipo_servico,
            'usuario' => $this->loggedUser
        ];
        return $this->array;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servico  $servico
     * @return \Illuminate\Http\Response
     */
    public function show(Servico $servico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servico  $servico
     * @return \Illuminate\Http\Response
     */
    public function edit(Servico $servico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servico  $servico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Servico $servico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servico  $servico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servico $servico)
    {
        //
    }
}
