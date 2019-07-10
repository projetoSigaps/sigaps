<?php

namespace App\Model\Sys;

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\Sys\Cad_posto;

class PostosController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | VIEWS 
    |--------------------------------------------------------------------------
    | Retorna a página referente a inserir uma nova marca de veículo
    | HTML disponível em resources/views/sys/configuraçoes/veiculos
	*/

	public function index()
	/* Retorna a tela para registrar um novo posto ou graduação */
	{
		if (!Auth::user()->hasRole('super-admin')) {
			return response()->json([
				'Error' => '403, Forbidden',
				'Exception' => strtoupper(substr(md5(rand()), 0, 20)),
				'Descrição' => 'Você não tem autorização para visualizar este conteúdo!',
			], 403);
		}
		return view('sys.configuracoes.postos');
	}

	/*
    |--------------------------------------------------------------------------
    | OPERAÇÕES 
    |--------------------------------------------------------------------------
    | Manipula o evento da interface do usuário
	*/

	public function store(Request $request)
	/* Cadastra um novo P/G */
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
			$posto = new Cad_posto;
			$posto->nome = trim($dados['nome']);
			switch ($dados['tipo']) {
				case "1":
					$posto->letra = "A";
					$posto->tipo = "Oficial General";
					$posto->ordem = 4;
					break;
				case "2":
					$posto->letra = "B";
					$posto->tipo = "Oficiais Superiores";
					$posto->ordem = 7;
					break;
				case "3":
					$posto->letra = "C";
					$posto->tipo = "Oficiais Subalternos/Intermediarios";
					$posto->ordem = 11;
					break;
				case "4":
					$posto->letra = "D";
					$posto->tipo = "Praças";
					$posto->ordem = 15;
					break;
				case "5":
					$posto->letra = "E";
					$posto->tipo = "Praças";
					$posto->ordem = 17;
					break;
				case "6":
					$posto->letra = "F";
					$posto->tipo = "Civil";
					$posto->ordem = 21;
					break;
			}
			$posto->save();
			return redirect()->route('sys.configuracoes.postos')->with('success', 'Cadastro realizado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
	}

	public function update(Request $request)
	/* Atualiza os dados do P/G */
	{
		$posto = Cad_posto::findOrFail($request->id);
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
			$posto->nome = $dados['nome_edt'];
			switch ($dados['tipo_edt']) {
				case "1":
					$posto->letra = "A";
					$posto->tipo = "Oficial General";
					$posto->ordem = 4;
					break;
				case "2":
					$posto->letra = "B";
					$posto->tipo = "Oficiais Superiores";
					$posto->ordem = 7;
					break;
				case "3":
					$posto->letra = "C";
					$posto->tipo = "Oficiais Subalternos/Intermediarios";
					$posto->ordem = 11;
					break;
				case "4":
					$posto->letra = "D";
					$posto->tipo = "Praças";
					$posto->ordem = 15;
					break;
				case "5":
					$posto->letra = "E";
					$posto->tipo = "Praças";
					$posto->ordem = 17;
					break;
				case "6":
					$posto->letra = "F";
					$posto->tipo = "Civil";
					$posto->ordem = 21;
					break;
			}
			$posto->save();
			return redirect()->route('sys.configuracoes.postos')->with('success', 'Cadastro editado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
	}

	public function postosListagem(Request $request)
	/* Lista todos postos e graduações */
	{
		$data = array();
		$postos = Cad_posto::all()->sortBy('ordem');
		$totalData = Cad_posto::count();
		$totalFiltered = $totalData;

		if (!empty($postos)) {
			foreach ($postos as $value) {
				$nestedData['letra'] = $value->letra;
				$nestedData['tipo'] = $value->tipo;
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
