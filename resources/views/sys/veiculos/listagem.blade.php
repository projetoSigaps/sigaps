@extends('adminlte::page')

@section('title', 'SIGAPS | Listagem de Veículos')

@section('content_header')

@stop

@section('content')
<div class="box box-warning">
	<div class="box-header">
		<h5 class="box-title"><i class="fa fa-list"></i> Listagem de Veículos</h5>
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

		<table style="padding-top:10px;" width="100%" cellspacing="0" class="table text-center table-compact table-condensed table-hover tb_auto">
			{{csrf_field()}}
			<thead>
				<tr style="background-color:#228B22;color:#FFFFFF;"> 
					<th style="text-align:center"></th>
					<th style="text-align:center">P/G</th>
					<th style="text-align:center">Nome de Guerra</th>
					<th style="text-align:center;">Nome</th>
					<th style="text-align:center;">Identidade</th>
					<th style="text-align:center;">OM</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>

@stop