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
<?php print_r(Auth::user()->login); ?>
@stop