<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\Sys\Cad_tipo_automovel;
use App\Model\Sys\Cad_marca;
use DB;

class MarcaVeiculosController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | VIEWS 
    |--------------------------------------------------------------------------
    | Retorna a página referente a inserir uma nova marca de veículo
    | HTML disponível em resources/views/sys/configuraçoes/veiculos
    */

	public function index()
	/* Retorna a tela para registrar uma nova marca de véiculo */
	{
		$this->authorize('config_veiculos_marca', Cad_marca::class);
		$tipo_v 	 = Cad_tipo_automovel::all();
		return view('sys.configuracoes.veiculos.marca_veiculos', compact('tipo_v'));
	}

	/*
    |--------------------------------------------------------------------------
    | OPERAÇÕES 
    |--------------------------------------------------------------------------
    | Manipula o evento da interface do usuário
	*/

	public function store(Request $request)
	/* Cadastra uma nova marca */
	{
		$dados 	= $request->all();
		$regras = [
			'nome' => 'required',
			'tipo' => 'required',
		];
		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		try {
			$marca = new Cad_marca;
			$marca->nome = trim($dados['nome']);
			$marca->tipo_id = $dados['tipo'];
			$marca->save();
			return redirect()->route('sys.configuracoes.veiculos.marca_veiculos')->with('success', 'Cadastro realizado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
	}

	public function update(Request $request)
	/* Atualiza uma marca já existente */
	{
		$marca = Cad_marca::findOrFail($request->id);
		$dados = $request->all();
		$regras = [
			'nome_edt' => 'required',
			'tipo_edt' => 'required',
		];
		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		try {
			$marca->nome = $dados['nome_edt'];
			$marca->tipo_id = $dados['tipo_edt'];
			$marca->save();
			return redirect()->route('sys.configuracoes.veiculos.marca_veiculos')->with('success', 'Cadastro editado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
	}

	public function listagem(Request $request)
	/* Lista todas as marcas */
	{
		$data = array();
		$marcas = DB::table('cad_marca')
			->select(
				'cad_marca.id',
				'cad_marca.nome',
				'cad_tipo_automovel.nome as tipo_nome'
			)
			->join(
				'cad_tipo_automovel',
				'cad_marca.tipo_id',
				'=',
				'cad_tipo_automovel.id'
			)
			->orderBy('cad_marca.tipo_id')
			->orderBy('cad_marca.nome')
			->get();

		$totalData = Cad_marca::count();
		$totalFiltered = $totalData;

		if (!empty($marcas)) {
			foreach ($marcas as $value) {
				$nestedData['id'] = $value->id;
				$nestedData['nome'] = $value->nome;
				$nestedData['tipo'] = $value->tipo_nome;
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
