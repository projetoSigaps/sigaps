@extends('adminlte::page')

@section('title', 'SIGAPS | Relatório de Automovéis')

@section('content_header')

@stop

@section('content')
<div class="box box-primary">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-search"></i> Relatório de Automovéis</h5>
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
		<div class="well">
			<form class="form form-horizontal" type="POST">
				{{csrf_field()}}
				<div class="form-group" >
					<label class="col-xs-2 control-label">P/G: </label>
					<div class="col-xs-2">
						<select class="form-control" name="rel_posto" id="rel-posto">
							<option value="0">Todos</option>
							@foreach($posto as $value)
							<option value="{{$value->id}}">{{$value->nome}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Organização Militar: </label>
					<div class="col-xs-2">
						<select class="form-control" name="rel_om" id="rel-om">
							<option value="0">Todas</option>
							@foreach($om as $value)
							<option value="{{$value->id}}">{{$value->nome}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Status: </label>
					<div class="col-xs-2">
						<select name="status" class="form-control">
							<option Selected value="">Todos</option>
							<option value="1">Ativado</option>
							<option value="2">Desativado</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Placa: </label>
					<div class="col-xs-1">
						<input value="" type="text" id="placa_rel" name="placa_rel" class="maskPlaca form-control"  placeholder="Opcional">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Renavam: </label>
					<div class="col-xs-2">
						<input value="" type="text" id="renavam" name="renavam" class="form-control maskNum"  placeholder="Opcional">
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-2 control-label">Cor: </label>
					<div class="col-xs-2">
						<input value="" type="text" id="cor" name="cor" class="form-control"  placeholder="Opcional">
					</div>
					<label class="col-xs-1 control-label">Ano: </label>
					<div class="col-xs-1">
						<input value="" type="text" id="ano" name="ano" class="form-control"  placeholder="Opcional">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Tipo: </label>
					<div class="col-md-2">
						<select required class="form-control" name="tipo_id" id="automovel_tipo">
							<option value="">Todos</option>
							@foreach($tp_veiculo as $value)
							<option value="{{$value->id}}">{{$value->nome}}</option>
							@endforeach
						</select>
					</div>
					<label class="col-xs-1 control-label">Marca: </label>
					<div class="col-md-2">
						<select required name="marca_id" id="automovel_marca" class="form-control" disabled>
							<option value="0">Todas</option>
						</select>
					</div>
					<label class="col-xs-1 control-label">Modelo: </label>
					<div class="col-md-2">
						<select required name="modelo_id" id="automovel_modelo" class="form-control" disabled>
							<option value="0">Todos</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Mês Vencimento DOC: </label>
					<div class="col-md-2">
						<select class="form-control" name="mes_doc">
							<option value="00">Todos</option>
							<option value="01">Janeiro</option>
							<option value="02">Fevereiro</option>
							<option value="03">Março</option>
							<option value="04">Abril</option>
							<option value="05">Maio</option>
							<option value="06">Junho</option>
							<option value="07">Julho</option>
							<option value="08">Agosto</option>
							<option value="09">Setembro</option>
							<option value="10">Outubro</option>
							<option value="11">Novembro</option>
							<option value="12">Dezembro</option>
						</select>
					</div>
					<label class="col-xs-1 control-label">Ano DOC: </label>
					<div class="col-md-2">
						<input type="text" name="ano_doc" class="form-control maskNum" maxlength="4" disabled>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label class="control-label col-sm-2"></label>
					<div class="col-md-2">
						<a href="javascript:;" id="relatorio-automovel" class="btn btn-success"><i class="fa fa-check"></i> Gerar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@stop