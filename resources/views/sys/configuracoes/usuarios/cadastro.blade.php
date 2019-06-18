@extends('adminlte::page')

@section('title', 'SIGAPS | Cadastrar Usuarios')

@section('content_header')
@stop

@section('content')
<div class="box box-red" style="border-top: 3px solid #dd4b39;">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-cog"></i> Cadastrar usuários ao sistema</h5>
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

		<form class="form-horizontal form well well-sm" method="POST" action="{{route('sys.configuracoes.usuarios.salvar')}}" >
			{{csrf_field()}}
			<div class="alert alert-warning">
				<h4><i class="icon fa fa-warning"></i> ATENÇÃO!</h4>
				<p> Informações Importantes: </p>
				<ul style="text-align:justify;margin-top: 10px;">
					<li>
						<b>A Senha inicial é o login do usuário</b>
					</li>
					<li>
						<b>No primeiro acesso é necessário trocar a senha para iniciar no sistema</b>
					</li>
					<li>
						<b>Os dados de acesso são pessoal e intransferível, não os compartilhe com NINGUÉM!</b>
					</li>
					<li>
						<b>Toda ação do usuário é registrada e monitorada pelo sistema, então cuidado!</b>
					</li>
				</ul>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-1"></label>
				<div class="field col-md-4">
					<input class="form-control" type="text" id="nome_usuario" name="nome_usuario" placeholder="Nome" required>
					<span class="form-control-feedback" id="nome_usuario1"></span>
				</div>
				<div class="field col-md-3">
					<input class="form-control" id="login_usuario" name="login_usuario" placeholder="Usuário" required>
					<span class="form-control-feedback" id="login_usuario1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-1"></label>
				<div class="field col-md-4">
					<input type="email" id="email" name="email" class="form-control" placeholder="E-mail" required>
					<span class="form-control-feedback" id="email1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-1">OM: </label>
				<div class="field col-md-4">
					<select name="om_id" class="form-control" id="om_id" required>
						<option value="" disabled selected>- Selecione -</option>
						@foreach($om as $value)
						<option value="{{$value->id}}">{{$value->nome}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-1">Perfil: </label>
				<div class="field col-md-4">
					<select name="perfil_id" class="form-control" id="perfil_id" required>
						<option value="" disabled selected>- Selecione -</option>
						@foreach($roles as $value)
						<option value="{{$value->id}}">{{$value->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="box-footer">
				<center>
					<button type="submit" class="btn btn-flat btn-success">Salvar <span class="fa fa-floppy-o"></span></button>
				</center>
			</div>
		</form>
	</div>
</div>
@stop