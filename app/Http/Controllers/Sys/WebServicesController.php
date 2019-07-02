<?php

namespace App\Model\Sys;

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_automovel;
use App\Model\Sys\Cad_marca;
use App\Model\Sys\Cad_modelo;
use App\Model\Sys\Cad_om;
use App\Model\Sys\Cad_posto;
use App\Model\Sys\Cad_tipo_automovel;
use App\User;

use DB;

class WebServicesController extends Controller
{

	public function validacaoIdentidade(Request $request)
	/*
	Verifica se numero de identidade já existe na hora do cadastro.
	*/
	{
		$crtl = Cad_militar::where('ident_militar', '=', $request->ident_militar)->exists();
		if ($crtl) {
			return response()->json([
				'error' => "Número de identidade já cadastrada!"
			]);
		}
	}

	public function validacaoCnh(Request $request)
	/*
	Verifica se numero de CNH já existe na hora do cadastro.
	*/
	{
		$crtl = Cad_militar::where('cnh', '=', $request->cnh)->exists();
		if ($crtl) {
			return response()->json([
				'error' => "Número de CNH já cadastrada!"
			]);
		}
	}

	public function validacaoPlaca(Request $request)
	{
		$crtl = Cad_automovel::where('placa', '=', $request->placa)->where('baixa', '=', 0)->exists();
		if ($crtl) {
			return response()->json([
				'error' => "Já existe um veículo ATIVO com esta placa!"
			]);
		}
	}

