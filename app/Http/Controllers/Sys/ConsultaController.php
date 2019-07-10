<?php

namespace App\Http\Controllers\Sys;

/* Vendors Laravel */

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

/* Models SIGAPS */
use App\Model\Sys\Cad_entrada_saida;

class ConsultaController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | VIEWS 
    |--------------------------------------------------------------------------
    | Retornam as páginas referente aos Horarios de Entrada e Saída 
    | HTML disponível em resources/views/sys/consultas
	*/

	public function pedestres()
	{
		$this->authorize('consultas_ped', Cad_entrada_saida::class);
		return view('sys.consultas.pedestre');
	}

	public function automoveis()
	{
		$this->authorize('consultas_aut', Cad_entrada_saida::class);
		return view('sys.consultas.automoveis');
	}

	/*
    |--------------------------------------------------------------------------
    | OPERAÇÕES 
    |--------------------------------------------------------------------------
    | Faz as consultas dos Horários de entrada e saída dos Militares
    */

	public function consultaPedestres(Request $request)
	/*	Consulta horários de entrada e saida de pedestres (Crachá Indívidual) 
	*	Obs: Os dados vem por Ajax, via DataTables
	*/
	{
		$limit = $request->input('length');
		$start = $request->input('start');
		$horarios = DB::table('cad_entrada_saida')
			->select(
				'cad_militar.nome_guerra',
				'cad_militar.om_id',
				'cad_posto.nome as posto_nome',
				'cad_om.nome as om_nome',
				'cad_entrada_saida.militar_id as cod_cracha',
				'cad_entrada_saida.dtEntrada',
				'cad_entrada_saida.dtSaida'
			)
			->leftJoin(
				'cad_militar',
				'cad_militar.id',
				'=',
				'cad_entrada_saida.militar_id'
			)
			->leftJoin(
				'cad_posto',
				'cad_militar.posto',
				'=',
				'cad_posto.id'
			)
			->leftJoin(
				'cad_om',
				'cad_militar.om_id',
				'=',
				'cad_om.id'
			)
			->where('cad_entrada_saida.militar_id', '!=', NULL);
		if (!Auth::user()->hasRole('super-admin')) {
			$horarios = $horarios->where('cad_militar.om_id', Auth::user()->om_id);
		}

		$totalData = $horarios->count();
		$totalFiltered = $totalData;

		$horarios = $horarios
			->skip($start)
			->take($limit)
			->orderBy('cad_entrada_saida.id', 'desc')
			->get();

		$data = array();
		if (!empty($horarios)) {
			foreach ($horarios as $value) {
				if (!empty($value->dtEntrada)) {
					$value->dtEntrada = date('d/m/Y H:i', strtotime($value->dtEntrada));
				}
				if (!empty($value->dtSaida)) {
					$value->dtSaida = date('d/m/Y H:i', strtotime($value->dtSaida));
				}

				$nestedData['cod_cracha'] = $value->cod_cracha;
				$nestedData['nome_guerra'] = $value->nome_guerra;
				$nestedData['posto_nome'] = $value->posto_nome;
				$nestedData['om_nome'] = $value->om_nome;
				$nestedData['dtEntrada'] = $value->dtEntrada;
				$nestedData['dtSaida'] = $value->dtSaida;
				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"            => intval($request->input('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);
		return response()->json($json_data);
	}

	public function consultaAutomoveis(Request $request)
	/*	Consulta horários de entrada e saida de automoveis (Crachá do Veículo)
	*	Obs: Os dados vem por Ajax, via DataTables
	*/
	{
		$limit = $request->input('length');
		$start = $request->input('start');
		$horarios = DB::table('cad_entrada_saida')
			->select(
				'cad_militar.nome_guerra',
				'cad_posto.nome as posto_nome',
				'cad_om.nome as om_nome',
				'cad_marca.nome as marca',
				'cad_automovel.placa',
				'cad_modelo.nome as modelo',
				'cad_entrada_saida.automovel_id as cod_cracha',
				'cad_entrada_saida.dtEntrada',
				'cad_entrada_saida.dtSaida'
			)
			->leftJoin(
				'cad_automovel',
				'cad_automovel.id',
				'=',
				'cad_entrada_saida.automovel_id'
			)
			->leftJoin(
				'cad_militar',
				'cad_automovel.militar_id',
				'=',
				'cad_militar.id'
			)
			->leftJoin(
				'cad_posto',
				'cad_militar.posto',
				'=',
				'cad_posto.id'
			)
			->leftJoin(
				'cad_om',
				'cad_militar.om_id',
				'=',
				'cad_om.id'
			)
			->leftJoin(
				'cad_modelo',
				'cad_automovel.modelo_id',
				'=',
				'cad_modelo.id'
			)
			->leftJoin(
				'cad_marca',
				'cad_automovel.marca_id',
				'=',
				'cad_marca.id'
			)
			->where('cad_entrada_saida.automovel_id', '!=', NULL);

		if (!Auth::user()->hasRole('super-admin')) {
			$horarios = $horarios->where('cad_militar.om_id', Auth::user()->om_id);
		}

		$totalData = $horarios->count();
		$totalFiltered = $totalData;
		$horarios = $horarios
			->skip($start)
			->take($limit)
			->orderBy('cad_entrada_saida.id', 'desc')
			->get();

		$data = array();
		if (!empty($horarios)) {
			foreach ($horarios as $value) {
				if (!empty($value->dtEntrada)) {
					$value->dtEntrada = date('d/m/Y H:i', strtotime($value->dtEntrada));
				}
				if (!empty($value->dtSaida)) {
					$value->dtSaida = date('d/m/Y H:i', strtotime($value->dtSaida));
				}

				$nestedData['posto_nome'] = $value->posto_nome;
				$nestedData['nome_guerra'] = $value->nome_guerra;
				$nestedData['cod_cracha'] = $value->cod_cracha;
				$nestedData['marca_modelo'] = $value->marca . "/" . $value->modelo;
				$nestedData['placa'] = $value->placa;
				$nestedData['om_nome'] = $value->om_nome;
				$nestedData['dtEntrada'] = $value->dtEntrada;
				$nestedData['dtSaida'] = $value->dtSaida;
				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"            => intval($request->input('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);
		return response()->json($json_data);
	}
}
