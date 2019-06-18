<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Model\Sys\Cad_automovel;
use App\Model\Sys\Cad_tipo_automovel;
use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_viaturas;
use App\Model\Sys\Cad_modelo;
use App\Model\Sys\Cad_marca;
use App\Model\Sys\Cad_om;
use App\Model\Sys\Cad_logs;
use DB;

class ViaturasController extends Controller
{
	public function create()
	{
		$om = Cad_om::all();
		return view('sys.configuracoes.viaturas.cadastro', compact('om'));
	}

	public function lista()
	{
		return view('sys.configuracoes.viaturas.listagem');
	}

	public function show($id)
	{
		$viatura = Cad_automovel::findOrFail($id);
		$vtr = Cad_viaturas::where('automovel_id', $viatura->id)->first();
		$usuario_vtr = Cad_militar::where('id', $viatura->militar_id)->first();
		$om = Cad_om::where('id', $usuario_vtr->om_id)->first();

		$tp_veiculo = Cad_tipo_automovel::where('id', 3)->first();
		$marca = DB::table('cad_marca')->where('tipo_id', $viatura->tipo_id)->get();
		$modelo = DB::table('cad_modelo')->where('marca_id', $viatura->marca_id)->get();
		return view('sys.configuracoes.viaturas.editar', compact('om','vtr','viatura','tp_veiculo','marca','modelo'));
	}

	public function criar_log($id_operacao,$id_militar,$id_veiculo, $id_operador, $endereco_ip){
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
	{
		$dados 	= $request->all();
		$regras = [
			'om_id' => 'required',
			'tipo_id' => 'required',
			'marca_id' => 'required',
			'modelo_id' => 'required',
			'placa' => 'required',
			'renavam' => 'required',
			'cor' => 'required',
			'doc_venc' => 'required',
			'vtr_cmt' => 'required',
			'categoria' => 'required',
			'ano_auto' => 'required'
		]; 

		$validacao = Validator::make($dados, $regras);
		if($validacao->fails()){
			return back()->with('error', $validacao->errors()->first());
		} 

		$crtl = Cad_automovel::where('placa', '=', $request->placa)
		->orWhere('renavan', '=', $request->renavam)
		->exists();

		if($crtl){
			return back()->with('error', 'Esta viatura já possui cadastro!');
		}

		try{
			$usuario_vtr = Cad_militar::where('om_id',$dados['om_id'])->where('posto', 34)->first();

			$veiculo = new Cad_automovel;
			$veiculo->militar_id = $usuario_vtr->id;
			$veiculo->modelo_id = $dados['modelo_id'];
			$veiculo->marca_id = $dados['marca_id'];
			$veiculo->tipo_id = $dados['tipo_id'];
			$veiculo->placa = $dados['placa'];
			$veiculo->renavan = $dados['renavam'];
			$veiculo->cor = $dados['cor'];
			$veiculo->origem = "BRASIL";
			$veiculo->doc_venc = date('Y-m-d', strtotime(str_replace('/', '-',$dados['doc_venc'])));
			$veiculo->ano_auto = $dados['ano_auto'];
			$veiculo->baixa = 0;
			$veiculo->save();	

			$viatura = new Cad_viaturas;
			$viatura->vtr_cmt = $dados['vtr_cmt'];
			$viatura->cat = $dados['categoria'];
			$viatura->automovel_id = $veiculo->id;
			$viatura->save();	
			$this->criar_log(3,0,$veiculo->id,Auth::user()->id, $request->getClientIp());
			return redirect()->route('sys.configuracoes.viaturas.editar',$viatura->id)->with('success', 'Cadastro realizado com sucesso!');
		}catch(QueryException $e) {
			return back()->with('error', $e);
		}
	}


	public function update(Request $request, $id)
	{
		$veiculo = Cad_automovel::findOrFail($id);
		$dados 	= $request->all();
		$regras = [
			'om_id' => 'required',
			'tipo_id' => 'required',
			'marca_id' => 'required',
			'modelo_id' => 'required',
			'placa' => 'required',
			'renavam' => 'required',
			'cor' => 'required',
			'doc_venc' => 'required',
			'vtr_cmt' => 'required',
			'categoria' => 'required',
			'ano_auto' => 'required'
		];

		$validacao = Validator::make($dados, $regras);   
		if($validacao->fails()){
			return back()->with('error', $validacao->errors()->first());
		} 

		try{
			$veiculo->modelo_id = $dados['modelo_id'];
			$veiculo->marca_id = $dados['marca_id'];
			$veiculo->tipo_id = $dados['tipo_id'];
			$veiculo->placa = $dados['placa'];
			$veiculo->renavan = $dados['renavam'];
			$veiculo->cor = $dados['cor'];
			$veiculo->doc_venc = date('Y-m-d', strtotime(str_replace('/', '-',$dados['doc_venc'])));
			$veiculo->ano_auto = $dados['ano_auto'];
			$veiculo->save();

			$viatura = Cad_viaturas::where('automovel_id', $id)->update(['vtr_cmt' => $dados['vtr_cmt'], 'cat' => $dados['categoria']]);

			$this->criar_log(6,0,$veiculo->id,Auth::user()->id, $request->getClientIp());
			return redirect()->route('sys.configuracoes.viaturas.editar',$veiculo->id)->with('success', 'Viatura atualizada com sucesso!');
			
		}catch(QueryException $e) {
			if($e->errorInfo[1] == 1062) {
				return back()->with('error', 'Número da Placa ou Renavam já cadastrado!');
			} else {
				return back()->with('error', $e);
			}
		}
	}

	public function disabled(Request $request, $id)
	{
		$viatura = Cad_automovel::findOrFail($id);
		$viatura->baixa = 1;
		$viatura->save();
		$this->criar_log(18,0,$veiculo->id,Auth::user()->id, $request->getClientIp());
		return redirect()->route('sys.configuracoes.viaturas.editar',$viatura->id)->with('success', 'Desativado com sucesso!');
	}

	public function enable(Request $request, $id)
	{
		$viatura = Cad_automovel::findOrFail($id);
		$viatura->baixa = 0;
		$viatura->save();
		$this->criar_log(28,0,$veiculo->id,Auth::user()->id, $request->getClientIp());
		return redirect()->route('sys.configuracoes.viaturas.editar',$viatura->id)->with('success', 'Ativado com sucesso!');
	}
}
