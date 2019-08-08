@extends('adminlte::page')

@section('title', 'SIGAPS | Listagem Militares')

@section('content_header')
@stop

@section('content')
<div class="box box-success">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-list"></i> Listagem de Militares</h5>
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
		<table width="100%" cellspacing="0" class="table text-center table-compact table-condensed table-hover tb">
			{{csrf_field()}}
			<thead>
				<tr style="background-color:#00a65a;color:#FFFFFF;">
					<th style="text-align:center;width: 80px;">Nº Crachá</th>
					<th style="text-align:center;">P/G</th>
					<th style="text-align:center">Nome de Guerra</th>
					<th style="text-align:center;">Nome</th>
					<th style="text-align:center;">Identidade</th>
					<th style="text-align:center;">OM</th>
					<th style="text-align:center;">Status</th>
					<th style="text-align:center;">Opções</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@stop