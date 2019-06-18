<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;

use App\Model\Sys\Cad_om;
use App\Model\Sys\Cad_militar;

class OmController extends Controller
{
	public function create()
	{
		return view('sys.configuracoes.om.cadastro');
	}

	public function lista()
	{
		return view('sys.configuracoes.om.listagem');
	}

	public function show($id)
	{
		$om  = Cad_om::findOrFail($id);
		return view('sys.configuracoes.om.editar', compact('om'));
	}

	public function store(Request $request)
	{
		$dados 	= $request->all();
		$regras = [
			'nome_om' => 'required',
			'nome_abreviado' => 'required',
			'codom' => 'required',
			'cep' => 'required',
			'estado' => 'required',
			'cidade' => 'required',
			'bairro' => 'required',
			'endereco' => 'required',
			'numero' => 'required',
			'datafile' => 'required|max:6000|image|mimes:jpeg,png'
		]; 
		$validacao = Validator::make($dados, $regras);
		if($validacao->fails()){
			return back()->with('error', $validacao->errors()->first());
		}

		$crtl = Cad_om::where('codom', '=', $dados['codom'])->exists();
		if($crtl){
			return back()->with('error', 'OM já cadastrada!');
		}

		if ($request->hasFile('datafile') && $request->file('datafile')->isValid()){
			$imagem = $request->file('datafile');
			$nome_foto = md5(rand(0, 999)).".".$imagem->extension();
		}

		try{
			$om = new Cad_om;
			$om->nome = trim($dados['nome_om']);
			$om->descricao = trim($dados['nome_abreviado']);
			$om->codom = $dados['codom'];
			$om->cep = $dados['cep'];
			$om->estado = $dados['estado'];
			$om->cidade = $dados['cidade'];
			$om->bairro = $dados['bairro'];
			$om->endereco = $dados['endereco'];
			$om->numero = $dados['numero'];
			$om->datafile = $nome_foto;
			$om->save();

			$dir = $om->id."/CODOM_".$dados['codom'];

			$militar = new Cad_militar;
			$militar->nome = trim($dados['nome_om']);
			$militar->nome_guerra = "VIATURA MILITAR";
			$militar->ident_militar = $dados['codom'];
			$militar->cep = $dados['cep'];
			$militar->estado = $dados['estado'];
			$militar->cidade = $dados['cidade'];
			$militar->bairro = $dados['bairro'];
			$militar->endereco = $dados['endereco'];
			$militar->numero = $dados['numero'];
			$militar->om_id = $om->id;
			$militar->posto = 34;
			$militar->datafile = $dir."/".$nome_foto;
			$militar->status = 1;
			$militar->save();

			$upload = Storage::disk('_DOC')->putFileAs($dir, $imagem, $nome_foto);
			return redirect()->route('sys.configuracoes.om.editar',$om->id)->with('success', 'Cadastro realizado com sucesso!');

		}catch(QueryException $e) {
			return back()->with('error', $e);
		}
	}

	public function update(Request $request)
	{
		$om = Cad_om::findOrFail($request->id);
		$dados = $request->all();
		$regras = [
			'nome_om' => 'required',
			'nome_abreviado' => 'required',
			'codom' => 'required',
			'cep' => 'required',
			'estado' => 'required',
			'cidade' => 'required',
			'bairro' => 'required',
			'endereco' => 'required',
			'numero' => 'required'
		]; 
		$validacao = Validator::make($dados, $regras);
		if($validacao->fails()){
			return back()->with('error', $validacao->errors()->first());
		}

		$novoDir = $om->id."/CODOM_".$dados['codom'];
		$antigoDir = $om->id."/CODOM_".$om->codom;

		if ($request->hasFile('datafile') && $request->file('datafile')->isValid()) {
			$imagem = $request->file('datafile');
			Storage::disk('_DOC')->delete($antigoDir."/".$om->datafile);
			$nome_foto = md5(rand(0, 999)).".".$imagem->extension();
			$om->datafile = $nome_foto;
			$upload = Storage::disk('_DOC')->putFileAs($antigoDir, $imagem, $nome_foto);
		}

		try{
			$om->nome = trim($dados['nome_om']);
			$om->descricao = trim($dados['nome_abreviado']);
			$om->codom = $dados['codom'];
			$om->cep = $dados['cep'];
			$om->estado = $dados['estado'];
			$om->cidade = $dados['cidade'];
			$om->bairro = $dados['bairro'];
			$om->endereco = $dados['endereco'];
			$om->numero = $dados['numero'];
			$om->save();

			$usuario_vtr = Cad_militar::where('om_id', '=', $om->id)
			->where('posto', '=', 34)
			->update([
				'nome' => trim($dados['nome_abreviado']),
				'nome_guerra' => "VIATURA MILITAR", 
				'ident_militar' => $dados['codom'], 
				'cep' => $dados['cep'], 
				'estado' => $dados['estado'], 
				'cidade' => $dados['cidade'], 
				'bairro' => $dados['bairro'],
				'endereco' => $dados['endereco'],
				'numero' => $dados['numero'],
				'datafile' => $novoDir."/".$om->datafile
			]);
		}catch(QueryException $e){
			if($e->errorInfo[1] == 1062) {
				return back()->with('error', 'CODOM já cadastrado!');
			}else {
				return back()->with('error', $e);
			}
		}
		if($novoDir != $antigoDir){
			Storage::disk('_DOC')->move($antigoDir, $novoDir);
		}
		return redirect()->route('sys.configuracoes.om.editar',$om->id)->with('success', 'Cadastro editado com sucesso!');
	}

	public function OMsListagem(Request $request){
		$om = Cad_om::all();
		$totalData = Cad_om::count();
		$totalFiltered = $totalData; 

		if(!empty($om)){
			foreach ($om as $value)
			{
				$editar =  route('sys.configuracoes.om.editar',$value->id);
				$nestedData['id'] = $value->id;
				$nestedData['nome'] = $value->nome;
				$nestedData['descricao'] = $value->descricao;
				$nestedData['codom'] = $value->codom;
				$nestedData['options'] = 
				"<a title='Editar' href='{$editar}' class=\"btn btn-sm btn-primary\"><i class=\"fa fa-edit\"></i></a>";
				$data[] = $nestedData;
			}
			$json_data = array(
				"draw"            => intval($request->input('draw')),  
				"recordsTotal"    => intval($totalData),  
				"recordsFiltered" => intval($totalFiltered), 
				"data"            => $data   
			);
			echo json_encode($json_data); 
		}
	}
}
