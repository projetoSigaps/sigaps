@extends('adminlte::master')

@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
@yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
<div class="login-box">
	<div class="login-logo">
		<a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
		<p style="color:white;font-size:15px;">Sistema de Gerenciamento de Automóveis e Pessoas</p>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<img class="login-box-msg" src="/images/logo_login.png">
		<center><p class="text-danger">Troque a senha para continuar</p></center>
		<ul style="text-align:justify;margin-top: 10px;font-size: 11px;">
			<li>
				<b>Sua senha não poderá ser igual ao usuário (login).</b>
			</li>
			<li>
				<b>No minímo 6 caracteres.</b>
			</li>
			<li>
				<b>A senha deverá conter letras e números.</b>
			</li>
		</ul>

		<form class="form-senha" action="{{ route('password.change')}}" method="post">
			{!! csrf_field() !!}
			<div class="form-group has-feedback {{ $errors->has('password_new') ? 'has-error' : '' }}">
				<input type="password" id="password_new" name="password_new" class="form-control"
				placeholder="{{ trans('adminlte::adminlte.new_password') }}" required>
				<span class="fa fa-key form-control-feedback"></span>
				@if ($errors->has('password_new'))
				<span class="help-block">
					<strong>{{ $errors->first('password_new') }}</strong>
				</span>
				@endif
			</div>
			<div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
				<input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
				placeholder="{{ trans('adminlte::adminlte.retype_password') }}" required>
				<span class="fa fa-lock form-control-feedback"></span>
				@if ($errors->has('password_confirmation'))
				<span class="help-block">
					<strong>{{ $errors->first('password_confirmation') }}</strong>
				</span>
				@endif
			</div>

			<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
				<input type="email" name="email" class="form-control"
				placeholder="Confirme seu e-mail" required>
				<span class="fa fa-envelope form-control-feedback"></span>
				@if ($errors->has('email'))
				<span class="help-block">
					<strong>{{ $errors->first('email') }}</strong>
				</span>
				@endif
			</div>
			<button type="submit" class="btn btn-success btn-block btn-flat">Salvar</button>
			<a class="btn btn-danger btn-block btn-flat" href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
				Sair
			</a>
		</form>
		@if (session('error'))
		<div class="alert alert-sm alert-dismissible">
			<p class="text-red">
				<i class="icon fa fa-close"></i> {{ session('error') }}
			</p>
		</div>
		@endif
		<!-- /.login-box-body -->
	</div><!-- /.login-box -->
</div>
@stop

@section('adminlte_js')
@yield('js')
@stop
