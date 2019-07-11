<?php

namespace App\Model\Sys;

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\Sys\Cad_tipo_automovel;

class TipoVeiculosController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | VIEWS 
    |--------------------------------------------------------------------------
    | Retorna a página referente a inserir um novo modelo de veículo
    | HTML disponível em resources/views/sys/configuraçoes/veiculos
	*/

	public function index()
	/* Exibi a tela para cadastrar um novo tipo de automovél */
	{
		$this->authorize('config_veiculos_tipo', Cad_tipo_automovel::class);
		return view('sys.configuracoes.veiculos.tipo_veiculos');
	}

	/*
    |--------------------------------------------------------------------------
    | OPERAÇÕES 
    |--------------------------------------------------------------------------
    | Manipula o evento da interface do usuário
	*/

	public function store(Request $request)
	/* Cadastra um novo tipo de automovel */
	{
		$dados 	= $request->all();
		$regras = [
			'nome' => 'required',
		];
		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		try {
			$tipo = new Cad_tipo_automovel;
			$tipo->nome = trim($dados['nome']);
			$tipo->save();
			return redirect()->route('sys.configuracoes.veiculos.tipo_veiculos')->with('success', 'Cadastro realizado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
	}

	public function update(Request $request)
	/* Atualiza os dados do tipo */
	{
		$tipo = Cad_tipo_automovel::findOrFail($request->id);
		$dados = $request->all();
		$regras = [
			'nome_edt' => 'required',
		];
		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		try {
			$tipo->nome = $dados['nome_edt'];
			$tipo->save();
			return redirect()->route('sys.configuracoes.veiculos.tipo_veiculos')->with('success', 'Cadastro editado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
	}

	public function listagem(Request $request)
	/* Lista todos tipo de automoveis cadastrados */
	{
		$data = array();
		$tipos = Cad_tipo_automovel::all()->sortBy('nome');
		$totalData = Cad_tipo_automovel::count();
		$totalFiltered = $totalData;

		if (!empty($tipos)) {
			foreach ($tipos as $value) {
				$nestedData['id'] = $value->id;
				$nestedData['nome'] = $value->nome;
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
