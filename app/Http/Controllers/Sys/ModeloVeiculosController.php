<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\Sys\Cad_tipo_automovel;
use App\Model\Sys\Cad_modelo;
use DB;

class ModeloVeiculosController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | VIEWS 
    |--------------------------------------------------------------------------
    | Retorna a página referente a inserir um novo modelo de veículo
    | HTML disponível em resources/views/sys/configuraçoes/veiculos
	*/

	public function index()
	/* Retorna a tela para cadastrar um novo modelo de veículo */
	{
		$this->authorize('config_veiculos_modelo', Cad_modelo::class);
		$tipo_v 	 = Cad_tipo_automovel::all();
		return view('sys.configuracoes.veiculos.modelo_veiculos', compact('tipo_v'));
	}

	/*
    |--------------------------------------------------------------------------
    | OPERAÇÕES 
    |--------------------------------------------------------------------------
    | Manipula o evento da interface do usuário
	*/

	public function store(Request $request)
	/* Cadastra um novo modelo de veículo */
	{
		$dados 	= $request->all();
		$regras = [
			'marca' => 'required',
			'modelo' => 'required',
			'tipo' => 'required',
		];
		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		try {
			$modelo = new Cad_modelo;
			$modelo->nome = trim($dados['modelo']);
			$modelo->tipo_id = $dados['tipo'];
			$modelo->marca_id = $dados['marca'];
			$modelo->save();
			return redirect()->route('sys.configuracoes.veiculos.modelo_veiculos')->with('success', 'Cadastro realizado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
	}

	public function update(Request $request)
	/* Atualiza um modelo já existente */
	{
		$modelo = Cad_modelo::findOrFail($request->id);
		$dados = $request->all();
		$regras = [
			'modelo_edt' => 'required',
			'marca_edt' => 'required',
			'tipo_edt' => 'required',
		];
		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		try {
			$modelo->nome = $dados['modelo_edt'];
			$modelo->tipo_id = $dados['tipo_edt'];
			$modelo->marca_id = $dados['marca_edt'];
			$modelo->save();
			return redirect()->route('sys.configuracoes.veiculos.modelo_veiculos')->with('success', 'Cadastro editado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
	}

	public function listagem(Request $request)
	/* Lista todos modelo de veículos */
	{
		$data = array();
		$modelos = DB::table('cad_modelo')
			->select(
				'cad_modelo.id',
				'cad_modelo.nome',
				'cad_tipo_automovel.nome as tipo_nome',
				'cad_marca.nome as marca'
			)
			->join(
				'cad_tipo_automovel',
				'cad_modelo.tipo_id',
				'=',
				'cad_tipo_automovel.id'
			)
			->join(
				'cad_marca',
				'cad_modelo.marca_id',
				'=',
				'cad_marca.id'
			)
			->orderBy('cad_modelo.tipo_id')
			->orderBy('cad_marca.nome')
			->orderBy('cad_modelo.nome')
			->get();

		$totalData = Cad_modelo::count();
		$totalFiltered = $totalData;

		if (!empty($modelos)) {
			foreach ($modelos as $value) {
				$nestedData['id'] = $value->id;
				$nestedData['modelo'] = $value->nome;
				$nestedData['tipo'] = $value->tipo_nome;
				$nestedData['marca'] = $value->marca;
				$nestedData['options'] =
					"<button title='Editar' id={$value->id} class=\"btn btn-sm btn-primary\"><i class=\"fa fa-edit\"></i></button>";
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
