<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth'], 'namespace' => 'Sys'], function(){

	/*
	*
	* MILITARES 
	*
	*/

	Route::get('militares/', 'MilitaresController@index')->name('sys.militares.listagem');
	Route::get('militares/cadastro', 'MilitaresController@create')->name('sys.militares.cadastro');
	Route::get('militar/{id}', 'MilitaresController@show')->name('sys.militares.cadastro.editar');
	Route::get('militar/{id}/cracha', 'CrachaController@pedestre')->name('sys.cracha.pedestre');
	Route::get('militar/{id}/pdf','MilitaresController@downloadPDF')->name('sys.militares.pdf');
	Route::post('militar/{id}', 'MilitaresController@update')->name('sys.militares.cadastro.atualiza');
	Route::post('militar/{id}/ativar', 'MilitaresController@enable')->name('sys.militar.ativar');
	Route::post('militar/{id}/desativar', 'MilitaresController@disable')->name('sys.militar.desativar');
	Route::post('militares/cadastro/salvar', 'MilitaresController@store')->name('sys.militares.cadastro.salvar');

	/*
	*
	* VEÍCULOS 
	*
	*/

	Route::get('veiculos/', 'VeiculosController@index')->name('sys.veiculos.listagem');
	Route::get('veiculo/{id}', 'VeiculosController@show')->name('sys.veiculos.cadastro.editar');
	Route::get('veiculos/cadastro', 'VeiculosController@create')->name('sys.veiculos.cadastro');
	Route::get('veiculo/{id}/cracha', 'CrachaController@veiculo')->name('sys.cracha.veiculo');
	Route::post('veiculo/{id}/ativar', 'VeiculosController@enable')->name('sys.veiculo.ativar');
	Route::post('veiculo/{id}/desativar', 'VeiculosController@disabled')->name('sys.veiculo.desativar');
	Route::post('veiculo/{id}', 'VeiculosController@update')->name('sys.veiculos.cadastro.atualiza');
	Route::post('veiculos/cadastro/salvar', 'VeiculosController@store')->name('sys.veiculos.cadastro.salvar');

	/*
	*
	* CONSULTAS 
	*
	*/

	Route::get('consulta/pedestres', 'ConsultaController@pedestres')->name('sys.consultas.pedestre');
	Route::get('consulta/automoveis', 'ConsultaController@automoveis')->name('sys.consultas.automoveis');

	/*
	*
	* RELATÓRIOS 
	*
	*/

	Route::get('relatorios/horarios', 'RelatoriosController@horarios')->name('sys.relatorios.horarios');
	Route::get('relatorios/militares', 'RelatoriosController@militares')->name('sys.relatorios.militares');
	Route::get('relatorios/automoveis', 'RelatoriosController@automoveis')->name('sys.relatorios.automoveis');
	Route::post('relatorios/horarios/automoveis', 'RelatoriosController@horariosDownloadAuto');
	Route::post('relatorios/horarios/pedestres', 'RelatoriosController@horariosDownloadPedestres');
	Route::post('relatorios/militares', 'RelatoriosController@downloadMilitares');
	Route::post('relatorios/automoveis', 'RelatoriosController@downloadAutomoveis');

	/*
	*
	* CONFIGURAÇÕES / OM 
	*
	*/

	Route::get('configuracoes/OM','OmController@lista');
	Route::get('configuracoes/OM/cadastrar', 'OmController@create')->name('sys.configuracoes.om.cadastrar');
	Route::get('configuracoes/OM/{id}','OmController@show')->name('sys.configuracoes.om.editar');
	Route::post('configuracoes/OM/listagem','OmController@OMsListagem');
	Route::post('configuracoes/OM/cadastrar','OmController@store')->name('sys.configuracoes.om.salvar');
	Route::post('configuracoes/OM/{id}','OmController@update')->name('sys.configuracoes.om.atualizar');

	/*
	*
	* CONFIGURAÇÕES / POSTOS 
	*
	*/

	Route::get('configuracoes/postos', 'PostosController@index')->name('sys.configuracoes.postos');
	Route::post('configuracoes/postos/cadastrar','PostosController@store')->name('sys.configuracoes.postos.cadastrar');
	Route::post('configuracoes/postos/editar/{id}','PostosController@update')->name('sys.configuracoes.postos.editar');
	Route::post('configuracoes/postos/listagem','PostosController@postosListagem');

	/*
	*
	* CONFIGURAÇÕES / USUARIOS DO SISTEMA 
	*
	*/

	Route::get('configuracoes/usuarios','UsuariosController@lista');
	Route::get('configuracoes/usuarios/cadastrar','UsuariosController@create')->name('sys.configuracoes.usuarios.cadastrar');
	Route::get('configuracoes/usuarios/{id}','UsuariosController@show')->name('sys.configuracoes.usuarios.editar');
	Route::post('configuracoes/usuarios/listagem','UsuariosController@UsuariosListagem');
	Route::post('configuracoes/usuarios/cadastrar','UsuariosController@store')->name('sys.configuracoes.usuarios.salvar');
	Route::post('configuracoes/usuarios/{id}','UsuariosController@update')->name('sys.configuracoes.usuarios.atualizar');

	/*
	*
	* CONFIGURAÇÕES / VEÍCULOS / TIPO 
	*
	*/

	Route::get('configuracoes/veiculos/tipo','TipoVeiculosController@index')->name('sys.configuracoes.veiculos.tipo_veiculos');
	Route::post('configuracoes/veiculos/tipo/cadastrar','TipoVeiculosController@store')->name('sys.configuracoes.veiculos.tipo_veiculos.cadastrar');
	Route::post('configuracoes/veiculos/tipo/editar/{id}','TipoVeiculosController@update')->name('sys.configuracoes.veiculos.tipo_veiculos.editar');
	Route::post('configuracoes/veiculos/tipo/listagem','TipoVeiculosController@listagem');

	/*
	*
	* CONFIGURAÇÕES / VEÍCULOS / MARCA 
	*
	*/

	Route::get('configuracoes/veiculos/marca','MarcaVeiculosController@index')->name('sys.configuracoes.veiculos.marca_veiculos');
	Route::post('configuracoes/veiculos/marca/cadastrar','MarcaVeiculosController@store')->name('sys.configuracoes.veiculos.marca_veiculos.cadastrar');
	Route::post('configuracoes/veiculos/marca/editar/{id}','MarcaVeiculosController@update')->name('sys.configuracoes.veiculos.marca_veiculos.editar');
	Route::post('configuracoes/veiculos/marca/listagem','MarcaVeiculosController@listagem');

	/*
	*
	* CONFIGURAÇÕES / VEÍCULOS / MODELO 
	*
	*/

	Route::get('configuracoes/veiculos/modelo','ModeloVeiculosController@index')->name('sys.configuracoes.veiculos.modelo_veiculos');
	Route::post('configuracoes/veiculos/modelo/cadastrar','ModeloVeiculosController@store')->name('sys.configuracoes.veiculos.modelo_veiculos.cadastrar');
	Route::post('configuracoes/veiculos/modelo/editar/{id}','ModeloVeiculosController@update')->name('sys.configuracoes.veiculos.modelo_veiculos.editar');
	Route::post('configuracoes/veiculos/modelo/listagem','ModeloVeiculosController@listagem');

	/*
	*
	* CONFIGURAÇÕES / VIATURAS 
	*
	*/

	Route::get('configuracoes/viaturas','ViaturasController@lista');
	Route::get('configuracoes/viaturas/cadastrar','ViaturasController@create')->name('sys.configuracoes.viaturas.cadastro');
	Route::get('configuracoes/viaturas/{id}','ViaturasController@show')->name('sys.configuracoes.viaturas.editar');
	Route::get('configuracoes/viaturas/{id}/ativar', 'ViaturasController@enable')->name('sys.configuracoes.viaturas.ativar');
	Route::get('configuracoes/viaturas/{id}/desativar', 'ViaturasController@disabled')->name('sys.configuracoes.viaturas.desativar');
	Route::get('configuracoes/viaturas/{id}/cracha', 'CrachaController@viatura')->name('sys.cracha.viatura');
	Route::post('configuracoes/viaturas/cadastrar','ViaturasController@store')->name('sys.configuracoes.viaturas.salvar');
	Route::post('configuracoes/viaturas/listagem','OmController@OMsListagem');
	Route::post('configuracoes/viaturas/{id}', 'ViaturasController@update')->name('sys.configuracoes.viaturas.atualiza');

	/*
	*
	* CONFIGURAÇÕES / HORÁRIOS
	*
	*/

	Route::get('configuracoes/horarios', 'HorariosController@index')->name('sys.configuracoes.horarios');
	Route::post('configuracoes/horarios/registrar', 'HorariosController@registrar')->name('sys.configuracoes.horarios.registrar');

	/*
	*
	* CONFIGURAÇÕES / TROCAR CRACHÁ
	*
	*/

	Route::get('configuracoes/cracha/trocar', 'TrocarCrachaController@index')->name('sys.configuracoes.trocarCracha');
	

	/*
	*
	* WEBSERVICES
	*
	*/

	Route::post('webservices/validacao/identidade','WebServicesController@validacaoIdentidade');
	Route::post('webservices/validacao/placa','WebServicesController@validacaoPlaca');
	Route::post('webservices/validacao/renavam','WebServicesController@validacaoRenavam');
	Route::post('webservices/validacao/cnh','WebServicesController@validacaoCnh');
	Route::post('webservices/militares/listagem','WebServicesController@listagemMilitares');
	Route::post('webservices/militares/pesquisar','WebServicesController@pesquisaMilitar');
	Route::post('webservices/veiculos/pesquisar','WebServicesController@pesquisarVeiculo');
	Route::post('webservices/viaturas/pesquisar','WebServicesController@pesquisarViatura');
	Route::post('webservices/veiculos/marca/pesquisar','WebServicesController@pesquisaMarca');
	Route::post('webservices/veiculos/modelo/pesquisar','WebServicesController@pesquisaModelo');
	Route::post('webservices/OM/consulta','WebServicesController@pesquisaOM');
	Route::post('webservices/posto/consulta','WebServicesController@pesquisaPosto');
	Route::post('webservices/tipo_veiculo/consulta','WebServicesController@pesquisaTipoVeiculo');
	Route::post('webservices/marca_veiculo/consulta','WebServicesController@pesquisaMarcaVeiculo');
	Route::post('webservices/modelo_veiculo/consulta','WebServicesController@pesquisaModeloVeiculo');
	Route::post('webservices/consultas/pedestres/','ConsultaController@consultaPedestres');
	Route::post('webservices/consultas/automoveis/','ConsultaController@consultaAutomoveis');
	Route::post('webservices/configuraçoes/usuario/','WebServicesController@trocarSenha');


	Route::get('storage/doc/{filename}', function ($filename)
	{
		$path = storage_path('app/_DOC/'.base64_decode($filename));
		if (!File::exists($path)) {
			abort(404);
		}

		$file = File::get($path);
		$type = File::mimeType($path);
		$response = Response::make($file, 200);
		$response->header("Content-Type", $type);
		return $response;
	});
});

Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout' , 'Auth\LoginController@logout');

Route::post('senha/trocar', 'Auth\ChangePasswordController@changePassword')->name('password.change');


