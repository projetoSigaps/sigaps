@extends('adminlte::page')

@section('title', 'SIGAPS | Relatório de Militares')

@section('content_header')

@stop

@section('content')
<div class="box box-primary">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-search"></i> Relatório de Militares</h5>
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
			<form class="form-horizontal form" type="POST">
				{{csrf_field()}}
				<div class="form-group">
					<label class="col-xs-2 control-label">Nome de Guerra: </label>
					<div class="col-xs-2">
						<input value="" type="text" id="nome_guerra" name="nome_guerra" class="form-control" placeholder="Opcional">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">P/G: </label>
					<div class="col-xs-2">
						<select class="form-control" name="rel_posto" id="rel-posto">
							<option value="0" selected>Todos</option>
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
							@if(auth()->user()->hasRole('super-admin'))
							<option value="0">Todos</option>
							@endif
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
							<option selected value="todos">Todos</option>
							<option value="1">Ativado</option>
							<option value="0">Desativado</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Mês Vencimento CNH: </label>
					<div class="col-md-2">
						<select name="mes_cnh" class="form-control">
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
					<label class="control-label col-sm-2">Ano Vencimento CNH: </label>
					<div class="col-md-2">
						<input type="text" name="ano_cnh" class="form-control maskNum" maxlength="4" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Categoria CNH:</label>
					<div class="col-sm-2">
						<input value="" type="text" id="cnh_cat" name="cnh_cat" class="form-control maskCNHCAT" placeholder="Todas">
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label class="control-label col-sm-2"></label>
					<div class="col-md-2">
						<a href="javascript:;" id="relatorio-militar" class="btn btn-success"><i class="fa fa-check"></i> Gerar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@stop