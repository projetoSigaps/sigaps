@extends('adminlte::page')

@section('title', 'SIGAPS | Tipo Veículos')

@section('content_header')

@stop

@section('content')
<div class="box box-red" style="border-top: 3px solid #dd4b39;">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-cog"></i> Tipo de Veículos</h5>
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
			<button data-toggle="modal" data-target="#cadastro-tipo-veiculo" type="button" class="btn btn-success" />Novo Registro <i class="fa fa-plus"></i></button>
		</div>
		<table width="100%" cellspacing="0" class="table text-center table-compact table-condensed table-hover tb_tipo_v">
			{{csrf_field()}}
			<thead>
				<tr style="background-color:#228B22;color:#FFFFFF;"> 
					<th style="text-align:center">Nome</th>
					<th style="text-align:center;">Ações</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>

		<div class="modal fade" tabindex="-1" role="dialog" id="cadastro-tipo-veiculo">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="fa fa-plus-circle"></i> Adicionar Registro</h4>
					</div>
					<form class="form-horizontal form" method="POST" action="{{route('sys.configuracoes.veiculos.tipo_veiculos.cadastrar')}}">
						<div class="modal-body">
							{{csrf_field()}}
							<div class="form-group">
								<label class="col-sm-3 control-label">Nome: </label>
								<div class="col-sm-6">
									<input class="form-control" type="text" name="nome" required="" />
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Salvar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" tabindex="-1" role="dialog" id="editar-tipo-veiculo">
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
								<label class="col-sm-3 control-label">Nome: </label>
								<div class="col-sm-8">
									<input class="form-control" type="text" name="nome_edt" id="nome_edt" required="">
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

	</div>
</div>
@stop