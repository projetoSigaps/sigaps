@extends('adminlte::page')

@section('title', $militar->nome.' | SIGAPS')

@section('content_header')
@stop

@section('content')
<div class="box box-success">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-edit"></i> Editar Dados</h5>
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
		<form action="{{route('sys.militares.cadastro.atualiza', $militar->id)}}" class="form-horizontal form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
			{{csrf_field()}}
			<?php

			if($militar->status == 1){$status = 'Ativado';} else $status = 'Desativado'; //Verifica Status do Militar
			$foto = $militar->om_id.'/'.$militar->posto.'/'.$militar->ident_militar.'/'.$militar->datafile; //Pega o caminho da foto 
			session(['mil' => base64_encode($militar->om_id.'/'.$militar->posto.'/'.$militar->ident_militar)]); //converte para base64 e grava na sessão a pasta onde esta os documentos
			
			?>
			<center>
				<div class="text-center fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
						<img src="
						{{Storage::disk('_DOC')->url(base64_encode($foto))}}" id="foto" alt="Foto">
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;"></div>
					<div>
						<span class="field btn btn-default btn-file">
							<span class="fileinput-new">Selecionar Foto</span>
							<span class="fileinput-exists"><i class="fa fa-folder-open"></i></span>
							<input type='file' value="{{$militar->datafile}}" name="datafile" id="datafile">
						</span>
						<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-remove"></i></a>
					</div>
				</div>
				<a id="tooltip" data-toggle="tooltip" style="color:red;padding-left:5px;" data-original-title="Arquivos Aceitos: JPG e PNG Tamanho Max: 5Mb">
					<span class="fa fa-info-circle"></span></a>
				</center>

				<div class="form-group has-feedback">
					<label class="control-label col-md-2"></label>
					<div class="field col-md-8">
						<input value="{{$militar->nome}}" class="form-control" type="text" id="nome" name="nome" placeholder="Nome completo" required>
						<span class="form-control-feedback" id="nome1"></span>
					</div>
				</div>

				<div class="form-group has-feedback">
					<label class="control-label col-md-2"></label>
					<div class="field col-md-4">
						<input value="{{$militar->nome_guerra}}" class="form-control" id="nome_guerra" type="text" name="nome_guerra" placeholder="Nome de guerra" required>
						<span class="form-control-feedback" id="nome_guerra1"></span>
					</div>
					<div class="field col-md-4">
						<input value="{{$militar->ident_militar}}" type="text" id="ident_militar" name="ident_militar" class="maskIdentidade form-control" placeholder="Identidade Militar" required>
						<span class="form-control-feedback" id="ident_militar1"></span>
					</div>
				</div>

				<div class="form-group has-feedback">
					<label class="control-label col-md-2"></label>
					<div class="field col-md-4">
						<input value="{{$militar->cep}}" type="text" name="cep" id="cep" class="maskCEP form-control" placeholder="CEP" required>
						<span class="form-control-feedback" id="cep1"></span>
					</div>
					<div class="field col-md-4">
						<input value="{{$militar->estado}}" class="form-control" type="text" name="estado" id="estado" placeholder="Estado" required>
						<span class="form-control-feedback" id="estado1"></span>
					</div>
				</div>

				<div class="form-group has-feedback">
					<label class="field control-label col-md-2"></label>
					<div class="field col-md-4">
						<input value="{{$militar->cidade}}" class="form-control" type="text" name="cidade" id="cidade" placeholder="Cidade" required>
						<span class="form-control-feedback" id="cidade1"></span>
					</div>
					<div class="field col-md-4">
						<input value="{{$militar->bairro}}" class="form-control" type="text" name="bairro" id="bairro" placeholder="Bairro" required>
						<span class="form-control-feedback" id="bairro1"></span>
					</div>
				</div>

				<div class="form-group has-feedback">
					<label class="field control-label col-md-2"></label>
					<div class="field col-md-6">
						<input value="{{$militar->endereco}}" class="form-control" type="text" id="endereco" name="endereco" placeholder="Endereco: Av, Rua, Travessa"  required>
						<span class="form-control-feedback" id="endereco1"></span>
					</div>
					<div class="field col-md-2">
						<input value="{{$militar->numero}}" class="form-control maskNum" type="text" id="numero" name="numero" placeholder="Nº" required>
						<span class="form-control-feedback" id="numero1"></span>
					</div>
				</div>

				<div class="form-group has-feedback">
					<label class="control-label col-md-2"></label>
					<div class="field col-md-4 field">
						<input value="{{$militar->celular}}" type="text" id="celular" name="celular" class="form-control maskTelefone " placeholder="Celular" required>
						<span class="form-control-feedback" id="celular1"></span>
					</div>
				</div>

				<div class="form-group has-feedback">
					<label class="control-label col-md-2"></label>
					<div class="field col-md-3">
						<input value="{{$militar->cnh}}" type="text" id="cnh" name="cnh" class="form-control maskNum"  placeholder="Nº CNH" >
						<span class="form-control-feedback" id="cnh1"></span>
					</div>
					<div class="field col-sm-2">
						<input value="{{$militar->cnh_cat}}" type="text" id="cnh_cat" name="cnh_cat" class="form-control maskCNHCAT" placeholder="Categoria CNH" >
						<span class="form-control-feedback" id="cnh_cat1"></span>
					</div>
					<div class="field col-md-3">
						@if ($militar->cnh_venc)
						<input value="{{date('d/m/Y', strtotime($militar->cnh_venc))}}" type="text" id="cnh_venc" name="cnh_venc" class="form-control maskData" placeholder="Vencimento">
						@else
						<input value="" type="text" id="cnh_venc" name="cnh_venc" class="form-control maskData" placeholder="Vencimento">
						@endif
						<span class="form-control-feedback" id="cnh_venc1"></span>
					</div>
				</div>

				<hr>

				<div class="form-group has-feedback">
					<label class="control-label col-md-2">OM: </label>
					<div class="field col-md-3">
						<select name="om_id" class="form-control" id="om_id" required>
							@foreach($om as $value)
							<option <?php if($militar->om_id==$value->id) echo "selected"; ?> value="{{$value->id}}">{{$value->nome}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="form-group has-feedback">
					<label class="control-label col-md-2">Posto/Graduação: </label>
					<div class="field col-md-3">
						<select name="posto" class="form-control" id="posto" required>
							@foreach($posto as $value)
							<option <?php if($militar->posto==$value->id) echo "selected"; ?> value="{{$value->id}}">{{$value->nome}}</option>
							@endforeach
						</select>
					</div>
				</div>

				@if ($militar->status == 0)
				<div class="form-group has-error">
					@else
					<div class="form-group has-success">
						@endif
						<label class="control-label col-md-2">Status: </label>
						<div class="field col-md-2">
							<input class="form-control " id="status" value="{{$status}}" disabled>
						</div>
					</div>
					<div class="form-group">
						<center>
							@if($militar->status == 1)
							<a href="" data-toggle="modal" data-target="#desativar-militar" target="_blank" class="btn btn-flat btn-danger">Desativar <span class="fa fa-lock"></span></a>
							@else($militar->status == 0)
							<a href="" data-toggle="modal" data-target="#ativar-militar" target="_blank" class="btn btn-flat btn-success">Ativar <span class="fa fa-unlock"></span></a>
							@endif
							<a class="btn btn-flat btn-primary novo-veiculo">Novo Veículo <span class="fa fa-plus-square"></span></a>
							<a href="{{route('sys.cracha.pedestre',$militar->id)}}" target="_blank" class="btn btn-flat btn-warning">Gerar Crachá <span class="fa fa-qrcode"></span></a>
							<a href="{{route('sys.militares.pdf',$militar->id)}}" target="_blank" class="btn btn-flat btn-default">Exportar PDF <span class="text-red fa fa-file-pdf-o"></span></a>
						</center>
					</div>
					<div class="box-footer">
						<center>
							<button type="submit" class="btn btn-flat btn-success">Salvar <span class="fa fa-floppy-o"></span></button>
						</center>
					</div>
				</form>
			</div>
		</div>

		<div class="panel box box-warning">
			<a data-toggle="collapse" data-parent="#accordion" href="#historico">
				<div class="box-header with-border">
					<h4 class="box-title">
						<i class="fa fa-history"></i> Histórico
					</h4>
				</div>
			</a>
			<div id="historico" class="panel-collapse collapse">
				<div class="box-body">
					<ul>
						@forelse($log as $value)
						<li>
							<b class="text-info">Horário: </b>{{date('d/m/Y H:i', strtotime($value->data_hora))}}
							<b class="text-info">Operador: </b>{{$value->name}}
							<b class="text-info">Evento: </b> {{$value->evento}} - {{$value->descricao}}
						</li>
						@empty
						<li>
							<b class="text-danger">Nenhum registro encontrado!</b>
						</li>
						@endforelse
					</ul>
				</div>
			</div>
		</div>

		<div class="panel box box-primary">
			<a data-toggle="collapse" data-parent="#accordion" href="#documentos">
				<div class="box-header with-border">
					<h4 class="box-title">
						<i class="fa fa-folder-open"></i> Documentos
					</h4>
				</div>
			</a>
			
			<div id="documentos" class="panel-collapse collapse">
				<div class="box-body">
					<iframe src="/filemanager" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
				</div>
			</div>
		</div>

		<div class="modal modal-success fade" tabindex="-1" role="dialog" id="ativar-militar">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="fa fa-unlock"></i> Selecione o motivo</h4>
					</div>
					<form action="{{route('sys.militar.ativar', $militar->id)}}" class="form-horizontal form" method="post">
						<div class="modal-body">
							{{csrf_field()}}
							<select name="motivo-atv" class="form-control" id="motivo-atv" required>
								@foreach($evento as $value)
								@if($value->evento == 'ATIVOU MILITAR')
								<option value="{{$value->id}}">{{$value->descricao}}</option>
								@endif
								@endforeach
							</select>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-default"><i class="fa fa-floppy-o"></i> Salvar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal modal-danger fade" tabindex="-1" role="dialog" id="desativar-militar">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="fa fa-lock"></i> Selecione o motivo</h4>
					</div>
					<form action="{{route('sys.militar.desativar', $militar->id)}}" class="form-horizontal form" method="post">
						<div class="modal-body">
							{{csrf_field()}}
							<select name="motivo-dtv" class="form-control" id="motivo-dtv" required>
								@foreach($evento as $value)
								@if($value->evento == 'DESATIVOU MILITAR')
								<option value="{{$value->id}}">{{$value->descricao}}</option>
								@endif
								@endforeach
							</select>
							<p style="padding:5px;color:white;">
								<i class="fa  fa-exclamation-circle"></i> Caso o militar tenha automovéis cadastrados, todos serão desativados!
							</p>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-default"><i class="fa fa-floppy-o"></i> Salvar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		@stop