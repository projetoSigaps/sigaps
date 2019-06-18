@extends('adminlte::page')

@section('title', 'SIGAPS | Editar OM ')

@section('content_header')
@stop

@section('content')
<div class="box box-red" style="border-top: 3px solid #dd4b39;">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-gear"></i> Editar Organização Militar</h5>
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
		<form action="{{route('sys.configuracoes.om.atualizar', $om->id)}}" class="form-horizontal form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
			{{csrf_field()}}
			<?php
			$foto = $om->id.'/CODOM_'.$om->codom.'/'.$om->datafile; //Pega o caminho da foto 	
			?>
			<center>
				<div class="text-center fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail" style="width: 180px; height: 135px;">
						<img src="
						{{Storage::disk('_DOC')->url(base64_encode($foto))}}" id="foto" alt="Foto">
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;"></div>
					<div>
						<span class="field btn btn-default btn-file">
							<span class="fileinput-new">Selecionar Foto</span>
							<span class="fileinput-exists"><i class="fa fa-folder-open"></i></span>
							<input type='file' name="datafile" id="datafile" value="{{$om->datafile}}" />
						</span>
						<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-remove"></i></a>
					</div>
				</div>
				<a id="tooltip" data-toggle="tooltip" style="color:red;padding-left:5px;" data-original-title="Arquivos Aceitos: JPG e PNG Tamanho Max: 5Mb">
					<span class="fa fa-info-circle"></span>
				</a>
			</center>

			<div class="form-group has-feedback">
				<label class="control-label col-md-2"></label>
				<div class="field col-md-8">
					<input class="form-control" type="text" id="nome_om" name="nome_om" placeholder="Nome da OM" value="{{$om->nome}}" required="">
					<span class="form-control-feedback" id="nome_om1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-2"></label>
				<div class="field col-md-4">
					<input class="form-control" id="nome_abreviado" type="text" name="nome_abreviado" placeholder="Sigla da OM" value="{{$om->descricao}}" required="">
					<span class="form-control-feedback" id="nome_abreviado1"></span>
				</div>
				<div class="field col-md-4">
					<input type="text" id="codom" name="codom" class="maskNum form-control" placeholder="CODOM" value="{{$om->codom}}" required="">
					<span class="form-control-feedback" id="codom1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-2"></label>
				<div class="field col-md-4">
					<input type="text" name="cep" id="cep" class="maskCEP form-control" placeholder="CEP" value="{{$om->cep}}" required="">
					<span class="form-control-feedback" id="cep1"></span>
				</div>
				<div class="field col-md-4">
					<input class="form-control" type="text" name="estado" id="estado" placeholder="Estado" value="{{$om->estado}}" required="">
					<span class="form-control-feedback" id="estado1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="field control-label col-md-2"></label>
				<div class="field col-md-4">
					<input class="form-control" type="text" name="cidade" id="cidade" placeholder="Cidade" value="{{$om->cidade}}" required="">
					<span class="form-control-feedback" id="cidade1"></span>
				</div>
				<div class="field col-md-4">
					<input class="form-control" type="text" name="bairro" id="bairro" placeholder="Bairro" value="{{$om->bairro}}" required="">
					<span class="form-control-feedback" id="bairro1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="field control-label col-md-2"></label>
				<div class="field col-md-6">
					<input class="form-control" type="text" id="endereco" name="endereco" placeholder="Endereco: Av, Rua, Travessa" value="{{$om->endereco}}" required="">
					<span class="form-control-feedback" id="endereco1"></span>
				</div>
				<div class="field col-md-2">
					<input class="form-control maskNum" type="text" id="numero" name="numero" placeholder="Nº" value="{{$om->numero}}" required="">
					<span class="form-control-feedback" id="numero1"></span>
				</div>
			</div>
			<hr>
			<div class="box-footer">
				<center>
					<button type="submit" value="Salvar" class="btn btn-flat btn-success">Salvar <span class="fa fa-floppy-o"></span></button>
				</center>
			</div>
		</form>
	</div>
</div>
@stop