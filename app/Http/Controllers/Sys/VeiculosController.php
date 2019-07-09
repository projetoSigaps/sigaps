<?php

namespace App\Model\Sys;

namespace App\Http\Controllers\Sys;

/* Vendors Laravel */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use DB;

/* Models SIGAPS */
use App\Model\Sys\Cad_tipo_automovel;
use App\Model\Sys\Cad_automovel;
use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_operacao;
use App\Model\Sys\Cad_logs;


class VeiculosController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | VIEWS 
    |--------------------------------------------------------------------------
    | Retornam as páginas referente ao CRUD do VEICULO 
    | HTML disponível em resources/views/sys/veiculos
	*/

	public function index()
	{
		/* Listagem de Veiculos */
		$this->authorize('veiculos_list', Cad_automovel::class);
		return view('sys.veiculos.listagem');
	}

	public function create()
	{
		/* Cadastro de Veiculos */
		$this->authorize('veiculos_add', Cad_automovel::class);
		$tp_veiculo = Cad_tipo_automovel::where('id', '!=', 3)->orderBy('nome')->get();
		return view('sys.veiculos.cadastro', compact('tp_veiculo'));
	}

	public function show($id)
	{
		/* Editar dados do Veículo */
		$veiculo = Cad_automovel::findOrFail($id);
		$militar = Cad_militar::select(
			'cad_militar.nome',
			'cad_militar.nome_guerra',
			'cad_militar.ident_militar',
			'cad_militar.cnh',
			'cad_militar.cnh_cat',
			'cad_militar.cnh_venc',
			'cad_militar.om_id',
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
			->where('cad_militar.id', '=', $veiculo->militar_id)
			->first();

		$this->authorize('militares_edit', $militar);
		$log = DB::table('cad_logs')
			->select('users.name', 'cad_logs.data_hora', 'cad_operacao.descricao', 'cad_operacao.evento')
			->join('users', 'cad_logs.id_operador', '=', 'users.id')
			->join('cad_automovel', 'cad_logs.id_veiculo', '=', 'cad_automovel.id')
			->join('cad_operacao', 'cad_logs.id_operacao', '=', 'cad_operacao.id')
			->where('cad_automovel.id', '=', $id)
			->orderBy('cad_logs.id', 'desc')
			->get();
		$evento  = Cad_operacao::all();
		$tp_veiculo = Cad_tipo_automovel::all();
		$marca = DB::table('cad_marca')->where('tipo_id', '=', $veiculo->tipo_id)->get();
		$modelo = DB::table('cad_modelo')->where('marca_id', '=', $veiculo->marca_id)->get();
		return view('sys.veiculos.editar', compact('evento', 'log', 'militar', 'veiculo', 'tp_veiculo', 'marca', 'modelo'));
	}

	/*
    |--------------------------------------------------------------------------
    | OPERAÇÕES 
    |--------------------------------------------------------------------------
    | Manipula o evento da interface do usuário, como por exemplo o próprio CRUD
    */

	public function criar_log($id_operacao, $id_militar, $id_veiculo, $id_operador, $endereco_ip)
	/* Para cada operação, é criado um registro de log no Banco de Dados */
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

	public function update(Request $request, $id)
	/* Atualiza os dados do Automovel no Banco de Dados */
	{
		$veiculo = Cad_automovel::findOrFail($id);
		$dados 	= $request->all();
		$regras = [
			'tipo_id' => 'required',
			'marca_id' => 'required',
			'modelo_id' => 'required',
			'placa' => 'required',
			'renavan' => 'required|max:13',
			'cor' => 'required',
			'doc_venc' => 'required',
			'origem' => 'required',
			'ano_auto' => 'required|max:4'
		];

		$crtl = Cad_automovel::where('placa', '=', $request->placa)
			->where('baixa', '=', 0)
			->where('id', '<>', $id)
			->exists();
		if ($crtl) {
			return back()->with('error', 'Já existe algum veículo ativo com esta placa!');
		}

		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		try {
			$veiculo->modelo_id = $dados['modelo_id'];
			$veiculo->marca_id = $dados['marca_id'];
			$veiculo->tipo_id = $dados['tipo_id'];
			$veiculo->placa = $dados['placa'];
			$veiculo->renavan = $dados['renavan'];
			$veiculo->cor = $dados['cor'];
			$veiculo->doc_venc = date('Y-m-d', strtotime(str_replace('/', '-', $dados['doc_venc'])));
			$veiculo->origem = $dados['origem'];
			$veiculo->ano_auto = $dados['ano_auto'];
			$veiculo->save();
			$this->criar_log(5, NULL, $veiculo->id, Auth::user()->id, $request->getClientIp());
			return redirect()->route('sys.veiculos.cadastro.editar', $veiculo->id)->with('success', 'Veículo atualizado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
	}

	public function store(Request $request)
	/* Cria um novo Automovel no Banco de Dados */
	{
		$dados 	= $request->all();
		$regras = [
			'militar_id' => 'required',
			'tipo_id' => 'required',
			'marca_id' => 'required',
			'modelo_id' => 'required',
			'placa' => 'required',
			'renavan' => 'required|max:13',
			'cor' => 'required',
			'doc_venc' => 'required',
			'origem' => 'required',
			'ano_auto' => 'required|max:4'
		];

		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		$crtl = Cad_automovel::where('placa', '=', $request->placa)
			->where('baixa', '=', 0)
			->exists();
		if ($crtl) {
			return back()->with('error', 'Este veículo já possui cadastro ATIVO!');
		}

		try {
			$veiculo = new Cad_automovel;
			$veiculo->militar_id = $dados['militar_id'];
			$veiculo->modelo_id = $dados['modelo_id'];
			$veiculo->marca_id = $dados['marca_id'];
			$veiculo->tipo_id = $dados['tipo_id'];
			$veiculo->placa = $dados['placa'];
			$veiculo->renavan = $dados['renavan'];
			$veiculo->cor = $dados['cor'];
			$veiculo->doc_venc = date('Y-m-d', strtotime(str_replace('/', '-', $dados['doc_venc'])));
			$veiculo->origem = $dados['origem'];
			$veiculo->ano_auto = $dados['ano_auto'];
			$veiculo->baixa = 0;
			$veiculo->save();
			$this->criar_log(2, NULL, $veiculo->id, Auth::user()->id, $request->getClientIp());
			return redirect()->route('sys.veiculos.cadastro.editar', $veiculo->id)->with('success', 'Cadastro realizado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
	}

	public function disabled(Request $request, $id)
	/* Desativa o Cadastro do Veiculo */
	{
		$veiculo = Cad_automovel::findOrFail($id);
		$dados 	= $request->all();
		$regras = [
			'motivo-dtv' => 'required'
		];

		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		$veiculo->baixa = 1;
		$veiculo->save();
		$this->criar_log($dados['motivo-dtv'], NULL, $veiculo->id, Auth::user()->id, $request->getClientIp());
		return redirect()->route('sys.veiculos.cadastro.editar', $veiculo->id)->with('success', 'Desativado com sucesso!');
	}

	public function enable(Request $request, $id)
	/* Ativa o Cadastro do Veiculo */
	{
		$veiculo = Cad_automovel::findOrFail($id);
		$dados 	= $request->all();
		$regras = [
			'motivo-atv' => 'required'
		];

		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		$crtl = Cad_automovel::where('placa', '=', $veiculo->placa)
			->where('baixa', '=', 0)
			->exists();
		if ($crtl) {
			return back()->with('error', 'Já existe algum veículo ativo com esta placa!');
		}

		$veiculo->baixa = 0;
		$veiculo->save();
		$this->criar_log($dados['motivo-atv'], NULL, $veiculo->id, Auth::user()->id, $request->getClientIp());
		return redirect()->route('sys.veiculos.cadastro.editar', $veiculo->id)->with('success', 'Ativado com sucesso!');
	}
}
