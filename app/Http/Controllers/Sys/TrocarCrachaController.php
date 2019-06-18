<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrocarCrachaController extends Controller
{
    	public function index()
	{
		return view('sys.configuracoes.trocarCracha');
	}
}
