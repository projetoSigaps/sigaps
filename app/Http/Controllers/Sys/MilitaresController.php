<?php

namespace App\Model\Sys;
namespace App\Http\Controllers\Sys;

/* Vendors Laravel */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use DB;
use PDF;

/* Models SIGAPS */
use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_automovel;
use App\Model\Sys\Cad_om;
use App\Model\Sys\Cad_posto;
use App\Model\Sys\Cad_logs;
use App\Model\Sys\Cad_operacao;


class MilitaresController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | VIEWS 
    |--------------------------------------------------------------------------
    | Retornam as páginas referente ao CRUD do MILITAR 
    | HTML disponível em resources/views/sys/militares
    */

	public function index()
	/* Listagem de Militares */
	{
		$this->authorize('list', Cad_militar::class);
		return view('sys.militares.listagem');
	}

	public function create()
	/* Cadastro de Militares */
	{
		$this->authorize('create', Cad_militar::class);
		if (!Auth::user()->hasRole('super-admin')) {
			$om = Cad_om::where('id', Auth::user()->om_id)->get();
		} else {
			$om = Cad_om::all();
		}

		$posto = Cad_posto::selectRaw('LPAD(ordem,2,0) as ordem, nome, tipo, id')->where('id', '!=', 34)->orderBy('ordem')->get();
		return view('sys.militares.cadastro', compact('om', 'posto'));
	}

	public function show($id)
	/* Editar dados do militar */
	{
		$militar = Cad_militar::findOrFail($id);
		$this->authorize('edit', $militar);

		if (!Auth::user()->hasRole('super-admin')) {
			$om = Cad_om::where('id', Auth::user()->om_id)->get();
		} else {
			$om = Cad_om::all();
		}

		$log = DB::table('cad_logs')
			->select('users.name', 'cad_logs.data_hora', 'cad_operacao.descricao', 'cad_operacao.evento')
			->join('users', 'cad_logs.id_operador', '=', 'users.id')
			->join('cad_militar', 'cad_logs.id_militar', '=', 'cad_militar.id')
			->join('cad_operacao', 'cad_logs.id_operacao', '=', 'cad_operacao.id')
			->where('cad_militar.id', '=', $id)
			->orderBy('cad_logs.id', 'desc')
			->get();
		$evento  = Cad_operacao::all();
		$posto	 = Cad_posto::selectRaw('LPAD(ordem,2,0) as ordem, nome, tipo, id')->where('id', '!=', 34)->orderBy('ordem')->get();
		return view('sys.militares.editar', compact('militar', 'om', 'posto', 'log', 'evento'));
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

	public function store(Request $request)
	/* Cria um novo Militar no Banco de Dados */
	{
		$dados 	= $request->all();
		$regras = [
			'nome' => 'required|max:255',
			'nome_guerra' => 'required|max:255',
			'ident_militar' => 'required',
			'om_id' => 'required|integer',
			'posto' => 'required|integer',
			'cep' => 'required',
			'datafile' => 'required|max:6000|image|mimes:jpeg,png'
		];

		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		$crtl = Cad_militar::where('ident_militar', '=', $dados['ident_militar'])->exists();
		if ($crtl) {
			return back()->with('error', 'Número de identidade já cadastrada!');
		}

		if ($request->hasFile('datafile') && $request->file('datafile')->isValid()) {
			$imagem = $request->file('datafile');
			$dir = $dados['om_id'] . "/" . $dados['posto'] . "/" . $dados['ident_militar'];
			$nome_foto = md5(rand(0, 999)) . "." . $imagem->extension();
			$upload = Storage::disk('_DOC')->putFileAs($dir, $imagem, $nome_foto);
			if (!$upload) {
				return back()->with('error', 'Falha ao enviar a foto!');
			}
		}

		if ($dados['cnh_venc']) {
			$dados['cnh_venc'] = date('Y-m-d', strtotime(str_replace('/', '-', $dados['cnh_venc'])));
		}

		try {
			$militar = new Cad_militar;
			$militar->nome = trim($dados['nome']);
			$militar->nome_guerra = trim($dados['nome_guerra']);
			$militar->ident_militar = $dados['ident_militar'];
			$militar->cep = $dados['cep'];
			$militar->estado = $dados['estado'];
			$militar->cidade = $dados['cidade'];
			$militar->bairro = $dados['bairro'];
			$militar->endereco = $dados['endereco'];
			$militar->celular = $dados['celular'];
			$militar->numero = $dados['numero'];
			$militar->celular = $dados['celular'];
			$militar->cnh = $dados['cnh'];
			$militar->cnh_cat = $dados['cnh_cat'];
			$militar->cnh_venc = $dados['cnh_venc'];
			$militar->om_id = $dados['om_id'];
			$militar->posto = $dados['posto'];
			$militar->datafile = $nome_foto;
			$militar->status = 1;
			$militar->save();
			$this->criar_log(1, $militar->id, NULL, Auth::user()->id, $request->getClientIp());
			return redirect()->route('sys.militares.cadastro.editar', $militar->id)->with('success', 'Cadastro realizado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', "ERROR: " . $e->errorInfo[2]);
		}
	}

	public function update(Request $request, $id)
	/* Atualiza os dados do Militar no Banco de Dados */
	{
		$militar = Cad_militar::findOrFail($id);
		$dados 	= $request->all();
		$regras = [
			'nome' => 'required|max:255',
			'nome_guerra' => 'required|max:255',
			'ident_militar' => 'required',
			'om_id' => 'required|integer',
			'posto' => 'required|integer',
			'cep' => 'required',
		];

		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		$novoDir = $dados['om_id'] . "/" . $dados['posto'] . "/" . $dados['ident_militar'];
		$antigoDir = $militar->om_id . "/" . $militar->posto . "/" . $militar->ident_militar;

		if ($request->hasFile('datafile') && $request->file('datafile')->isValid()) {
			$imagem = $request->file('datafile');
			Storage::disk('_DOC')->delete($novoDir . "/" . $militar->datafile);
			$nome_foto = md5(rand(0, 999)) . "." . $imagem->extension();
			$militar->datafile = $nome_foto;
			$upload = Storage::disk('_DOC')->putFileAs($novoDir, $imagem, $nome_foto);
			if (!$upload) {
				return redirect()->back()->with('error', 'Falha ao enviar a foto!')->withInput();
			}
		}

		if ($dados['cnh_venc']) {
			$dados['cnh_venc'] = date('Y-m-d', strtotime(str_replace('/', '-', $dados['cnh_venc'])));
		}

		try {
			$militar->nome = trim($dados['nome']);
			$militar->nome_guerra = trim($dados['nome_guerra']);
			$militar->ident_militar = $dados['ident_militar'];
			$militar->cep = $dados['cep'];
			$militar->estado = $dados['estado'];
			$militar->cidade = $dados['cidade'];
			$militar->bairro = $dados['bairro'];
			$militar->endereco = $dados['endereco'];
			$militar->celular = $dados['celular'];
			$militar->numero = $dados['numero'];
			$militar->cnh = $dados['cnh'];
			$militar->cnh_cat = $dados['cnh_cat'];
			$militar->cnh_venc = $dados['cnh_venc'];
			$militar->om_id = $dados['om_id'];
			$militar->posto = $dados['posto'];
			$militar->save();
			$this->criar_log(4, $militar->id, NULL, Auth::user()->id, $request->getClientIp());
		} catch (QueryException $e) {
			if ($e->errorInfo[1] == 1062) {
				return back()->with('error', 'Número de identidade ja cadastrada!');
			} else {
				return back()->with('error', "ERROR: " . $e->errorInfo[2]);
			}
		}
		if ($novoDir != $antigoDir) {
			Storage::disk('_DOC')->move($antigoDir, $novoDir);
		}
		return redirect()->route('sys.militares.cadastro.editar', $militar->id)->with('success', 'Cadastro editado com sucesso!');
	}

	public function enable(Request $request, $id)
	/* Ativa o Cadastro do Militar */
	{
		$militar = Cad_militar::findOrFail($id);
		$dados 	= $request->all();
		$regras = [
			'motivo-atv' => 'required'
		];

		$validacao = Validator::make($dados, $regras);

		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		$militar->status = 1;
		$militar->save();
		$this->criar_log($dados['motivo-atv'], $militar->id, 0, Auth::user()->id, $request->getClientIp());
		return redirect()->route('sys.militares.cadastro.editar', $militar->id)->with('success', 'Ativado com sucesso!');
	}

	public function disable(Request $request, $id)
	/* Desativa o cadastro do Militar. ATENÇÃO que na hora da desativação, ele desativa os automovéis vinculado ao militar */
	{
		$militar = Cad_militar::findOrFail($id);
		$veiculo = Cad_automovel::where("militar_id", "=", $id)->get();
		$dados 	= $request->all();
		$regras = [
			'motivo-dtv' => 'required'
		];

		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		$militar->status = 2;
		$militar->save();

		/* Desativa AQUI os automovéis */
		foreach ($veiculo as $key => $value) {
			$veiculo[$key]->baixa = 1;
			$veiculo[$key]->save();
			$this->criar_log($dados['motivo-dtv'], 0, $veiculo[$key]->id, Auth::user()->id, $request->getClientIp());
		}

		$this->criar_log($dados['motivo-dtv'], $militar->id, 0, Auth::user()->id, $request->getClientIp());
		return redirect()->route('sys.militares.cadastro.editar', $militar->id)->with('success', 'Desativado com sucesso!');
	}

	public function downloadPDF($id)
	/* Gera um PDF com os dados cadastrais do Militar */
	{
		$militar = Cad_militar::select(
			'cad_militar.*',
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
			->where('cad_militar.id', '=', $id)
			->first();
		$auto = DB::table('cad_automovel')
			->select(
				'cad_automovel.*',
				'cad_modelo.nome as modelo',
				'cad_marca.nome as marca'
			)
			->join(
				'cad_modelo',
				'cad_automovel.modelo_id',
				'=',
				'cad_modelo.id'
			)
			->join(
				'cad_marca',
				'cad_automovel.marca_id',
				'=',
				'cad_marca.id'
			)
			->where('cad_automovel.militar_id', '=', $id)
			->get();

		$this->authorize('downloadPdf', $militar);
		$pdf = PDF::loadView('sys/militares/pdf', compact('militar', 'auto'));
		return $pdf->download(trim($militar->nome) . '.pdf');
	}
}
