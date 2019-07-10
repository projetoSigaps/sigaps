<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_entrada_saida;
use App\Model\Sys\Cad_automovel;

class HorariosController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | VIEWS 
    |--------------------------------------------------------------------------
    | Retorna a página referente a inserir manualmente o horário de entrada e saída
    | HTML disponível em resources/views/sys/configuraçoes/horarios.blade.php
    */
	public function index()
	/* Retorna a tela para registrar horario manualmente */
	{
		$this->authorize('config_horarios', Cad_entrada_saida::class);
		return view('sys.configuracoes.horarios');
	}

	/*
    |--------------------------------------------------------------------------
    | OPERAÇÕES 
    |--------------------------------------------------------------------------
    | Manipula o evento da interface do usuário
	*/

	public function registrar(Request $request)
	/* Registra horário, verificando se é de automovel ou pedestre */
	{


		$dados 	= $request->all();
		$regras = [
			'reg_horario' => 'required',
			'cod_cracha' => 'required',
		];

		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		$gdh_entrada = isset($dados["gdh_entrada"]) ? $dados["gdh_entrada"] : NULL;
		$gdh_saida = isset($dados["gdh_saida"]) ? $dados["gdh_saida"] : NULL;

		if (empty($gdh_entrada) && empty($gdh_saida)) {
			return back()->with('error', 'Digite um horário de entrada ou saída!');
		}

		if (!empty($dados['gdh_entrada'])) {
			$gdh_entrada = date('Y-m-d H:i', strtotime(str_replace('/', '-', $dados['gdh_entrada'])));
			$flag = 1;
		}
		if (!empty($dados['gdh_saida'])) {
			$gdh_saida = date('Y-m-d H:i', strtotime(str_replace('/', '-', $dados['gdh_saida'])));
			$flag = 0;
		}

		switch ($dados['reg_horario']) {

			case 'pedestre':
				$pedestre = Cad_militar::where('id', $dados['cod_cracha'])->exists();

				if (!$pedestre) {
					return back()->with('error', 'Crachá Inexistente!');
				}

				$registra = new Cad_entrada_saida;
				$registra->militar_id = $dados['cod_cracha'];
				$registra->flag = $flag;
				$registra->dtEntrada = $gdh_entrada;
				$registra->dtSaida = $gdh_saida;
				$registra->om_id = Auth::user()->om_id;
				$registra->save();
				return redirect()->route('sys.configuracoes.horarios')->with('success', 'Registro adicionado com sucesso!');
				break;

			case 'automovel':
				$automovel = Cad_automovel::where('id', $dados['cod_cracha'])->exists();

				if (!$automovel) {
					return back()->with('error', 'Crachá Inexistente!');
				}

				$registra = new Cad_entrada_saida;
				$registra->automovel_id = $dados['cod_cracha'];
				$registra->flag = $flag;
				$registra->dtEntrada = $gdh_entrada;
				$registra->dtSaida = $gdh_saida;
				$registra->om_id = Auth::user()->om_id;
				$registra->save();
				return redirect()->route('sys.configuracoes.horarios')->with('success', 'Registro adicionado com sucesso!');
				break;

			default:
				return redirect()->route('sys.configuracoes.horarios')->with('error', 'Selecione um tipo de registro!');
				break;
		}
	}
}
