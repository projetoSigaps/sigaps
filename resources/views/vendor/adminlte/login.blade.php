@extends('adminlte::master')

@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
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
        <!--<p class="login-box-msg">{{ trans('adminlte::adminlte.login_message') }}</p>-->
        <img class="login-box-msg" src="/images/logo_login.png">
        <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
            {!! csrf_field() !!}

            <div class="form-group has-feedback {{ $errors->has('login') ? 'has-error' : '' }}">
                <input name="login" class="form-control" value="{{ old('login') }}"
                placeholder="{{ trans('adminlte::adminlte.login_user') }}">
                <span class="fa fa-user form-control-feedback"></span>
                @if ($errors->has('login'))
                <span class="help-block">
                    <strong>{{ $errors->first('login') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <input type="password" name="password" class="form-control"
                placeholder="{{ trans('adminlte::adminlte.password') }}">
                <span class="fa fa-key form-control-feedback"></span>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="row">
                    <!--<div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember"> {{ trans('adminlte::adminlte.remember_me') }}
                            </label>
                        </div>
                    </div>-->
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit"
                        class="btn btn-success btn-block btn-flat">{{ trans('adminlte::adminlte.sign_in') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!--<div class="auth-links">
                <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}"
                   class="text-center"
                >{{ trans('adminlte::adminlte.i_forgot_my_password') }}</a>
                <br>
                @if (config('adminlte.register_url', 'register'))
                    <a href="{{ url(config('adminlte.register_url', 'register')) }}"
                       class="text-center"
                    >{{ trans('adminlte::adminlte.register_a_new_membership') }}</a>
                @endif
            </div>
        </div>-->
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
    @stop

    @section('adminlte_js')
    @yield('js')
    @stop
