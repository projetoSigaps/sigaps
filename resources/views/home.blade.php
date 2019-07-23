@extends('adminlte::page')

@section('title', 'SIGAPS | Início')

@section('content_header')
<h1></h1>
@stop

@section('content')
@if (session('success'))
<div class="alert alert-sm alert-dismissible">
	<p class="text-green">
		<i class="icon fa fa-check"></i> {{ session('success') }}
	</p>
</div>
@endif

<div class="panel box box-primary">
	<div class="box-header with-border">
		<h4 class="box-title">
			<i class="fa fa-user"></i> Usuário
		</h4>
	</div>
	<div class="box-body">
		<table class="table table-striped">
			<thead>
				<th>Nome Completo</th>
				<th>Usuário</th>
				<th>E-mail</th>
				<th>OM</th>
				<th>Perfil</th>
			</thead>
			<tbody>
				<td>{{$user->name}}</td>
				<td>{{$user->login}}</td>
				<td>{{$user->email}}</td>
				<td>{{$om->nome}}</td>
				<td><span class="label label-warning">{{auth()->user()->roles()->pluck('name')->implode(' ')}}</span></td>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="panel box box-primary">
			<div class="box-header with-border">
				<i class="fa fa-bar-chart-o"></i>
				<h3 class="box-title">Estátisticas</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="row">
					<div class="col-xs-12">
						<div class="info-box">
							<span class="info-box-icon"><i class="fa fa-users"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Militares Cadastrados</span>
								<span class="info-box-number">{{$total_militares}}</span>
							</div>
						</div>
					</div>

					<div class="col-xs-12">
						<div class="info-box">
							<span class="info-box-icon"><i class="fa fa-car"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Veículos Cadastrados</span>
								<span class="info-box-number">{{$total_automoveis}}</span>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>



@stop