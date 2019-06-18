@extends('adminlte::page')

@section('title', 'SIGAPS | Cadastrar Viaturas')

@section('content_header')

@stop

@section('content')
<div class="box box-red" style="border-top: 3px solid #dd4b39;">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-gear"></i> Cadastrar Viaturas</h5>
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
		<div class="panel panel-warning">
			<div class="panel-heading">Escolha a OM</div>
			<div class="panel-body">
				<form class="form-horizontal" id="form-viatura" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						<div class="col-md-4">
							<select class="form-control" name="om_viatura">
								<option value="" disabled selected>- Selecione -</option>
								@foreach($om as $value)
								<option value="{{$value->id}}">{{$value->nome}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="panel panel-success" id="panel-viatura" style="display: none;" >
			<div class="panel-heading">Informações da Viatura</div>
			<div class="panel-body">
				<form class="form form-horizontal" method="post" id="form-veiculo" action="{{route('sys.configuracoes.viaturas.salvar')}}">
					{{csrf_field()}}
					<input type="hidden" id="om_id" name="om_id">
					<div class="form-group">
						<div class="col-md-4">
							<label class="control-label">Tipo de veículo: </label>
							<select class="form-control automovel_tipo" name="tipo_id" required>
								<option value="" disabled selected>- Selecione -</option>
								<option value="3">VIATURA MILITAR</option>
							</select>
						</div>

						<div class="col-md-4">
							<label class="control-label">Marca da viatura: </label>
							<select required name="marca_id" id="automovel_marca" class="form-control automovel_marca" disabled>
							</select>
						</div>

						<div class="col-md-4">
							<label class="control-label">Modelo do viatura: </label>
							<select required name="modelo_id" id="automovel_modelo" class="form-control automovel_modelo" disabled>
							</select>
						</div>
					</div>

					<div class="form-group has-feedback">
						<div class="col-md-4">
							<label class="control-label">Categoria: </label>
							<select required name="categoria" id="categoria" class="form-control">
								<option value="" disabled selected>- Selecione -</option>
								<option value="ADM">Administrativa</option>
								<option value="OP">Operacional</option>
							</select>
						</div>
					</div>

					<div class="form-group has-feedback">
						<div class="field col-md-4">	
							<input id="placa" minlength="8" type="text" name="placa" class="form-control maskPlaca" placeholder="Placa / EB" required>
							<span class="form-control-feedback" id="placa1"></span>
						</div>
						<div class="field col-md-4">
							<input id="renavan" type="text" name="renavam" class="form-control maskNum" placeholder="Renavam" required>
							<span class="form-control-feedback" id="renavan1"></span>
						</div>
						<div class="field col-md-4">
							<input id="cor" type="text" name="cor" class="form-control" placeholder="Cor" required>
							<span class="form-control-feedback" id="cor1"></span>
						</div>
					</div>

					<div class="form-group has-feedback">
						<div class="field col-md-4">
							<input id="doc_venc" type="text" name="doc_venc" class="form-control maskData" placeholder="Vencimento do documento" required>
							<span class="form-control-feedback" id="doc_venc1"></span>
						</div>
						<div class="field col-md-4">
							<input id="ano_auto" type="text" name="ano_auto" class="maskAno form-control" placeholder="Ano da viatura" required>
							<span class="form-control-feedback" id="ano_auto1"></span>
						</div>
					</div>

					<div class="form-group">
						<div class="field col-md-4">
							<label class="control-label">Viatura de CMT : </label>
							<p>
								<label class="radio-inline">
									<input type="radio" name="vtr_cmt" value="1"> Sim
								</label>
								<label class="radio-inline">
									<input type="radio" name="vtr_cmt" value="0" checked> Não
								</label>
							</p>
						</div>
					</div>
					<button type="submit" class="btn btn-flat btn-success" value="Salvar" >Salvar <i class="fa fa-floppy-o"></i></button>
				</form>
			</div>
		</div>


	</div>
</div>
@stop