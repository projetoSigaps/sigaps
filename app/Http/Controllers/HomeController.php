<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Sys\Cad_om;
use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_automovel;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ((Auth::user()->password_changed_at == null)) {
            return view('senha');
        }

        if (!Auth::user()->hasRole('super-admin')) {
            $total_militares = Cad_militar::where('om_id', Auth::user()->om_id)->where('posto',"!=",34)->count();
            $total_automoveis = Cad_automovel::join('cad_militar', 'cad_militar.id', '=', 'cad_automovel.militar_id')
                ->where('cad_militar.om_id', Auth::user()->om_id)->count();
        } else {
            $total_militares = Cad_militar::where('posto',"!=",34)->count();
            $total_automoveis = Cad_automovel::count();
        }

        $user = User::where('id', auth()->id())->first();
        $om = Cad_om::where('id', $user->om_id)->first();
        return view('home', compact('user', 'om', 'total_militares','total_automoveis'));
    }
}
