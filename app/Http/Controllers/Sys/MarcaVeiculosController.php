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
	public function index()
	{
		$tipo_v 	 = Cad_tipo_automovel::all();
		return view('sys.configuracoes.veiculos.marca_veiculos', compact('tipo_v'));
	}

	public function store(Request $request)
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
			return back()->with('error', $e);
		}
	}

	public function update(Request $request)
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
			return back()->with('error', $e);
		}
	}

	public function listagem(Request $request)
	{
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
			$json_data = array(
				"draw"            => intval($request->input('draw')),
				"recordsTotal"    => intval($totalData),
				"recordsFiltered" => intval($totalFiltered),
				"data"            => $data
			);
			echo json_encode($json_data);
		} else {
			echo '{"error":"Nenhuma marca encontrada!"}';
		}
	}
}
