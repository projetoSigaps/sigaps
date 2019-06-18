@extends('adminlte::page')

@section('title', 'SIGAPS | Usuarios')

@section('content_header')
@stop

@section('content')
<div class="box box-red" style="border-top: 3px solid #dd4b39;">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-cog"></i> Usuários do Sistema</h5>
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
		<table width="100%" cellspacing="0" class="table text-center table-compact table-condensed table-hover tb_usuarios">
			{{csrf_field()}}
			<thead>
				<tr style="background-color:#228B22;color:#FFFFFF;"> 
					<th style="text-align:center">Nome</th>
					<th style="text-align:center;">Usuário</th>
					<th style="text-align:center;">Organização Militar</th>
					<th style="text-align:center;">Perfil</th>
					<th style="text-align:center;">Opções</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
@stop