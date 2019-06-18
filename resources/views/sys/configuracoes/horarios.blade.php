@extends('adminlte::page')

@section('title', 'SIGAPS | Registrar Horário')

@section('content_header')
@stop

@section('content')
<div class="box box-red" style="border-top: 3px solid #dd4b39;">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-cog"></i>  Registrar Horário</h5>
	</div>
	<div class="box-body">
		@if (session('success'))
		<div class="alert alert-sm alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<p class="text-green">
				<i class="icon fa fa-check"></i> {{ session('success') }}
			</p>
		</div>
		@endif
		@if (session('error'))
		<div class="alert alert-sm alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<p class="text-red">
				<i class="icon fa fa-close"></i> {{ session('error') }}
			</p>
		</div>
		@endif
		<form class="form form-horizontal well" method="post" action="{{route('sys.configuracoes.horarios.registrar')}}">
			{{csrf_field()}}
			<div class="form-group">
				<label class="col-xs-2 control-label">Tipo: </label>
				<div class="col-xs-6">
					<label class="radio-inline">
						<input type="radio" name="reg_horario" id="tp_ped" value="pedestre"> Pedestre
					</label>
					<label class="radio-inline">
						<input type="radio" name="reg_horario" id="tp_aut" value="automovel" checked=""> Automóvel
					</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-2 control-label text-primary">Código Crachá: </label>
				<div class="col-xs-2">
					<p><input type="text" name="cod_cracha" class="cod_cracha maskNum form-control" required></p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-2 control-label">Data e Hora: </label>
				<div class="col-xs-2">
					<p><input type="text" id="gdh_entrada" placeholder="Entrada" name="gdh_entrada" class="maskDataHora form-control"></p>
					<p><input type="text" id="gdh_saida" placeholder="Saída" name="gdh_saida" class="maskDataHora form-control"></p>
				</div>
			</div>
			<div>
				<center><button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Gravar</button></center>
			</div>
		</form>
	</div>
</div>
@stop