	public function validacaoRenavam(Request $request)
	{
		$crtl = Cad_automovel::where('renavan', '=', $request->renavam)->where('baixa', '=', 0)->exists();
		if ($crtl) {
			return response()->json([
				'error' => "Já existe um veículo ATIVO com este renavam!"
			]);
		}
	}
	public function listagemMilitares(Request $request)
	/*
	Utilizado para popular o DataTables, retorna os dados em formato JSON (Ver documentação https://datatables.net/manual).
	Para cada página, faz um request no DB.
	*/
	{

		$totalData = Cad_militar::count();
		$totalFiltered = $totalData;

		$limit = $request->input('length');
		$start = $request->input('start');

		$order = 0;
		$dir = "desc";

		if (empty($request->input('search.value'))) {
			$militares = DB::table('cad_militar')
				->select(
					'cad_militar.nome',
					'cad_militar.nome_guerra',
					'cad_militar.ident_militar',
					'cad_posto.nome as posto_nome',
					'cad_om.nome as om_nome',
					'cad_militar.id',
					'cad_militar.status'
				)
				->selectRaw('LPAD(cad_posto.ordem,2,0) as ordem')
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
				->where('cad_posto.id', '!=', 34)
				->skip($start)
				->take($limit)
				->orderBy('ordem', 'asc')
				->get();
		} else {
			$search = $request->input('search.value');

			$militares = DB::table('cad_militar')
				->select(
					'cad_militar.nome',
					'cad_militar.nome_guerra',
					'cad_militar.ident_militar',
					'cad_posto.nome as posto_nome',
					'cad_om.nome as om_nome',
					'cad_militar.id',
					'cad_militar.status'
				)
				->selectRaw('LPAD(cad_posto.ordem,2,0) as ordem')
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
				->where('cad_militar.nome', 'LIKE', "%{$search}%")
				->orWhere('cad_militar.ident_militar', 'LIKE', "%{$search}%")
				->orWhere('cad_militar.nome_guerra', 'LIKE', "%{$search}%")
				->skip($start)
				->take($limit)
				->orderBy('ordem', 'asc')
				->get();

			$totalFiltered = Cad_militar::where('nome', 'LIKE', "%{$search}%")
				->orWhere('ident_militar', 'LIKE', "%{$search}%")
				->count();
		}

		$data = array();
		if (!empty($militares)) {
			foreach ($militares as $value) {
				$editar =  route('sys.militares.cadastro.editar', $value->id);
				$selo 	=  route('sys.cracha.pedestre', $value->id);

				if ($value->status == 1) {
					$status = "<span class='label label-success'>Ativo</span>";
				}
				if ($value->status == 2) {
					$status = "<span class='label label-danger'>Desativado</span>";
				}

				$nestedData['id'] = $value->id;
				$nestedData['nome'] = $value->nome;
				$nestedData['nome_guerra'] = $value->nome_guerra;
				$nestedData['posto_nome'] = $value->posto_nome;
				$nestedData['ident_militar'] = $value->ident_militar;
				$nestedData['om_nome'] = $value->om_nome;
				$nestedData['status'] = $status;
				$nestedData['options'] =
					"<a target='_blank' href='{$editar}' title='Editar' class=\"btn btn-sm btn-primary\"><i class=\"fa fa-edit\"></i></a>
				<a target='_blank' href='{$selo}' title='Gerar Selo' class=\"btn btn-sm btn-warning\"><i class=\"fa fa-qrcode\"></i></a>";
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

	public function pesquisarViatura(Request $request)
	/*
	Utilizado para popular o DataTables, retorna os dados em formato JSON (Ver documentação https://datatables.net/manual).
	Para cada página, faz um request no DB.
	*/
	{
		$usuario_vtr = Cad_militar::where('om_id', '=', $request->id)->where('posto', '=', 34)->first();
		if (empty($usuario_vtr)) {
			echo "<p style=\"margin-bottom: 0px;vertical-align:middle;\" class=\"alert-danger\"> Sem Usuário Vinculado! </p>";
			die();
		}

		$veiculos = DB::table('cad_automovel')
			->select(
				'cad_automovel.*',
				'cad_viaturas.*',
				'cad_marca.nome as marca',
				'cad_modelo.nome as modelo'
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
				'cad_viaturas',
				'cad_viaturas.automovel_id',
				'=',
				'cad_automovel.id'
			)
			->where('cad_automovel.militar_id', '=', $usuario_vtr->id)
			->get();

		if ($veiculos->isEmpty()) {
			echo "<p style=\"margin-bottom: 0px;vertical-align:middle;\" class=\"alert-warning\">Nenhum Registro Encontrado!</p>";
			die();
		}

		$tbl = "<table width=\"100%\" class=\"table\" style=\"margin-bottom: 0px;\">";

		foreach ($veiculos as $value) {

			$editar =  route('sys.configuracoes.viaturas.editar', $value->automovel_id);
			$selo 	=  route('sys.cracha.viatura', $value->automovel_id);

			if ($value->baixa == 0) {
				$value->baixa = "<span class=\"label label-success\">Ativo</span>";
			} else {
				$value->baixa = "<span class=\"label label-danger\">Desativada</span>";
			}

			if ($value->vtr_cmt == 1) {
				$value->vtr_cmt = "<span class=\"text-success\">Sim</span>";
			} else {
				$value->vtr_cmt = "<span class=\"text-danger\">Não</span>";
			}

			$tbl .= "
			<tr style=\"font-size:13px;\" class=\"success\">
			<td style=\"vertical-align:middle;\">Nº Crachá: <b>" . $value->automovel_id . "</b></td>
			<td style=\"vertical-align:middle;\">Tipo: <b>" . $value->cat . "</b></td>
			<td style=\"vertical-align:middle;\">Marca/Modelo: <b> " . $value->marca . "/" . $value->modelo . "</b></td>
			<td style=\"vertical-align:middle;\">Placa: <b>" . $value->placa . "</b></td>
			<td style=\"vertical-align:middle;\">Ano: <b>" . $value->ano_auto . "</b></td>
			<td style=\"vertical-align:middle;\">Vtr Cmt: <b>" . $value->vtr_cmt . "</b></td>
			<td style=\"vertical-align:middle;\">" . $value->baixa . "</td>
			<td style=\"vertical-align:middle;\">
			<a target='_blank' href='{$editar}' title='Editar' class=\"btn btn-sm btn-primary\"><i class=\"fa fa-edit\"></i></a>
			<a target='_blank' href='{$selo}' title='Gerar Crachá' class=\"btn btn-sm btn-warning\"><i class=\"fa fa-qrcode\"></i></a>
			</td>
			</tr>
			";
		}
		$tbl .= "</table>";
		echo $tbl;
	}


	public function pesquisarVeiculo(Request $request)
	/*
	Utilizado para popular o DataTables, retorna os dados em formato JSON (Ver documentação https://datatables.net/manual).
	Para cada página, faz um request no DB.
	*/
	{

		$veiculos = DB::table('cad_automovel')
			->select(
				'cad_automovel.*',
				'cad_marca.nome as marca',
				'cad_modelo.nome as modelo'
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
			->where('cad_automovel.militar_id', '=', $request->id)
			->get();

		if ($veiculos->isEmpty()) {
			echo "<p style=\"margin-bottom: 0px;vertical-align:middle;\" class=\"alert-warning\">Nenhum Registro Encontrado!</p>";
			die();
		}

		$tbl = "<table width=\"100%\" class=\"table\" style=\"margin-bottom: 0px;\">";

		foreach ($veiculos as $value) {

			$editar =  route('sys.veiculos.cadastro.editar', $value->id);
			$selo 	=  route('sys.cracha.veiculo', $value->id);

			if ($value->baixa == 0) {
				$value->baixa = "<span class=\"label label-success\">Ativo</span>";
			} else {
				$value->baixa = "<span class=\"label label-danger\">Desativado</span>";
			}

			$tbl .= "
			<tr style=\"font-size:13px;\" class=\"success\">
			<td style=\"vertical-align:middle;\">Nº Crachá: <b>" . $value->id . "</b></td>
			<td style=\"vertical-align:middle;\">Marca/Modelo: <b> " . $value->marca . "/" . $value->modelo . "</b></td>
			<td style=\"vertical-align:middle;\">Placa: <b>" . $value->placa . "</b></td>
			<td style=\"vertical-align:middle;\">Ano: <b>" . $value->ano_auto . "</b></td>
			<td style=\"vertical-align:middle;\">Cor: <b>" . $value->cor . "</b></td>
			<td style=\"vertical-align:middle;\">" . $value->baixa . "</td>
			<td style=\"vertical-align:middle;\">
			<a target='_blank' href='{$editar}' title='Editar' class=\"btn btn-sm btn-primary\"><i class=\"fa fa-edit\"></i></a>
			<a target='_blank' href='{$selo}' title='Gerar Crachá' class=\"btn btn-sm btn-warning\"><i class=\"fa fa-qrcode\"></i></a>
			</td>
			</tr>
			";
		}
		$tbl .= "</table>";
		echo $tbl;
	}

	public function pesquisaMilitar(Request $request)
	{

		$tp_doc = addslashes($request->tipo_documento);
		$num_doc = addslashes($request->numero_documento);

		switch ($tp_doc) {

			case "cnh":
				$militar = DB::table('cad_militar')
					->select(
						'cad_militar.ident_militar',
						'cad_militar.id as militar_id',
						'cad_militar.nome_guerra',
						'cad_militar.nome',
						'cad_militar.cnh',
						'cad_militar.cnh_cat',
						DB::raw("DATE_FORMAT(cad_militar.cnh_venc, '%Y') as cnh_venc"),
						'cad_posto.nome as posto_nome',
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
					->where('cad_militar.cnh', '=', $num_doc)
					->first();
				if (!empty($militar)) {
					return response()->json($militar);
				} else {
					return response()->json([
						'error' => "Nenhum militar encontrado!"
					]);
				}
				break;

			case "ident_militar":
				$militar = DB::table('cad_militar')
					->select(
						'cad_militar.ident_militar',
						'cad_militar.id as militar_id',
						'cad_militar.nome_guerra',
						'cad_militar.nome',
						'cad_militar.cnh',
						'cad_militar.cnh_cat',
						DB::raw("DATE_FORMAT(cad_militar.cnh_venc, '%d/%m/%Y') as cnh_venc"),
						'cad_posto.nome as posto_nome',
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
					->where('cad_militar.ident_militar', '=', $num_doc)
					->first();
				if (!empty($militar)) {
					return response()->json($militar);
				} else {
					return response()->json([
						'error' => "Nenhum militar encontrado!"
					]);
				}
				break;

			default:
				return response()->json([
					'error' => "Tipo de documento inválido!"
				]);
				break;
		}
	}

	public function pesquisaMarca(Request $request)
	{
		$result = Cad_marca::where('tipo_id', '=', $request->id_tipo)
			->orderBy('nome', 'asc')
			->get();
		$marca 	= "";
		foreach ($result as $value) {
			$marca .= "<option value=\"{$value->id}\">{$value->nome}</option>";
		}
		echo $marca;
	}

	public function pesquisaModelo(Request $request)
	{
		$result = Cad_modelo::where('marca_id', '=', $request->id_marca)
			->orderBy('nome', 'asc')
			->get();
		$modelo 	= "";
		foreach ($result as $value) {
			$modelo .= "<option value=\"{$value->id}\">{$value->nome}</option>";
		}
		echo $modelo;
	}

	public function pesquisaOM(Request $request)
	{
		$result = Cad_Om::where('id', '=', $request->id)->first();
		if (!empty($result)) {
			return response()->json($result);
		} else {
			return response()->json([
				'error' => "Nenhuma OM encontrada!"
			]);
		}
	}

	public function pesquisaPosto(Request $request)
	{
		$result = Cad_posto::where('id', '=', $request->id)->first();

		if (!empty($result)) {

			switch ($result->letra) {
				case "A":
					$result->tipo = 1;
					break;
				case "B":
					$result->tipo = 2;
					break;
				case "C":
					$result->tipo = 3;
					break;
				case "D":
					$result->tipo = 4;
					break;
				case "E":
					$result->tipo = 5;
					break;
				case "F":
					$result->tipo = 6;
					break;
			}
			return response()->json($result);
		} else {
			return response()->json([
				'error' => "Nenhum Posto/Graduação encontrado"
			]);
		}
	}

	public function pesquisaTipoVeiculo(Request $request)
	{
		$result = Cad_tipo_automovel::where('id', '=', $request->id)->first();
		if (!empty($result)) {
			return response()->json($result);
		} else {
			return response()->json([
				'error' => "Nenhum Tipo encontrado!"
			]);
		}
	}
	public function pesquisaMarcaVeiculo(Request $request)
	{
		$result = Cad_marca::where('id', '=', $request->id)->first();
		if (!empty($result)) {
			return response()->json($result);
		} else {
			return response()->json([
				'error' => "Nenhuma Marca encontrada!"
			]);
		}
	}

	public function pesquisaModeloVeiculo(Request $request)
	{
		$result['modelo'] = Cad_modelo::findOrFail($request->id);
		$result['marca'] = Cad_marca::where('tipo_id', '=', $result['modelo']->tipo_id)
			->orderBy('nome')
			->get();

		if (!empty($result)) {
			return response()->json($result);
		} else {
			return response()->json([
				'error' => "Nenhum Modelo encontrado!"
			]);
		}
	}

	public function trocarSenha(Request $request)
	{
		$result =  User::where('login', $request->login)->first();

		if (!empty($result)) {
			$usuario = User::where('id', $result->id)->update(['password' => bcrypt($result->login), 'password_changed_at' => NULL]);
			return response()->json([
				'msg' => "Senha trocada com sucesso!"
			]);
		} else {
			return response()->json([
				'error' => "Usuário não encontrado!"
			]);
		}
	}
}
