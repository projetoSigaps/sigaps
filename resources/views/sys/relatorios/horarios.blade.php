@extends('adminlte::page')

@section('title', 'SIGAPS | Entrada e Saída')

@section('content_header')

@stop

@section('content')
<div class="box box-primary">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-search"></i> Relatório de Entrada e Saída</h5>
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
			<form class="form form-horizontal" method="post" id="horarios">
				{{csrf_field()}}
				<div class="form-group">
					<label class="col-xs-2 control-label">Tipo de Relatório: </label>
					<div class="col-xs-6">
						<label class="radio-inline">
							<input type="radio" name="tpRelatorio" id="tpRelatorio_ped" value="Pedestres"> Pedestres
						</label>
						<label class="radio-inline">
							<input type="radio" name="tpRelatorio" id="tpRelatorio_aut" value="Automoveis"> Automóveis
						</label>
						<label class="radio-inline">
							<input type="radio" name="tpRelatorio" id="tpRelatorio_vtr" value="Viatura"> Viaturas
						</label>
					</div>
				</div>
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
							<option value="0">Todos</option>
							@foreach($om as $value)
							<option value="{{$value->id}}">{{$value->nome}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Períodos: </label>
					<div class="col-xs-2">
						<p><input type="text" id="gdh_inicio" placeholder="Data Início" name="gdh_inicio" class="maskDataHora form-control" required></p>
						<p><input type="text" id="gdh_fim" placeholder="Data Fim" name="gdh_fim" class="maskDataHora form-control" required></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label text-primary">Código Crachá: </label>
					<div class="col-xs-2">
						<p><input type="text" placeholder="Opcional" name="cod_cracha" class="cod_cracha maskNum form-control"></p>
					</div>
				</div>
				<div id="btn-auto">
					<center><button type="button" id="relatorio-horario-auto" class="btn btn-success"><i class="fa fa-check"></i> Gerar</button></center>
				</div>
				<div id="btn-pedestre">
					<center><button type="button" id="relatorio-horario-pedestre" class="btn btn-success"><i class="fa fa-check"></i> Gerar</button></center>
				</div>
			</form>
		</div>
	</div>
</div>
@stop