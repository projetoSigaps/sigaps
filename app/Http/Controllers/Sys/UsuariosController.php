<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

use App\User;
use App\Model\Sys\Cad_om;


class UsuariosController extends Controller
{

	public function lista()
	{
		return view('sys.configuracoes.usuarios.listagem');
	}

	public function create()
	{

		$roles  = Role::get();
		$om 	 = Cad_om::all();
		return view('sys.configuracoes.usuarios.cadastro', compact('roles', 'om'));
	}

	public function show($id)
	{
		$usuario = User::findOrFail($id);
		$roles 	 = Role::get();
		$om 	 = Cad_om::all();
		return view('sys.configuracoes.usuarios.editar', compact('roles', 'om', 'usuario'));
	}


	public function store(Request $request)
	{
		$dados 	= $request->all();
		$regras = [
			'nome_usuario' => 'required',
			'login_usuario' => 'required',
			'email' => 'required',
			'om_id' => 'required',
			'perfil_id' => 'required',
		];
		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		try {
			$usuario = new User;
			$usuario->name = trim($dados['nome_usuario']);
			$usuario->login = trim($dados['login_usuario']);
			$usuario->email = trim($dados['email']);
			$usuario->om_id = trim($dados['om_id']);
			$usuario->password = bcrypt($dados['login_usuario']);
			$usuario->created_at = Carbon::now()->format('Y-m-d H:i:s');
			$usuario->save();

			$roles = $dados['perfil_id'];
			if (isset($roles)) {
				$role_r = Role::where('id', '=', $roles)->firstOrFail();
				$usuario->assignRole($role_r);
			}
			return redirect()->route('sys.configuracoes.usuarios.editar', $usuario->id)->with('success', 'Cadastro realizado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', $e);
		}
	}


	public function update(Request $request, $id)
	{

		$usuario = User::findOrFail($id);
		$dados 	= $request->all();
		$regras = [
			'nome_usuario' => 'required',
			'email' => 'required',
			'om_id' => 'required',
			'perfil_id' => 'required',
		];
		$validacao = Validator::make($dados, $regras);
		if ($validacao->fails()) {
			return back()->with('error', $validacao->errors()->first());
		}

		try {

			$usuario->name = trim($dados['nome_usuario']);
			$usuario->email = trim($dados['email']);
			$usuario->om_id = trim($dados['om_id']);
			$usuario->save();

			$roles = $dados['perfil_id'];
			if (isset($roles)) {
				$usuario->removeRole($usuario->roles->first());
				$role_r = Role::where('id', '=', $roles)->firstOrFail();
				$usuario->assignRole($role_r);
			}
			return redirect()->route('sys.configuracoes.usuarios.atualizar', $usuario->id)->with('success', 'Cadastro editado com sucesso!');
		} catch (QueryException $e) {
			return back()->with('error', $e);
		}
	}

	public function UsuariosListagem(Request $request)
	{
		$usuarios = User::select('users.*', 'cad_om.nome as om_nome')->join('cad_om', 'users.om_id', '=', 'cad_om.id')->get();
		$totalData = User::count();
		$totalFiltered = $totalData;

		if (!empty($usuarios)) {
			foreach ($usuarios as $value) {
				$editar =  route('sys.configuracoes.usuarios.editar', $value->id);
				$nestedData['id'] = $value->id;
				$nestedData['nome'] = $value->name;
				$nestedData['login'] = $value->login;
				$nestedData['om_nome'] = $value->om_nome;
				$nestedData['perfil'] = "<span class=\"label label-warning\">{$value->roles()->pluck('name')->implode(' ')}</span>";
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
