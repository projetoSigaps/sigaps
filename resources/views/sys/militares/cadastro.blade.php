@extends('adminlte::page')

@section('title', 'SIGAPS | Cadastrar Militar')

@section('content_header')

@stop

@section('content')
<div class="box box-success">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-user-plus"></i> Cadastrar Militar</h5>
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
		<form action="{{route('sys.militares.cadastro.salvar')}}" class="form-horizontal form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
			{{csrf_field()}}
			<center>
				<div class="text-center fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
						<img src="{{asset('images/default_profile.jpg')}}" alt="Foto" >
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;"></div>
					<div>
						<span class="field btn btn-default btn-file">
							<span class="fileinput-new">Selecionar Foto</span>
							<span class="fileinput-exists"><i class="fa fa-folder-open"></i></span>
							<input type='file' name="datafile" id="datafile" required>
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
					<input class="form-control" type="text" id="nome" name="nome" placeholder="Nome completo" required>
					<span class="form-control-feedback" id="nome1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-2"></label>
				<div class="field col-md-4">
					<input value="" class="form-control" id="nome_guerra" type="text" name="nome_guerra" placeholder="Nome de guerra" required>
					<span class="form-control-feedback" id="nome_guerra1"></span>
				</div>
				<div class="field col-md-4">
					<input type="text" id="ident_militar" name="ident_militar" class="maskIdentidade form-control" placeholder="Identidade Militar" required>
					<span class="form-control-feedback" id="ident_militar1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-2"></label>
				<div class="field col-md-4">
					<input type="text" name="cep" id="cep" class="maskCEP form-control" placeholder="CEP" required>
					<span class="form-control-feedback" id="cep1"></span>
				</div>
				<div class="field col-md-4">
					<input class="form-control" type="text" name="estado" id="estado" placeholder="Estado" required>
					<span class="form-control-feedback" id="estado1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="field control-label col-md-2"></label>
				<div class="field col-md-4">
					<input class="form-control" type="text" name="cidade" id="cidade" placeholder="Cidade" required>
					<span class="form-control-feedback" id="cidade1"></span>
				</div>
				<div class="field col-md-4">
					<input class="form-control" type="text" name="bairro" id="bairro" placeholder="Bairro" required>
					<span class="form-control-feedback" id="bairro1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="field control-label col-md-2"></label>
				<div class="field col-md-6">
					<input class="form-control" type="text" id="endereco" name="endereco" placeholder="Endereco: Av, Rua, Travessa" required>
					<span class="form-control-feedback" id="endereco1"></span>
				</div>
				<div class="field col-md-2">
					<input class="form-control maskNum" type="text" id="numero" name="numero" placeholder="Nº" required>
					<span class="form-control-feedback" id="numero1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-2"></label>
				<div class="field col-md-4 field">
					<input type="text" id="celular" name="celular" class="form-control maskTelefone " placeholder="Celular" required>
					<span class="form-control-feedback" id="celular1"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="control-label col-md-2"></label>
				<div class="field col-md-3">
					<input type="text" id="cnh" name="cnh" class="form-control maskNum" placeholder="Nº CNH" >
					<span class="form-control-feedback" id="cnh1"></span>
				</div>
				<div class="field col-sm-2">
					<input type="text" id="cnh_cat" name="cnh_cat" class="form-control maskCNHCAT" placeholder="Categoria CNH" >
					<span class="form-control-feedback" id="cnh_cat1"></span>
				</div>
				<div class="field col-md-3">
					<input type="text" id="cnh_venc" name="cnh_venc" class="form-control maskData" placeholder="Vencimento" >
					<span class="form-control-feedback" id="cnh_venc1"></span>
				</div>
			</div>
			<hr>
			<div class="form-group has-feedback">
				<label class="control-label col-md-2">OM: </label>
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
				<label class="control-label col-md-2">Posto/Graduação: </label>
				<div class="field col-md-4">
					<select name="posto" class="form-control" id="posto" required>
						<option value="" disabled selected>- Selecione -</option>
						@foreach($posto as $value)
						<option value="{{$value->id}}">{{$value->nome}}</option>
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