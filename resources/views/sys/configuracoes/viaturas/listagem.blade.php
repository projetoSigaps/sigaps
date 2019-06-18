@extends('adminlte::page')

@section('title', 'SIGAPS | Listagem de Viaturas')

@section('content_header')

@stop

@section('content')
<div class="box box-red" style="border-top: 3px solid #dd4b39;">
	<div class="box-header">
		<h5 class="box-title"><i class="fa fa-gear"></i> Listagem de Viaturas</h5>
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

		<table width="100%" cellspacing="0" class="table text-center table-compact table-condensed table-hover tb_vtr">
			{{csrf_field()}}
			<thead>
				<tr style="background-color:#228B22;color:#FFFFFF;"> 
					<th style="text-align:center"></th>
					<th style="text-align:center">OM</th>
					<th style="text-align:center">Descrição</th>
					<th style="text-align:center">CODOM</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>

@stop