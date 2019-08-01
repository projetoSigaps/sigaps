<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Sys\Cad_automovel;
use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_viaturas;
use Illuminate\Support\Facades\Auth;
use App\Model\Sys\Cad_logs;
use DB;

class CrachaController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | VIEWS 
    |--------------------------------------------------------------------------
    | Retornam as páginas onde é confeccionado o Crachá
    | HTML disponível em resources/views/sys/cracha
	*/

	public function trocarCrachaIndex()
	/* Página onde é solicitado a troca de crachá */
	{
		$this->authorize('trocarCracha', Cad_militar::class);
		return view('sys.configuracoes.trocarCracha');
	}

	/*
    |--------------------------------------------------------------------------
    | OPERAÇÕES 
    |--------------------------------------------------------------------------
    | Gera os crachás
    */

	public function veiculo(Request $request, $id)
	/*
	Faz as consulta dos dados do militar e enviar para a view montar o crachá de Veículo;
	Registra na tabela cad_logs a operação;
	*/
	{
		if (!Auth::user()->hasRole(['super-admin', 'administrador'])) {
			return response()->json([
				'Error' => '403, Forbidden',
				'Exception' => strtoupper(substr(md5(rand()), 0, 20)),
				'Descrição' => 'Você não tem autorização para visualizar este conteúdo!',
			], 403);
		}

		$veiculo = Cad_automovel::select(
			'cad_automovel.id',
			'cad_automovel.placa',
			'cad_automovel.baixa',
			'cad_automovel.tipo_id',
			'cad_militar.nome_guerra',
			'cad_militar.om_id',
			'cad_posto.nome as posto_nome',
			'cad_posto.letra',
			'cad_marca.nome as marca',
			'cad_modelo.nome as modelo',
			'cad_om.nome as om_nome',
			'cad_om.cor_cracha'
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
			->where('cad_automovel.id', '=', $id);

		if (!Auth::user()->hasRole('super-admin')) {
			$veiculo = $veiculo->where('cad_militar.om_id', Auth::user()->om_id);
		}
		$veiculo = $veiculo->first();

		if (!$veiculo) {
			return abort(404);
		}

		$crtl = DB::table('cad_automovel')->where('placa', '=', $veiculo->placa)
			->where('baixa', '=', 0)
			->where('id', '<>', $veiculo->id)
			->exists();
		if ($crtl) {
			return back()->with('error', 'Já existe algum veículo ativo com esta placa!');
		}

		if (!$veiculo->baixa) {
			return back()->with('error', 'Veículo com STATUS DESATIVADO!');
		}

		$this->criar_log(30, NULL, $veiculo->id, Auth::user()->id, $request->getClientIp());

		if ($veiculo->tipo_id == 2) {
			return view('sys.cracha.moto', compact('veiculo'));
		} else {
			return view('sys.cracha.veiculo', compact('veiculo'));
		}
	}

	public function viatura(Request $request, $id)
	/*
	Faz as consulta dos dados do militar e enviar para a view montar o crachá de Viatura;
	Registra na tabela cad_logs a operação;
	*/
	{
		if (!Auth::user()->hasRole(['super-admin', 'administrador'])) {
			return response()->json([
				'Error' => '403, Forbidden',
				'Exception' => strtoupper(substr(md5(rand()), 0, 20)),
				'Descrição' => 'Você não tem autorização para visualizar este conteúdo!',
			], 403);
		}

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
				'cad_om.nome as om_nome',
				'cad_om.cor_cracha'
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
			->where('cad_automovel.id', '=', $id);

		if (!Auth::user()->hasRole('super-admin')) {
			$viatura = $viatura->where('cad_militar.om_id', Auth::user()->om_id);
		}
		$viatura = $viatura->first();

		if (!$viatura) {
			return abort(404);
		}

		$vtr = Cad_viaturas::where('automovel_id', '=', $id)->first();

		if ($vtr->vtr_cmt == 1) {
			$viatura->letra = "Z";
		}
		if ($vtr->vtr_cmt == 0) {
			$viatura->letra = "X";
		}
		if (!$viatura->baixa) {
			return back()->with('error', 'Viatura com STATUS DESATIVADO!');
		}
		$this->criar_log(31, NULL, $viatura->id, Auth::user()->id, $request->getClientIp());
		return view('sys.cracha.viatura', compact('viatura'));
	}

	public function pedestre(Request $request, $id)
	/*
	Faz as consulta dos dados do militar e enviar para a view montar o crachá Pedestre/Pessoal;
	Registra na tabela cad_logs a operação;
	*/
	{
		if (!Auth::user()->hasRole(['super-admin', 'administrador'])) {
			return response()->json([
				'Error' => '403, Forbidden',
				'Exception' => strtoupper(substr(md5(rand()), 0, 20)),
				'Descrição' => 'Você não tem autorização para visualizar este conteúdo!',
			], 403);
		}

		$militar = Cad_militar::select(
			'cad_militar.ident_militar',
			'cad_militar.datafile',
			'cad_militar.id',
			'cad_militar.status',
			'cad_militar.posto',
			'cad_militar.om_id',
			'cad_militar.nome_guerra',
			'cad_posto.nome as posto_nome',
			'cad_posto.letra as posto_letra',
			'cad_om.nome as om_nome',
			'cad_om.cor_cracha'
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
			->where('cad_militar.id', '=', $id);

		if (!Auth::user()->hasRole('super-admin')) {
			$militar = $militar->where('cad_militar.om_id', Auth::user()->om_id);
		}

		$militar = $militar->first();

		if (!$militar) {
			return abort(404);
		}

		if (!$militar->status) {
			return back()->with('error', 'Militar com STATUS DESATIVADO!');
		}

		$this->criar_log(29, $militar->id, NULL, Auth::user()->id, $request->getClientIp());
		return view('sys.cracha.pedestre', compact('militar'));
	}

	public function trocarCracha(Request $request)
	/*	Operação onde é realizada a troca do ID do militar no banco de dados.
	*	Modelo do banco é em cascade, ou seja, trocando o ID todas as foreign keys são atualizadas.
	*/
	{
		$item = new Cad_militar;
		$nameTB = $item->getTable();
		$nameDB = DB::connection()->getDatabaseName();

		$crtl = Cad_militar::where('ident_militar', '=', $request->ident_militar);
		if (!Auth::user()->hasRole('super-admin')) {
			$crtl = $crtl->where('cad_militar.om_id', Auth::user()->om_id);
		}

		$crtl = $crtl->exists();

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
		} catch (QueryException $e) {
			DB::rollback();
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
		DB::commit();
		$this->criar_log(32, $value->last_id, NULL, Auth::user()->id, $request->getClientIp());
		return response()->json(['msg' => "Número do crachá alterado com sucesso!"]);
	}

	public function criar_log($id_operacao, $id_militar, $id_veiculo, $id_operador, $endereco_ip)
	/*
	Função para salvar as operações (Logs);
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
