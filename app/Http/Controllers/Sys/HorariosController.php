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
	public function index()
	{
		$this->authorize('config_horarios', Cad_entrada_saida::class);
		return view('sys.configuracoes.horarios');
	}

	public function registrar(Request $request)
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
