@extends('adminlte::page')

@section('title', 'SIGAPS | Editar Usuarios')

@section('content_header')
@stop

@section('content')
<div class="box box-red" style="border-top: 3px solid #dd4b39;">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-cog"></i> Editar usuário do sistema</h5>
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

		<form class="form-horizontal form well well-sm" method="POST" action="" >
			{{csrf_field()}}
			<div class="alert alert-warning">
				<h4><i class="icon fa fa-warning"></i> ATENÇÃO!</h4>
				<p> Informação Importante: </p>
				<ul style="text-align:justify;margin-top: 10px;">
					<li>
						<b>Ao realizar a redefinição da senha, a mesma passa a ser igual ao usuário (login), sendo necessário trocar no próximo acesso.</b>
					</li>
				</ul>
			</div>


			<div class="form-group has-feedback">
				<label class="control-label col-md-1">Nome: </label>
				<div class="field col-md-4">
					<input class="form-control" value="{{$usuario->name}}" type="text" id="nome_usuario" name="nome_usuario" placeholder="" required>
					<span class="form-control-feedback" id="nome_usuario1"></span>
				</div>
				<label class="control-label col-md-1">Usuário: </label>
				<div class="field col-md-3">
					<input class="form-control" value="{{$usuario->login}}" id="login_usuario" name="login_usuario" placeholder="" disabled>
					<span class="form-control-feedback" id="login_usuario1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-1">Email: </label>
				<div class="field col-md-4">
					<input type="email" value="{{$usuario->email}}" id="email" name="email" class="form-control" placeholder="" required>
					<span class="form-control-feedback" id="email1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-1">OM: </label>
				<div class="field col-md-4">
					<select name="om_id" class="form-control" id="om_id" required>
						<option value="" disabled selected>- Selecione -</option>
						@foreach($om as $value)
						<option <?php if($usuario->om_id==$value->id) echo "selected"; ?> value="{{$value->id}}">{{$value->nome}}</option>
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
						<option <?php if($usuario->roles()->pluck('id')->implode(' ')==$value->id) echo "selected"; ?> value="{{$value->id}}">{{$value->name}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-1"></label>
				<div class="field col-md-4">
					<button type="button" name="trocar_ps" class="btn btn-flat btn-primary">Redefinir Senha <span class="fa fa-key"></span></button>
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