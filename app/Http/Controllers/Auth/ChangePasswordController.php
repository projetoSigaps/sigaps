<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Auth;
use \App\User;

class ChangePasswordController extends Controller
{
	public function changePassword(Request $request)
	{

		$dados 	= $request->all();
		$regras = [
			'password_new' => 'required|regex:/(?!^\d+$)^.+$/i',
			'password_confirmation' => 'required|regex:/(?!^\d+$)^.+$/i',
			'email' => 'required|email'
		];

		$validacao = Validator::make($dados, $regras); 
		$usr = User::where('email', '=', strtolower($dados['email']))->exists();
		
		if($validacao->fails()){
			return back()->with('error', $validacao->errors()->first());
		}

		if($dados['password_new'] != $dados['password_confirmation']){
			return back()->with('error', 'As senhas não coincidem.');
		}

		if(Auth::user()->login == $dados['password_new']){
			return back()->with('error', 'A senha não pode ser igual ao login!');
		}

		if(!$usr){
			return back()->with('error', 'E-mail incorreto!');
		}

		try{
			$usuario =  User::where('id', Auth::id())->update(['password' => bcrypt($dados['password_new']), 'password_changed_at' => Carbon::now()->format('Y-m-d H:i:s')]);
			return redirect('/home')->with('success', 'Senha alterada com sucesso!');
		}catch(QueryException $e) {
			return back()->with('error', $e);
		}
	}
}
