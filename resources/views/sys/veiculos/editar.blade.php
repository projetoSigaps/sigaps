@extends('adminlte::page')

@section('title', 'SIGAPS | Editar Veículo')

@section('content_header')
@stop

@section('content')

<?php

if($veiculo->baixa == 0){$status = 'Ativado';} else $status = 'Desativado'; 

?>

<div class="box box-warning">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-automobile"></i> Editar Veículo</h5>
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
		@if (session('success'))
		<div class="alert alert-sm alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<p class="text-green">
				<i class="icon fa fa-check"></i> {{ session('success') }}
			</p>
		</div>
		@endif

		<div class="panel panel-primary" id="panel-militar">
			<div class="panel-heading">Informações do Militar</div>
			<div class="panel-body">
				<table class="table">
					<tbody>
						<tr>
							<td>Nome Completo:</td>
							<td colspan="3"><span id="nome" class="text-primary">{{$militar->nome}}</span></td>
						</tr>
						<tr>
							<td>Nome de Guerra:</td>
							<td><span id="nome_guerra" class="text-primary">{{$militar->nome_guerra}}</span></td>
							<td>P/G:</td>
							<td><span id="posto" class="text-primary">{{$militar->posto_nome}}</span></td>
						</tr>
						<tr>
							<td>Identidade Militar:</td>
							<td><span id="ident_militar" class="text-primary">{{$militar->ident_militar}}</span></td>
							<td>OM:</td>
							<td><span id="om" class="text-primary">{{$militar->om_nome}}</span></td>
						</tr>
						<tr>
							<td>Número da CNH:</td>
							<td colspan="3"><span id="cnh" class="text-primary">{{$militar->cnh}}</span></td>
						</tr>
						<tr>
							<td>Categoria CNH:</td>
							<td><span id="cnh_cat" class="text-primary">{{$militar->cnh_cat}}</span></td>
							<td>Vencimento CNH:</td>
							<td><span id="cnh_venc" class="text-primary">{{date('d/m/Y', strtotime($militar->cnh_venc))}}</span></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="panel-footer">
				<a class="btn btn-flat btn-primary novo-veiculo">Novo Veículo <span class="fa fa-plus-square"></span></a>
				<input type="hidden" name="ident_militar" value="{{$militar->ident_militar}}">
			</div>
		</div>
		<div class="panel panel-success" id="panel-veiculo" >
			<div class="panel-heading">Informações do Veículo</div>
			<div class="panel-body">
				<form class="form form-horizontal" method="post" id="form-veiculo" action="{{route('sys.veiculos.cadastro.atualiza', $veiculo->id)}}">
					{{csrf_field()}}
					<div class="form-group">
						<div class="col-md-4">
							<label class="control-label">Tipo de veículo: </label>
							<select required class="form-control automovel_tipo" name="tipo_id" id="automovel_tipo" onchange="if($(this).find('option:selected').val()=='2'){$('#curso-moto').show(); }else{$('#curso-moto').hide(); }">
								@foreach($tp_veiculo as $value)
								<option <?php if($veiculo->tipo_id==$value->id) echo "selected"; ?> value="{{$value->id}}">{{$value->nome}}</option>
								@endforeach
							</select>
						</div>

						<div class="col-md-4">
							<label class="control-label">Marca do veículo: </label>
							<select required name="marca_id" id="automovel_marca" class="form-control automovel_marca">
								@foreach($marca as $value)
								<option <?php if($veiculo->marca_id==$value->id) echo "selected"; ?> value="{{$value->id}}">{{$value->nome}}</option>
								@endforeach
							</select>
						</div>

						<div class="col-md-4">
							<label class="control-label">Modelo do veículo: </label>
							<select required name="modelo_id" id="automovel_modelo" class="form-control automovel_modelo">
								@foreach($modelo as $value)
								<option <?php if($veiculo->modelo_id==$value->id) echo "selected"; ?> value="{{$value->id}}">{{$value->nome}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group has-feedback">
						<div class="field col-md-4">
							<input id="exercicio_documento" type="text" class="form-control maskNum" placeholder="Exercício">
							<span class="form-control-feedback" id="exercicio_documento1"></span>
						</div>
						<div class="field col-md-4">	

							<input id="placa" minlength="8" type="text" name="placa" class="form-control maskPlaca" placeholder="Placa" value="{{$veiculo->placa}}" required>
							<span class="form-control-feedback" id="placa1"></span>
						</div>
						<div class="field col-md-4">
							<input id="renavan" type="text" name="renavan" class="form-control maskNum" placeholder="Renavam" value="{{$veiculo->renavan}}" required>
							<span class="form-control-feedback" id="renavan1"></span>
						</div>
					</div>

					<div class="form-group has-feedback">
						<div class="field col-md-4">
							<input id="cor" type="text" name="cor" class="form-control" placeholder="Cor" value="{{$veiculo->cor}}" required>
							<span class="form-control-feedback" id="cor1"></span>
						</div>
						<div class="field col-md-4">
							<input id="doc_venc" type="text" name="doc_venc" class="form-control maskData" placeholder="Vencimento do documento" value="{{date('d/m/Y', strtotime($veiculo->doc_venc))}}" required>
							<span class="form-control-feedback" id="doc_venc1"></span>
						</div>
						<div class="field col-md-4">
							<input id="origem" type="text" name="origem" class="form-control" placeholder="Origem do veículo" value="{{$veiculo->origem}}" required>
							<span class="form-control-feedback" id="origem1"></span>
						</div>
					</div>
					<div class="form-group has-feedback">
						<div class="field col-md-4">
							<input id="ano_auto" type="text" name="ano_auto" class="maskAno form-control" placeholder="Ano do veículo" value="{{$veiculo->ano_auto}}" required>
							<span class="form-control-feedback" id="ano_auto1"></span>
						</div>
					</div>
					@if ($veiculo->baixa == 1)
					<div class="form-group has-error">
						@else
						<div class="form-group has-success">
							@endif
							<div class="col-md-4">
								<label class="control-label">Status: </label>
								<input class="form-control " id="status" value="{{$status}}" disabled="">
							</div>
						</div>

						@if($veiculo->baixa == 0)
						<a data-toggle="modal" data-target="#desativar-veiculo" target="_blank" class="btn btn-flat btn-danger">Desativar <span class="fa fa-lock"></span></a>
						@else($veiculo->status == 1)
						<a data-toggle="modal" data-target="#ativar-veiculo" target="_blank" class="btn btn-flat btn-success">Ativar <span class="fa fa-unlock"></span></a>
						@endif

						<a href="{{route('sys.cracha.veiculo',$veiculo->id)}}" target="_blank" class="btn btn-flat btn-warning">Gerar Crachá <span class=" fa fa-qrcode"></span></a>
						<button type="submit" class="btn btn-flat btn-primary" value="Salvar" >Salvar <i class="fa fa-floppy-o"></i></button>
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
		</div>
	</div>

	<div class="modal modal-success fade" tabindex="-1" role="dialog" id="ativar-veiculo">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><i class="fa fa-unlock"></i> Selecione o motivo</h4>
				</div>
				<form  action="{{route('sys.veiculo.ativar', $veiculo->id) }}" class="form-horizontal form" method="post">
					<div class="modal-body">
						{{csrf_field()}}
						<select name="motivo-atv" class="form-control" id="motivo-atv" required>
							@foreach($evento as $value)
							@if($value->evento == 'ATIVOU VEICULO')
							<option value="{{$value->id}}">{{$value->descricao}}</option>
							@endif
							@endforeach
						</select>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-default"><i class="fa fa-floppy-o"></i> Salvar</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal modal-danger fade" tabindex="-1" role="dialog" id="desativar-veiculo">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><i class="fa fa-lock"></i> Selecione o motivo</h4>
				</div>
				<form action="{{route('sys.veiculo.desativar', $veiculo->id) }}" class="form-horizontal form" method="post">
					<div class="modal-body">
						{{csrf_field()}}
						<select name="motivo-dtv" class="form-control" id="motivo-dtv" required>
							@foreach($evento as $value)
							@if($value->evento == 'DESATIVOU VEICULO')
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
	@stop