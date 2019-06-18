@extends('adminlte::page')

@section('title', 'SIGAPS | Postos')

@section('content_header')

@stop

@section('content')
<div class="box box-red" style="border-top: 3px solid #dd4b39;">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-cog"></i> Postos e Graduações</h5>
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
		<div class="botao pull-right" style="padding-bottom: 10px;">
			<button data-toggle="modal" data-target="#cadastro-posto" type="button" class="btn btn-success" />Novo Registro <i class="fa fa-plus"></i></button>
		</div>
		<table width="100%" cellspacing="0" class="table text-center table-compact table-condensed table-hover tb_posto">
			{{csrf_field()}}
			<thead>
				<tr style="background-color:#228B22;color:#FFFFFF;"> 
					<th style="text-align:center">Letra</th>
					<th style="text-align:center;">Posto/Graduação</th>
					<th style="text-align:center;">Tipo</th>
					<th style="text-align:center;">Ações</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>

		<div class="modal fade" tabindex="-1" role="dialog" id="cadastro-posto">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="fa fa-plus-circle"></i> Adicionar Registro</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal form" method="POST" action="{{route('sys.configuracoes.postos.cadastrar')}}">
							{{csrf_field()}}
							<div class="form-group">
								<label class="col-sm-3 control-label">Tipo: </label>
								<div class="col-sm-8">
									<select class="form-control" id="tipo" name="tipo" required="">
										<option value="" disabled selected>- Selecione -</option>
										<option value="1">[Letra A] Oficial General</option>
										<option value="2">[Letra B] Oficiais Superiores</option>
										<option value="3">[Letra C] Oficiais Subalternos/Intermediarios</option>
										<option value="4">[Letra D] Praças</option>
										<option value="5">[Letra E] Praças</option>
										<option value="6">[Letra F] Civil</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Nome do P/G: </label>
								<div class="col-sm-8">
									<textarea class="form-control" name="nome" id="nome" required=""></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Salvar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>


		<div class="modal fade" tabindex="-1" role="dialog" id="editar-posto">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="fa fa-plus-circle"></i> Editar Registro</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal form" method="POST">
							{{csrf_field()}}
							<div class="form-group">
								<label class="col-sm-3 control-label">Tipo: </label>
								<div class="col-sm-8">
									<select class="form-control" id="tipo_edt" name="tipo_edt" required="">
										<option value="1">[Letra A] Oficial General</option>
										<option value="2">[Letra B] Oficiais Superiores</option>
										<option value="3">[Letra C] Oficiais Subalternos/Intermediarios</option>
										<option value="4">[Letra D] Praças</option>
										<option value="5">[Letra E] Praças</option>
										<option value="6">[Letra F] Civil</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Nome do P/G: </label>
								<div class="col-sm-8">
									<textarea class="form-control" name="nome_edt" id="nome_edt" required=""></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success atualizar-posto"><i class="fa fa-floppy-o"></i> Salvar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>


	</div>
</div>
@stop