<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Medico;
use App\Models\Servico;
use App\Models\Unidade;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AgendamentoController extends Controller
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
    public function index($situacao)
    {
        $agendamentos = Agendamento::where('situacao', $situacao)->get()->toArray();
        $this->array['result'][] = [
            'dados' => $agendamentos
        ];
        return $this->array;
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
            'id_usuario' => 'required',
            'id_unidade' => 'required',
            'id_servico' => 'required',
            'id_medico' => 'required',
            'nome_paciente' => 'required',
            'email_paciente' => 'required',
            'telefone_paciente' => 'required',
            'tipo_atendimento' => 'required',
            'nome_atendimento'=>'required',
            'data_atendimento' => 'required',
            'hora_atendimento' => 'required',
            'preco_servico' => 'required'
        ]);
        if (!$validator->fails()) {
            $novo_agendamento = new Agendamento();
            $novo_agendamento->id_usuario = $request->id_usuario;
            $novo_agendamento->id_unidade = $request->id_unidade;
            $novo_agendamento->id_servico = $request->id_servico;
            $novo_agendamento->id_medico = $request->id_medico;
            $novo_agendamento->nome_paciente = $request->nome_paciente;
            $novo_agendamento->email_paciente = $request->email_paciente;
            $novo_agendamento->telefone_paciente = $request->telefone_paciente;
            $novo_agendamento->tipo_atendimento = $request->tipo_atendimento;
            $novo_agendamento->nome_atendimento = $request->nome_atendimento;
            $novo_agendamento->data_atendimento = $request->data_atendimento;
            $novo_agendamento->hora_atendimento = $request->hora_atendimento;
            $novo_agendamento->preco_servico = $request->preco_servico;
            $novo_agendamento->save();
            $this->array['result'][] = [
                'msg' => 'Agendamento realizado'
            ];
        } else {
            foreach ($validator->errors() as $error) {
                $this->array['error'][] = [
                    'msg' => $error
                ];
            }
        }
        return $this->array;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agendamento  $agendamento
     * @return \Illuminate\Http\Response
     */
    public function show(Agendamento $agendamento, $id_agendamento)
    {
        $dados = $agendamento->where('id_agendamento', $id_agendamento)->first();
        $unidade = Unidade::where('id_unidade', $dados->id_unidade)->first();
        $servico = Servico::where('id_servico', $dados->id_servico)->first();
        $medico = Medico::where('id_medico', $dados->id_medico)->first();
        $usuario = Usuario::where('id_usuario', $dados->id_usuario)->first();
        $this->array['result'][] = [
            'agendamento' => $dados,
            'unidade' => $unidade,
            'servico' => $servico,
            'medico' => $medico,
            'usuario' => $usuario
        ];
        return $this->array;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agendamento  $agendamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Agendamento $agendamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agendamento  $agendamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agendamento $agendamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agendamento  $agendamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agendamento $agendamento, $id_agendamento)
    {
        $to_delete = $agendamento->where('id_agendamento', $id_agendamento)->delete();
        $this->array['result'] = 'Agendamento cancelado!';
        return $this->array;
    }
}
