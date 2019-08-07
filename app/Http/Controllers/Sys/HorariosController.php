<?php

namespace App\Http\Controllers\Sys;

use Request;
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

	public function registrar()
	/* Registra horário, verificando se é de automovel ou pedestre */
	{


		$dados 	= Request::all();
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

	public function registrarCracha()
	/* Registra horário, verificando se é de automovel ou pedestre */
	{
		$token = parse_url(Request::fullUrl(), PHP_URL_QUERY); // PEGA APENAS O TOKEN DA URL
		$token = substr(strrchr($token, "-"), 1);
		$token = preg_replace("/[^0-9]/", "", $token);

		if (!ctype_digit($token) && (int) $token <= 0) {
			echo "<p style='text-align:center;font-weight:bold;font-size:90px;margin-top:10%;background-color:red;color:white;'>TOKEN INVÁLIDO!</p>";
			die();
		}

		$tipo = explode("/", parse_url(Request::fullUrl(), PHP_URL_PATH));

		$data = date("Y-m-d H:i:s");


		switch ($tipo[2]) {
			case 'RegEntradaMil.php':
				$militar = Cad_militar::select('cad_om.nome as om_nome', 'cad_posto.nome as posto_nome', 'cad_militar.*')
					->join(
						'cad_posto',
						'cad_militar.posto',
						'=',
						'cad_posto.id'
					)
					->join(
						'cad_om',
						'cad_militar.om_id',
						'=',
						'cad_om.id'
					)
					->where(
						'cad_militar.id',
						$token
					)
					->first();

				if (!$militar) {
					echo "<p style='text-align:center;font-weight:bold;font-size:90px;margin-top:10%;background-color:red;color:white;'>NÃO ENCONTRADO!</p>";
					die();
				}
				if (!$militar->status) {
					echo "<p style='text-align:center;font-weight:bold;font-size:90px;margin-top:10%;background-color:red;color:white;'>CRACHÁ DESATIVADO!</p>";
					die();
				}

				$horario = Cad_entrada_saida::where('militar_id', $token)->orderBy('id', 'desc')->first();

				if (!empty($horario)) {
					switch ($horario->flag) {
						case 1:
							Cad_entrada_saida::where('id', $horario->id)->update(['dtSaida' => $data, 'flag' => 0]);
							$status = "exit.png";
							break;
						case 0:
							$registra = new Cad_entrada_saida;
							$registra->militar_id = $token;
							$registra->flag = 1;
							$registra->dtEntrada = $data;
							$registra->om_id = 14;
							$registra->save();
							$status = "enter.png";
							break;
						default:
							echo "<p style='text-align:center;font-weight:bold;font-size:90px;margin-top:10%;background-color:red;color:white;'>TENTE NOVAMENTE!</p>";
							die();
							break;
					}
				} else {
					$registra = new Cad_entrada_saida;
					$registra->militar_id = $token;
					$registra->flag = 1;
					$registra->dtEntrada = $data;
					$registra->om_id = 14;
					$registra->save();
					$status = "enter.png";
				}
				return view('layouts.pedestre', compact('militar', 'status'));
				break;

			case 'RegEntradaAuto.php':
				$automovel = Cad_automovel::select('cad_om.nome as om_nome', 'cad_posto.nome as posto_nome', 'cad_militar.*', 'cad_marca.nome as marca', 'cad_modelo.nome as modelo', 'cad_automovel.*')
					->join('cad_militar', 'cad_militar.id', '=', 'cad_automovel.militar_id')
					->join('cad_modelo', 'cad_modelo.id', '=', 'cad_automovel.modelo_id')
					->join('cad_marca', 'cad_marca.id', '=', 'cad_automovel.marca_id')
					->join('cad_om', 'cad_om.id', '=', 'cad_militar.om_id')
					->join('cad_posto', 'cad_posto.id', '=', 'cad_militar.posto')
					->where('cad_automovel.id', $token)
					->first();

				if (!$automovel) {
					echo "<p style='text-align:center;font-weight:bold;font-size:90px;margin-top:10%;background-color:red;color:white;'>NÃO ENCONTRADO!</p>";
					die();
				}
				if (!$automovel->baixa) {
					echo "<p style='text-align:center;font-weight:bold;font-size:90px;margin-top:10%;background-color:red;color:white;'>CRACHÁ DESATIVADO!</p>";
					die();
				}

				$horario = Cad_entrada_saida::where('automovel_id', $token)->orderBy('id', 'desc')->first();

				if (!empty($horario)) {
					switch ($horario->flag) {
						case 1:
							Cad_entrada_saida::where('id', $horario->id)->update(['dtSaida' => $data, 'flag' => 0]);
							$status = "exit.png";
							break;
						case 0:
							$registra = new Cad_entrada_saida;
							$registra->automovel_id = $token;
							$registra->flag = 1;
							$registra->dtEntrada = $data;
							$registra->om_id = 14;
							$registra->save();
							$status = "enter.png";
							break;
						default:
							echo "<p style='text-align:center;font-weight:bold;font-size:90px;margin-top:10%;background-color:red;color:white;'>TENTE NOVAMENTE!</p>";
							die();
							break;
					}
				} else {
					$registra = new Cad_entrada_saida;
					$registra->automovel_id = $token;
					$registra->flag = 1;
					$registra->dtEntrada = $data;
					$registra->om_id = 14;
					$registra->save();
					$status = "enter.png";
				}
				return view('layouts.automoveis', compact('automovel', 'status'));
				break;

			default:
				echo "<p style='text-align:center;font-weight:bold;font-size:90px;margin-top:10%;background-color:red;color:white;'>ERRO NA OPERAÇÂO!</p>";
				die();
				break;
		}
	}
}
