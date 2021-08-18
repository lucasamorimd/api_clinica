<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->string('nome', 100);
            $table->string('rg', 100);
            $table->date('data_nascimento');
            $table->dateTime('data_cadastro')->useCurrent();
            $table->string('telefone', 100);
            $table->string('email', 100);
            $table->string('endereco', 100);
            $table->string('cep', 100);
            $table->string('cidade', 100);
            $table->string('estado', 100);
            $table->string('login', 100);
            $table->string('senha', 100);
            $table->string('perfil', 100)->default('paciente');
            $table->string('foto', 100)->nullable();
            $table->string('sexo', 100);
            $table->string('token', 200)->nullable();
            $table->tinyInteger('status', 100)->default(0);
        });
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->increments('id_agendamento');
            $table->integer('id_usuario', 100);
            $table->integer('id_unidade', 100);
            $table->integer('id_servico');
            $table->integer('id_medico');
            $table->string('nome_paciente', 100);
            $table->string('email_paciente', 100);
            $table->string('telefone_paciente', 100);
            $table->string('tipo_atendimeto', 100);
            $table->string('nome_atendimento', 100);
            $table->date('data_atendimento');
            $table->time('hora_atendimento');
            $table->dateTime('data_abertura')->useCurrent();
            $table->decimal('preco_servico', $precision = 8, $scale = 2);
            $table->string('situacao', 100)->default('paciente');
            $table->timestamps();
            $table->integer('id_prontuario', 100)->nullable();
        });
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_funcionario', 100);
            $table->string('email', 100);
            $table->string('password', 100);
            $table->integer('id_unidade', 100);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
        Schema::create('galerias', function (Blueprint $table) {
            $table->increments('id_foto');
            $table->integer('id_servico', 100);
            $table->string('nome_foto', 100);
        });
        Schema::create('medicos', function (Blueprint $table) {
            $table->increments('id_medico');
            $table->integer('id_unidade', 100);
            $table->string('crm', 100);
            $table->string('nome_medico', 100);
            $table->string('foto_medico', 100);
            $table->string('area_atuacao', 100);
            $table->datetime('data_cadastro')->useCurrent();
            $table->timestamps();
            $table->integer('is_deleted', 2)->default(0);
        });
        Schema::create('medico_servicos', function (Blueprint $table) {
            $table->increments('id_med_serv');
            $table->integer('id_medico', 100);
            $table->integer('id_servico', 100);
            $table->string('nome_servico', 100);
            $table->integer('is_deleted', 2)->default(0);
        });
        Schema::create('prontuarios', function (Blueprint $table) {
            $table->increments('id_prontuario');
            $table->text('resumo');
            $table->string('nome_arquivo', 200);
            $table->timestamps();
        });
        Schema::create('servicos', function (Blueprint $table) {
            $table->increments('id_servico');
            $table->string('nome_servico', 100);
            $table->string('tipo_servico');
            $table->string('foto_principal', 200);
            $table->string('tempo_estimado', 100);
            $table->decimal('preco_servico', $precision = 8, $scale = 2);
            $table->text('descricao_servico');
            $table->timestamps();
        });
        Schema::create('unidades', function (Blueprint $table) {
            $table->increments('id_unidade');
            $table->string('nome_unidade', 100);
            $table->string('endereco_unidade', 100);
            $table->string('cidade_unidade', 100);
            $table->string('estado_unidade', 100);
            $table->string('telefone_unidade', 100);
            $table->string('cnpj_unidade', 100);
            $table->timestamps();
        });
        Schema::create('unidade_medicos', function (Blueprint $table) {
            $table->increments('id_uni_med');
            $table->integer('id_unidade', 100);
            $table->integer('id_medico', 100);
            $table->integer('id_deleted', 2)->default(0);
        });
        Schema::create('unidade_servicos', function (Blueprint $table) {
            $table->increments('id_us');
            $table->integer('id_unidade', 100);
            $table->integer('id_servico', 100);
            $table->string('nome_servico');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('agendamentos');
        Schema::dropIfExists('funcionarios');
        Schema::dropIfExists('galerias');
        Schema::dropIfExists('medicos');
        Schema::dropIfExists('medicos_servicos');
        Schema::dropIfExists('prontuarios');
        Schema::dropIfExists('servicos');
        Schema::dropIfExists('unidades');
        Schema::dropIfExists('unidade_medicos');
        Schema::dropIfExists('unidade_servicos');
    }
}
