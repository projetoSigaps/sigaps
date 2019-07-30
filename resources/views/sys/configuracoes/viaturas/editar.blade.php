@extends('adminlte::page')

@section('title', 'SIGAPS | Editar Viatura')

@section('content_header')

@stop

@section('content')
<?php

if($viatura->baixa == 1){$status = 'Ativado';} else $status = 'Desativado'; 

?>

<div class="box box-red" style="border-top: 3px solid #dd4b39;">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-gear"></i> Editar Viatura</h5>
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
		<div class="panel panel-warning">
			<div class="panel-heading">Escolha a OM</div>
			<div class="panel-body">
				<form class="form-horizontal" id="form-viatura" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						<div class="col-md-4">
							<select class="form-control" name="om_viatura" disabled>
								<option value="{{$om->id}}" selected >{{$om->nome}}</option>
							</select>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="panel panel-success" id="panel-viatura">
			<div class="panel-heading">Informações da Viatura</div>
			<div class="panel-body">
				<form class="form form-horizontal" method="post" id="form-veiculo" action="{{route('sys.configuracoes.viaturas.atualiza', $viatura->id)}}">
					{{csrf_field()}}
					<input type="hidden" id="om_id" name="om_id" value="{{$om->id}}">
					<div class="form-group">
						<div class="col-md-4">
							<label class="control-label">Tipo de veículo: </label>
							<select class="form-control automovel_tipo" name="tipo_id">
								<option value="" disabled selected>- Selecione -</option>
								<option value="3" selected>VIATURA MILITAR</option>
							</select>
						</div>

						<div class="col-md-4">
							<label class="control-label">Marca da viatura: </label>
							<select required name="marca_id" id="automovel_marca" class="form-control automovel_marca">
								@foreach($marca as $value)
								<option <?php if($viatura->marca_id==$value->id) echo "selected"; ?> value="{{$value->id}}">{{$value->nome}}</option>
								@endforeach
							</select>
						</div>

						<div class="col-md-4">
							<label class="control-label">Modelo do viatura: </label>
							<select required name="modelo_id" id="automovel_modelo" class="form-control automovel_modelo">
								@foreach($modelo as $value)
								<option <?php if($viatura->modelo_id==$value->id) echo "selected"; ?> value="{{$value->id}}">{{$value->nome}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group has-feedback">
						<div class="field col-md-4">
							<label class="control-label">Categoria: </label>
							<select required name="categoria" id="categoria" class="form-control">
								<option selected>- Selecione -</option>
								<option <?php if($vtr->cat=="ADM") echo "selected"; ?> value="ADM">Administrativa</option>
								<option <?php if($vtr->cat=="OP") echo "selected"; ?> value="OP">Operacional</option>
							</select>
						</div>
					</div>

					<div class="form-group has-feedback">
						<div class="field col-md-4">	
							<input id="placa" value="{{$viatura->placa}}" minlength="8" type="text" name="placa" class="form-control" placeholder="Placa / EB" required>
							<span class="form-control-feedback" id="placa1"></span>
						</div>
						<div class="field col-md-4">
							<input id="renavan" value="{{$viatura->renavan}}" type="text" name="renavam" class="form-control maskNum" placeholder="Renavam" required>
							<span class="form-control-feedback" id="renavan1"></span>
						</div>
						<div class="field col-md-4">
							<input id="cor" type="text" value="{{$viatura->cor}}" name="cor" class="form-control" placeholder="Cor" required>
							<span class="form-control-feedback" id="cor1"></span>
						</div>
					</div>

					<div class="form-group has-feedback">
						<div class="field col-md-4">
							<input id="doc_venc" type="text" name="doc_venc" class="form-control maskData" placeholder="Vencimento do documento" value="{{date('d/m/Y', strtotime($viatura->doc_venc))}}" required>
							<span class="form-control-feedback" id="doc_venc1"></span>
						</div>
						<div class="field col-md-4">
							<input id="ano_auto" type="text" value="{{$viatura->ano_auto}}" name="ano_auto" class="maskAno form-control" placeholder="Ano da viatura" required>
							<span class="form-control-feedback" id="ano_auto1"></span>
						</div>
					</div>

					<div class="form-group">
						<div class="field col-md-4">
							<label class="control-label">Viatura de CMT : </label>
							<p>
								<label class="radio-inline">
									<input <?php if($vtr->vtr_cmt==1) echo "checked"; ?> type="radio" name="vtr_cmt" value="1"> Sim
								</label>
								<label class="radio-inline">
									<input <?php if($vtr->vtr_cmt==0) echo "checked"; ?> type="radio" name="vtr_cmt" value="0"> Não
								</label>
							</p>
						</div>
					</div>
					@if ($viatura->baixa == 0)
					<div class="form-group has-error">
						@else
						<div class="form-group has-success">
							@endif
							<div class="col-md-4">
								<label class="control-label">Status: </label>
								<input class="form-control " id="status" value="{{$status}}" disabled="">
							</div>
						</div>
						<hr>

						@if($viatura->baixa == 1)
						<a href="{{route('sys.configuracoes.viaturas.desativar',$viatura->id)}}" class="btn btn-flat btn-danger">Desativar <span class="fa fa-lock"></span></a>
						@else($viatura->status == 0)
						<a href="{{route('sys.configuracoes.viaturas.ativar',$viatura->id)}}" class="btn btn-flat btn-success">Ativar <span class="fa fa-unlock"></span></a>
						@endif
						<a href="{{route('sys.cracha.viatura',$viatura->id)}}" target="_blank" class="btn btn-flat btn-warning">Gerar Crachá 
							<span class=" fa fa-qrcode"></span>
						</a>
						<button type="submit" class="btn btn-flat btn-success" value="Salvar" >Salvar <i class="fa fa-floppy-o"></i></button>
					</form>
				</div>
			</div>


		</div>
	</div>
	@stop