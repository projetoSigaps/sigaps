@extends('adminlte::page')

@section('title', 'SIGAPS | Consulta Automoveis')

@section('content_header')
@stop

@section('content')
<div class="box box-default" style="border-top: 3px solid purple;">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-search"></i> Consulta Automoveis</h5>
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
		<table width="100%" cellspacing="0" class="table text-center table-compact table-condensed table-hover tb_automoveis">
			{{csrf_field()}}
			<thead>
				<tr style="background-color:#00a65a;color:#FFFFFF;"> 
					<th style="text-align:center">P/G</th>
					<th style="text-align:center">Nome de Guerra</th>
					<th style="text-align:center">Nº Crachá</th>
					<th style="text-align:center;">Marca/Modelo</th>
					<th style="text-align:center;">Placa</th>
					<th style="text-align:center;">Entrada</th>
					<th style="text-align:center;">Saída</th>
					<th style="text-align:center;">OM</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@stop