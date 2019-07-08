<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_viaturas;
use Illuminate\Support\Facades\Auth;
use App\Model\Sys\Cad_logs;
use DB;

class CrachaController extends Controller
{

	public function trocarCrachaIndex()
	{
		return view('sys.configuracoes.trocarCracha');
	}

	public function trocarCracha(Request $request)
	{
		$item = new Cad_militar;
		$nameTB = $item->getTable();
		$nameDB = DB::connection()->getDatabaseName();

		$crtl = Cad_militar::where('ident_militar', '=', $request->ident_militar)->exists();
		if (!$crtl) {
			return response()->json(['error' => "Número de Identidade não existe!"]);
		}

		DB::beginTransaction();
		try {
			/*
			** Consulta qual foi o ulitmo número registrado
			*/
			$value = DB::table('INFORMATION_SCHEMA.TABLES')
				->select('AUTO_INCREMENT as last_id')
				->where('TABLE_SCHEMA', $nameDB)
				->where('TABLE_NAME', $nameTB)
				->first();

			/*
			** Atualiza o ID do Militar
			*/
			Cad_militar::where('ident_militar', $request->ident_militar)->update(['id' => $value->last_id]);
			/*
			** Atualiza o número do Auto Increment da Tabela.
			*/
			DB::statement('ALTER TABLE ' . $nameTB . ' AUTO_INCREMENT =' . $value->last_id);
			$this->criar_log(32, $value->last_id, NULL, Auth::user()->id, $request->getClientIp());
		} catch (QueryException $e) {
			DB::rollback();
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
		DB::commit();
		return response()->json(['msg' => "Número do crachá alterado com sucesso!"]);
	}

	public function veiculo(Request $request, $id)
	/*
	Faz as consulta dos dados do militar e enviar para a view montar o crachá Pedestre/Pessoal;
	Registra na tabela cad_logs a operação;
	*/
	{
		$veiculo = DB::table('cad_automovel')
			->select(
				'cad_automovel.id',
				'cad_automovel.placa',
				'cad_automovel.baixa',
				'cad_militar.nome_guerra',
				'cad_posto.nome as posto_nome',
				'cad_posto.letra',
				'cad_marca.nome as marca',
				'cad_modelo.nome as modelo',
				'cad_om.nome as om_nome'
			)
			->join(
				'cad_marca',
				'cad_marca.id',
				'=',
				'cad_automovel.marca_id'
			)
			->join(
				'cad_modelo',
				'cad_modelo.id',
				'=',
				'cad_automovel.modelo_id'
			)
			->join(
				'cad_militar',
				'cad_militar.id',
				'=',
				'cad_automovel.militar_id'
			)
			->join(
				'cad_om',
				'cad_militar.om_id',
				'=',
				'cad_om.id'
			)
			->join(
				'cad_posto',
				'cad_militar.posto',
				'=',
				'cad_posto.id'
			)
			->where('cad_automovel.id', '=', $id)
			->first();

		$crtl = DB::table('cad_automovel')->where('placa', '=', $veiculo->placa)
			->where('baixa', '=', 0)
			->where('id', '<>', $veiculo->id)
			->exists();
		if ($crtl) {
			return back()->with('error', 'Já existe algum veículo ativo com esta placa!');
		}

		if ($veiculo->baixa == 1) {
			return back()->with('error', 'Veículo com STATUS DESATIVADO!');
		}

		$this->criar_log(30, NULL, $veiculo->id, Auth::user()->id, $request->getClientIp());
		return view('sys.cracha.veiculo', compact('veiculo'));
	}

	public function viatura(Request $request, $id)
	/*
	Faz as consulta dos dados do militar e enviar para a view montar o crachá Pedestre/Pessoal;
	Registra na tabela cad_logs a operação;
	*/
	{
		$viatura = DB::table('cad_automovel')
			->select(
				'cad_automovel.id',
				'cad_automovel.placa',
				'cad_automovel.baixa',
				'cad_militar.nome_guerra',
				'cad_posto.nome as posto_nome',
				'cad_posto.letra',
				'cad_marca.nome as marca',
				'cad_modelo.nome as modelo',
				'cad_om.nome as om_nome'
			)
			->join(
				'cad_marca',
				'cad_marca.id',
				'=',
				'cad_automovel.marca_id'
			)
			->join(
				'cad_modelo',
				'cad_modelo.id',
				'=',
				'cad_automovel.modelo_id'
			)
			->join(
				'cad_militar',
				'cad_militar.id',
				'=',
				'cad_automovel.militar_id'
			)
			->join(
				'cad_om',
				'cad_militar.om_id',
				'=',
				'cad_om.id'
			)
			->join(
				'cad_posto',
				'cad_militar.posto',
				'=',
				'cad_posto.id'
			)
			->where('cad_automovel.id', '=', $id)
			->first();

		$vtr = Cad_viaturas::where('automovel_id', '=', $id)->first();

		if ($vtr->vtr_cmt == 1) {
			$viatura->letra = "Z";
		}
		if ($vtr->vtr_cmt == 0) {
			$viatura->letra = "X";
		}

		if ($viatura->baixa == 1) {
			return back()->with('error', 'Viatura com STATUS DESATIVADO!');
		}

		$this->criar_log(31, NULL, $viatura->id, Auth::user()->id, $request->getClientIp());
		return view('sys.cracha.viatura', compact('veiculo'));
	}



	public function pedestre(Request $request, $id)
	/*
	Faz as consulta dos dados do militar e enviar para a view montar o crachá Pedestre/Pessoal;
	Registra na tabela cad_logs a operação;
	*/
	{
		$militar = DB::table('cad_militar')
			->select(
				'cad_militar.ident_militar',
				'cad_militar.datafile',
				'cad_militar.id',
				'cad_militar.status',
				'cad_militar.posto',
				'cad_militar.om_id',
				'cad_militar.nome_guerra',
				'cad_posto.nome as posto_nome',
				'cad_posto.letra as posto_letra',
				'cad_om.nome as om_nome'
			)
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
			->where('cad_militar.id', '=', $id)
			->first();

		if ($militar->status == 2) {
			return back()->with('error', 'Militar com STATUS DESATIVADO!');
		}

		$this->criar_log(29, $militar->id, NULL, Auth::user()->id, $request->getClientIp());
		return view('sys.cracha.pedestre', compact('militar'));
	}

	public function criar_log($id_operacao, $id_militar, $id_veiculo, $id_operador, $endereco_ip)
	/*
	Função para salvar a operação de gerar crachá;
	*/
	{
		$log = new Cad_logs;
		$log->id_operacao = $id_operacao;
		$log->id_militar = $id_militar;
		$log->id_veiculo = $id_veiculo;
		$log->id_operador = $id_operador;
		$log->data_hora = date('Y-m-d H:i');
		$log->endereco_ip = $endereco_ip;
		$log->save();
	}
}
