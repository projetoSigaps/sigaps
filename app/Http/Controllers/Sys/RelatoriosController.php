<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Model\Sys\Cad_om;
use App\Model\Sys\Cad_posto;
use App\Model\Sys\Cad_tipo_automovel;
use DB;


class RelatoriosController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | VIEWS 
    |--------------------------------------------------------------------------
    | Retorna as páginas para gerar os relatórios
    | HTML disponível em resources/views/sys/relatorios/
	*/

	public function horarios()
	/* Retorna tela para gerar relátorio de horarios entrada e saída */
	{
		if (!Auth::user()->can('relatorios-hrs')) {
			return response()->json([
				'Error' => '403, Forbidden',
				'Exception' => strtoupper(substr(md5(rand()), 0, 20)),
				'Descrição' => 'Você não tem autorização para visualizar este conteúdo!',
			], 403);
		}

		if (!Auth::user()->hasRole('super-admin')) {
			$om = Cad_om::where('id', Auth::user()->om_id)->get();
		} else {
			$om = Cad_om::all();
		}

		$posto	 = Cad_posto::selectRaw('LPAD(ordem,2,0) as ordem, nome, tipo, id')->where('id', '!=', 34)->orderBy('ordem')->get();
		return view('sys.relatorios.horarios', compact('om', 'posto'));
	}

	public function automoveis()
	/* Retorna tela para gerar relátorio de automóveis */
	{
		if (!Auth::user()->can('relatorios-aut')) {
			return response()->json([
				'Error' => '403, Forbidden',
				'Exception' => strtoupper(substr(md5(rand()), 0, 20)),
				'Descrição' => 'Você não tem autorização para visualizar este conteúdo!',
			], 403);
		}

		if (!Auth::user()->hasRole('super-admin')) {
			$om = Cad_om::where('id', Auth::user()->om_id)->get();
		} else {
			$om = Cad_om::all();
		}
		$tp_veiculo = Cad_tipo_automovel::all();
		$posto	 = Cad_posto::selectRaw('LPAD(ordem,2,0) as ordem, nome, tipo, id')->where('id', '!=', 34)->orderBy('ordem')->get();
		return view('sys.relatorios.automoveis', compact('tp_veiculo', 'om', 'posto'));
	}

	public function militares()
	/* Retorna tela para gerar relátorio de militares */
	{
		if (!Auth::user()->can('relatorios-mil')) {
			return response()->json([
				'Error' => '403, Forbidden',
				'Exception' => strtoupper(substr(md5(rand()), 0, 20)),
				'Descrição' => 'Você não tem autorização para visualizar este conteúdo!',
			], 403);
		}

		if (!Auth::user()->hasRole('super-admin')) {
			$om = Cad_om::where('id', Auth::user()->om_id)->get();
		} else {
			$om = Cad_om::all();
		}

		$posto	 = Cad_posto::selectRaw('LPAD(ordem,2,0) as ordem, nome, tipo, id')->where('id', '!=', 34)->orderBy('ordem')->get();
		return view('sys.relatorios.militares', compact('om', 'posto'));
	}

	/*
    |--------------------------------------------------------------------------
    | OPERAÇÕES
    |--------------------------------------------------------------------------
    | Manipula o evento da interface do usuário
	*/

	public function horariosDownloadAuto(Request $request)
	/* Manda para Download os horários dos automovéis */
	{
		$tp_relatorio = strtoupper($request->input('tpRelatorio'));

		if (!$request->input('gdh_inicio') || !$request->input('gdh_fim')) {
			return back()->with('error', 'Selecione um período de datas!');
		} else {
			$gdh_inicio = date('Y-m-d H:i', strtotime(str_replace('/', '-', $request->input('gdh_inicio'))));
			$gdh_fim = date('Y-m-d H:i', strtotime(str_replace('/', '-', $request->input('gdh_fim'))));
		}

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('components/AsCRNwCa.docx');
		$templateProcessor->setValue('data', htmlspecialchars(date('d/m/Y')));
		$templateProcessor->setValue('tipo', htmlspecialchars($tp_relatorio));

		$query =  DB::table('cad_entrada_saida')
			->select(
				'cad_militar.nome_guerra',
				'cad_posto.nome as posto_nome',
				'cad_om.nome as om_nome',
				'cad_marca.nome as marca',
				'cad_automovel.cor',
				'cad_automovel.placa',
				'cad_modelo.nome as modelo',
				'cad_entrada_saida.automovel_id as cod_cracha',
				'cad_entrada_saida.dtEntrada',
				'cad_entrada_saida.dtSaida'
			)
			->join(
				'cad_automovel',
				'cad_automovel.id',
				'=',
				'cad_entrada_saida.automovel_id'
			)
			->join(
				'cad_militar',
				'cad_automovel.militar_id',
				'=',
				'cad_militar.id'
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
			->whereBetween('cad_entrada_saida.dtEntrada', [$gdh_inicio, $gdh_fim]);

		if ($request->cod_cracha) {
			$query->where('cad_entrada_saida.automovel_id', $request->cod_cracha);
		}
		if ($request->rel_posto) {
			$query->where('cad_posto.id', $request->rel_posto);
		}
		if ($request->rel_om) {
			$query->where('cad_om.id', $request->rel_om);
		}
		if ($tp_relatorio == "VIATURA") {
			$query->where('cad_posto.id', 34);
		}

		$query = $query->orderBy("cad_entrada_saida.id", "DESC")->get();

		if ($query->isEmpty()) {
			return back()->with('error', 'Nenhum registro encontrado!');
		}

		foreach ($query as $key => $value) {

			if ($value->dtEntrada) {
				$value->dtEntrada = date('d/m/Y H:i', strtotime(str_replace('-', '/', $value->dtEntrada)));
			}
			if ($value->dtSaida) {
				$value->dtSaida = date('d/m/Y H:i', strtotime(str_replace('-', '/', $value->dtSaida)));
			}

			$key++;
			$rows_values[$key] = array(
				'ordem' => htmlspecialchars($key),
				'posto_nome' => htmlspecialchars($value->posto_nome),
				'nome_guerra' => htmlspecialchars($value->nome_guerra),
				'cod_cracha' => htmlspecialchars($value->cod_cracha),
				'marca' => htmlspecialchars($value->marca),
				'modelo' => htmlspecialchars($value->modelo),
				'placa' => htmlspecialchars($value->placa),
				'cor' => htmlspecialchars($value->cor),
				'dt_entrada' => htmlspecialchars($value->dtEntrada),
				'dt_saida' => htmlspecialchars($value->dtSaida),
				'om_nome' => htmlspecialchars($value->om_nome)
			);
		}
		$templateProcessor->cloneRow('ordem', count($query), $rows_values);
		$path = "components/tmp/";
		$tmpname = 	substr(md5(rand()), 0, 9) . ".docx";
		$templateProcessor->saveAs($path . $tmpname);
		return response()->download($path . $tmpname, $tmpname)->deleteFileAfterSend(true);
	}

	public function horariosDownloadPedestres(Request $request)
	/* Manda para Download os horários dos pedestres */
	{
		$tp_relatorio = strtoupper($request->input('tpRelatorio'));

		if (!$request->input('gdh_inicio') || !$request->input('gdh_fim')) {
			return back()->with('error', 'Selecione um período de datas!');
		} else {
			$gdh_inicio = date('Y-m-d H:i', strtotime(str_replace('/', '-', $request->input('gdh_inicio'))));
			$gdh_fim = date('Y-m-d H:i', strtotime(str_replace('/', '-', $request->input('gdh_fim'))));
		}

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('components/nJp9lZpt.docx');
		$templateProcessor->setValue('data', htmlspecialchars(date('d/m/Y')));
		$templateProcessor->setValue('tipo', htmlspecialchars($tp_relatorio));

		$query =  DB::table('cad_entrada_saida')
			->select(
				'cad_militar.nome_guerra',
				'cad_posto.nome as posto_nome',
				'cad_om.nome as om_nome',
				'cad_entrada_saida.militar_id as cod_cracha',
				'cad_entrada_saida.dtEntrada',
				'cad_entrada_saida.dtSaida'
			)
			->join(
				'cad_militar',
				'cad_entrada_saida.militar_id',
				'=',
				'cad_militar.id'
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
			->whereBetween('cad_entrada_saida.dtEntrada', [$gdh_inicio, $gdh_fim]);

		if ($request->cod_cracha) {
			$query->where('cad_entrada_saida.militar_id', $request->cod_cracha);
		}
		if ($request->rel_posto) {
			$query->where('cad_posto.id', $request->rel_posto);
		}
		if ($request->rel_om) {
			$query->where('cad_om.id', $request->rel_om);
		}

		$query = $query->orderBy("cad_entrada_saida.id", "DESC")->get();

		if ($query->isEmpty()) {
			return back()->with('error', 'Nenhum registro encontrado!');
		}

		foreach ($query as $key => $value) {

			if ($value->dtEntrada) {
				$value->dtEntrada = date('d/m/Y H:i', strtotime(str_replace('-', '/', $value->dtEntrada)));
			}
			if ($value->dtSaida) {
				$value->dtSaida = date('d/m/Y H:i', strtotime(str_replace('-', '/', $value->dtSaida)));
			}

			$key++;
			$rows_values[$key] = array(
				'ordem' => htmlspecialchars($key),
				'posto_nome' => htmlspecialchars($value->posto_nome),
				'nome_guerra' => htmlspecialchars($value->nome_guerra),
				'cod_cracha' => htmlspecialchars($value->cod_cracha),
				'dt_entrada' => htmlspecialchars($value->dtEntrada),
				'dt_saida' => htmlspecialchars($value->dtSaida),
				'om_nome' => htmlspecialchars($value->om_nome)
			);
		}
		$templateProcessor->cloneRow('ordem', count($query), $rows_values);
		$path = "components/tmp/";
		$tmpname = 	substr(md5(rand()), 0, 9) . ".docx";
		$templateProcessor->saveAs($path . $tmpname);
		return response()->download($path . $tmpname, $tmpname)->deleteFileAfterSend(true);
	}

	public function downloadMilitares(Request $request)
	/* Manda para Download os dados cadastrais dos militares */
	{
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('components/u5N2xRqf.docx');
		$templateProcessor->setValue('data', htmlspecialchars(date('d/m/Y H:i')));

		$query =  DB::table('cad_militar')
			->select(
				'cad_militar.id as cod_cracha',
				'cad_militar.status',
				'cad_militar.nome_guerra',
				'cad_militar.nome',
				'cad_militar.ident_militar',
				'cad_militar.cnh',
				'cad_militar.cnh_cat',
				'cad_militar.cnh_venc',
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
			);

		if ($request->cnh_cat) {
			$query->where('cad_militar.cnh_cat', 'LIKE', "%{$request->cnh_cat}%");
		}
		if ($request->mes_cnh && $request->ano_cnh) {
			$dt_ini = "{$request->ano_cnh}-{$request->mes_cnh}-01";
			$dt_fim = "{$request->ano_cnh}-{$request->mes_cnh}-31";
			$query->whereBetween('cad_militar.cnh_venc', [$dt_ini, $dt_fim]);
		}
		if ($request->rel_posto) {
			$query->where('cad_posto.id', $request->rel_posto);
		}
		if ($request->rel_om) {
			$query->where('cad_om.id', $request->rel_om);
		}
		if ($request->status) {
			$query->where('cad_militar.status', $request->status);
		}

		$query = $query->orderBy("cad_posto.ordem")->orderBy("cad_militar.nome_guerra")->get();

		if ($query->isEmpty()) {
			return back()->with('error', 'Nenhum registro encontrado!');
		}

		foreach ($query as $key => $value) {

			if ($value->cnh_venc) {
				$value->cnh_venc = date('d/m/Y', strtotime(str_replace('-', '/', $value->cnh_venc)));
			}

			$key++;

			if ($value->status == 1) {
				$value->status = "Ativado";
			} else $value->status = "Desativado";

			$rows_values[$key] = array(
				'ordem' => htmlspecialchars($key),
				'cod_cracha' => htmlspecialchars($value->cod_cracha),
				'posto_nome' => htmlspecialchars($value->posto_nome),
				'nome_guerra' => htmlspecialchars($value->nome_guerra),
				'nome' => htmlspecialchars($value->nome),
				'ident_militar' => htmlspecialchars($value->ident_militar),
				'status' => htmlspecialchars($value->status),
				'cnh' => htmlspecialchars($value->cnh),
				'cnh_cat' => htmlspecialchars($value->cnh_cat),
				'cnh_venc' => htmlspecialchars($value->cnh_venc),
				'om_nome' => htmlspecialchars($value->om_nome)
			);
		}
		$templateProcessor->cloneRow('ordem', count($query), $rows_values);
		$path = "components/tmp/";
		$tmpname = 	substr(md5(rand()), 0, 9) . ".docx";
		$templateProcessor->saveAs($path . $tmpname);
		return response()->download($path . $tmpname, $tmpname)->deleteFileAfterSend(true);
	}

	public function downloadAutomoveis(Request $request)
	/* Manda para Download os dados de cadastro dos automovéis */
	{
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('components/RsIKpehk.docx');
		$templateProcessor->setValue('data', htmlspecialchars(date('d/m/Y H:i')));

		$query =  DB::table('cad_automovel')
			->select(
				'cad_automovel.id as cod_cracha',
				'cad_automovel.baixa',
				'cad_automovel.ano_auto',
				'cad_automovel.renavan',
				'cad_automovel.cor',
				'cad_automovel.origem',
				'cad_automovel.placa',
				'cad_militar.nome_guerra',
				'cad_automovel.doc_venc',
				'cad_marca.nome as marca',
				'cad_modelo.nome as modelo',
				'cad_posto.nome as posto_nome',
				'cad_posto.letra as posto_letra',
				'cad_om.nome as om_nome'
			)
			->join(
				'cad_militar',
				'cad_automovel.militar_id',
				'=',
				'cad_militar.id'
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
			->join(
				'cad_marca',
				'cad_automovel.marca_id',
				'=',
				'cad_marca.id'
			)
			->join(
				'cad_modelo',
				'cad_automovel.modelo_id',
				'=',
				'cad_modelo.id'
			);

		if ($request->placa_rel) {
			$query->where('cad_automovel.placa', 'LIKE', "%{$request->placa_rel}%");
		}
		if ($request->renavam) {
			$query->where('cad_automovel.renavan', $request->renavam);
		}
		if ($request->ano) {
			$query->where('cad_automovel.ano_auto', $request->ano);
		}
		if ($request->cor) {
			$query->where('cad_automovel.cor', 'LIKE', "%{$request->cor}%");
		}
		if ($request->rel_posto) {
			$query->where('cad_posto.id', $request->rel_posto);
		}
		if ($request->rel_om) {
			$query->where('cad_om.id', $request->rel_om);
		}
		if ($request->status) {
			$query->where('cad_automovel.baixa', $request->status);
		}
		if ($request->tipo_id) {
			$query->where('cad_automovel.tipo_id', $request->tipo_id);
		}
		if ($request->marca_id) {
			$query->where('cad_automovel.marca_id', $request->marca_id);
		}
		if ($request->modelo_id) {
			$query->where('cad_automovel.modelo_id', $request->modelo_id);
		}
		if ($request->mes_doc && $request->ano_doc) {
			$dt_ini = "{$request->ano_doc}-{$request->mes_doc}-01";
			$dt_fim = "{$request->ano_doc}-{$request->mes_doc}-31";
			$query->whereBetween('cad_automovel.doc_venc', [$dt_ini, $dt_fim]);
		}

		$query = $query->orderBy("cad_posto.ordem")->orderBy("cad_militar.nome_guerra")->get();

		if ($query->isEmpty()) {
			return back()->with('error', 'Nenhum registro encontrado!');
		}

		foreach ($query as $key => $value) {
			$key++;

			if ($value->doc_venc) {
				$value->doc_venc = date('d/m/Y', strtotime(str_replace('-', '/', $value->doc_venc)));
			}

			if ($value->baixa == 0) {
				$value->baixa = "Desativado";
			} else {
				$value->baixa = "Ativado";
			}

			$rows_values[$key] = array(
				'ordem' => htmlspecialchars($key),
				'cod_cracha' => htmlspecialchars($value->posto_letra . $value->cod_cracha),
				'posto_nome' => htmlspecialchars($value->posto_nome),
				'nome_guerra' => htmlspecialchars($value->nome_guerra),
				'marca' => htmlspecialchars($value->marca),
				'modelo' => htmlspecialchars($value->modelo),
				'placa' => htmlspecialchars($value->placa),
				'cor' => htmlspecialchars($value->cor),
				'ano' => htmlspecialchars($value->ano_auto),
				'origem' => htmlspecialchars($value->origem),
				'status' => htmlspecialchars($value->baixa),
				'renavam' => htmlspecialchars($value->renavan),
				'doc_venc' => htmlspecialchars($value->doc_venc),
				'om_nome' => htmlspecialchars($value->om_nome)
			);
		}
		$templateProcessor->cloneRow('ordem', count($query), $rows_values);
		$path = "components/tmp/";
		$tmpname = 	substr(md5(rand()), 0, 9) . ".docx";
		$templateProcessor->saveAs($path . $tmpname);
		return response()->download($path . $tmpname, $tmpname)->deleteFileAfterSend(true);
	}
}
