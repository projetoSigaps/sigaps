@extends('adminlte::page')

@section('title', 'SIGAPS | Cadastrar Veículo')

@section('content_header')
@stop

@section('content')
<div class="box box-warning">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-automobile"></i> Cadastrar Veículo</h5>
	</div>
	<div class="box-body">
		@if (session('error'))
		<div class="alert alert-sm alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<p class="text-red">
				<i class="icon fa fa-close"></i> {{ session('error') }}
			</p>
		</div>
		@endif
		<div class="panel panel-warning">
			<div class="panel-heading">Pesquisar Militar</div>
			<div class="panel-body">
				<form class="form-horizontal" id="form-pesquisa" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						<div class="col-md-2">
							<select class="form-control" id="documentacao_tipo">
								<option value="cnh" selected>CNH</option>
								<option value="ident_militar">Identidade Militar</option>
							</select>
						</div>
						<div class="col-md-3">
							<input type="text" id="numero_documento" class="maskNum form-control"  placeholder="Número do documento" >
						</div>
						<div class="col-md-3">
							<button class="btn btn-flat btn-default buscar-militar" type="submit" onclick="return false;" id="buscar-militar">
								Pesquisar <i class="fa fa-search"></i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="panel panel-primary" id="panel-militar" style="display: none;">
			<div class="panel-heading">Informações do Militar</div>
			<div class="panel-body">
				<table class="table">
					<tbody>
						<tr>
							<td>Nome Completo:</td>
							<td colspan="3"><span id="nome" class="text-primary"></span></td>
						</tr>
						<tr>
							<td>Nome de Guerra:</td>
							<td><span id="nome_guerra" class="text-primary"></span></td>
							<td>P/G:</td>
							<td><span id="posto" class="text-primary"></span></td>
						</tr>
						<tr>
							<td>Identidade Militar:</td>
							<td><span id="ident_militar" class="text-primary"></span></td>
							<td>OM:</td>
							<td><span id="om" class="text-primary"></span></td>
						</tr>
						<tr>
							<td>Número da CNH:</td>
							<td colspan="3"><span id="cnh" class="text-primary"></span></td>
						</tr>
						<tr>
							<td>Categoria CNH:</td>
							<td><span id="cnh_cat" class="text-primary"></span></td>
							<td>Vencimento CNH:</td>
							<td><span id="cnh_venc" class="text-primary"></span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="alert alert-warning alert-dismissible" id="panel-alert" style="display: none;">
			<h4><i class="icon fa fa-warning"></i> Alerta!</h4>
			Dados incompletos da CNH, preencha todos os dados para cadastrar um novo veículo!
		</div>

		<div class="panel panel-success" id="panel-veiculo" style="display: none;">
			<div class="panel-heading">Informações do Veículo</div>
			<div class="panel-body">
				<form class="form form-horizontal" method="post" id="form-veiculo" action="{{route('sys.veiculos.cadastro.salvar')}}">
					{{csrf_field()}}
					<input type="hidden" id="militar_id" name="militar_id">
					<div class="form-group">
						<div class="col-md-4">
							<label class="control-label">Tipo de veículo: </label>
							<select required class="form-control automovel_tipo" name="tipo_id" id="automovel_tipo" onchange="if($(this).find('option:selected').val()=='2'){$('#curso-moto').show(); }else{$('#curso-moto').hide(); }">
								<option value="" disabled selected>- Selecione -</option>
								@foreach($tp_veiculo as $value)
								<option value="{{$value->id}}">{{$value->nome}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-4">
							<label class="control-label">Marca do veículo: </label>
							<select required name="marca_id" id="automovel_marca" class="form-control automovel_marca" disabled>
							</select>
						</div>
						<div class="col-md-4">
							<label class="control-label">Modelo do veículo: </label>
							<select required name="modelo_id" id="automovel_modelo" class="form-control automovel_modelo" disabled>
							</select>
						</div>
					</div>
					<div class="form-group has-feedback">
						<div class="field col-md-4">
							<input id="exercicio_documento" type="text" class="form-control maskNum" placeholder="Exercício">
							<span class="form-control-feedback" id="exercicio_documento1"></span>
						</div>
						<div class="field col-md-4">	

							<input id="placa" minlength="8" type="text" name="placa" class="form-control maskPlaca" placeholder="Placa" required>
							<span class="form-control-feedback" id="placa1"></span>
						</div>
						<div class="field col-md-4">
							<input id="renavan" type="text" name="renavan" class="form-control maskNum" placeholder="Renavam" required>
							<span class="form-control-feedback" id="renavan1"></span>
						</div>
					</div>
					<div class="form-group has-feedback">
						<div class="field col-md-4">
							<input id="cor" type="text" name="cor" class="form-control" placeholder="Cor" required>
							<span class="form-control-feedback" id="cor1"></span>
						</div>
						<div class="field col-md-4">
							<input id="doc_venc" type="text" name="doc_venc" class="form-control maskData" placeholder="Vencimento do documento" required>
							<span class="form-control-feedback" id="doc_venc1"></span>
						</div>
						<div class="field col-md-4">
							<input id="origem" type="text" name="origem" class="form-control" placeholder="Origem do veículo" required>
							<span class="form-control-feedback" id="origem1"></span>
						</div>
					</div>
					<div class="form-group has-feedback">
						<div class="field col-md-4">
							<input id="ano_auto" type="text" name="ano_auto" class="maskAno form-control" placeholder="Ano do veículo" required>
							<span class="form-control-feedback" id="ano_auto1"></span>
						</div>
					</div>
					<button type="submit" class="btn btn-flat btn-success">Salvar <i class="fa fa-floppy-o"></i></button>
				</form>
			</div>
		</div>
	</div>
</div>
@stop