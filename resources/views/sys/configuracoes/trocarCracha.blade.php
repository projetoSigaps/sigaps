@extends('adminlte::page')

@section('title', 'SIGAPS | Trocar Crachá')

@section('content_header')
@stop

@section('content')
<div class="box box-red" style="border-top: 3px solid #dd4b39;">
	<div class="box-header">
		<h5 class="box-title"><i class="icon fa fa-cog"></i>   Trocar Crachá</h5>
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
		<div class="alert alert-warning alert-trocaCracha">
			<h4><i class="icon fa fa-warning"></i> ATENÇÃO!</h4>
			Esta opção só pode ser utilizada em casos de extravio de crachá.
			<p> Informações Importantes: </p>
			<ul style="text-align:justify;margin-top: 10px;">
				<li>
					<b>Ao fazer a troca, será necessário realizar uma nova impressão do crachá individual.</b>
				</li>
				<li>
					<b>Caso o militar tenha algum veiculo vinculado ao seu cadastro, não é necessário realizar a re-impressão do crachá do veículo.</b>
				</li>
				<li>
					<b>Após a troca, o crachá antigo ficará inutilizável, ou seja, o sistema não reconhecerá mais o crachá antigo.</b>
				</li>
				<li>
					<b>Ao realizar esta operação, a mesma não poderá ser mais desfeita.</b>
				</li>
				<li>
					<b>O histórico de entrada e saída NÃO É PERDIDO, nem os dados cadastrais.</b>
				</li>
			</ul>
		</div>

		<div class="well">
			<center>
				<p><b>Eu li, estou ciente e me resposabilizo pelas informações acima.</b></p>
				<input type="checkbox" name="ciente_trocaCracha" class="checkbox_cracha">
			</center>
		</div>
		<div class="panel panel-warning panel-pesquisa" style="display: none;">
			<div class="panel-heading">Pesquisar Militar</div>
			<div class="panel-body">
				<form class="form-horizontal" id="form-pesquisa" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						<div class="col-md-2">
							<select class="form-control" id="documentacao_tipo" disabled>
								<option value="ident_militar" selected>Identidade Militar</option>
							</select>
						</div>
						<div class="col-md-3">
							<input type="text" id="numero_documento" class="maskIdentidade form-control"  placeholder="Número do documento" >
						</div>
						<div class="col-md-3">
							<button class="btn btn-flat btn-default buscar-militar" type="submit" onclick="return false;" id="buscar-militar">
								Pesquisar <i class="fa fa-search"></i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="panel panel-primary" id="panel-militar" style="display: none;">
			<div class="panel-heading">Informações do Militar</div>
			<div class="panel-body">
				<table class="table">
					<tbody>
						<tr>
							<td>Nome Completo:</td>
							<td colspan="3"><span id="nome" class="text-primary"></span></td>
						</tr>
						<tr>
							<td>Nome de Guerra:</td>
							<td><span id="nome_guerra" class="text-primary"></span></td>
							<td>P/G:</td>
							<td><span id="posto" class="text-primary"></span></td>
						</tr>
						<tr>
							<td>Identidade Militar:</td>
							<td><span id="ident_militar" class="text-primary"></span></td>
							<td>OM:</td>
							<td><span id="om" class="text-primary"></span></td>
						</tr>
						<tr>
							<td>Número da CNH:</td>
							<td colspan="3"><span id="cnh" class="text-primary"></span></td>
						</tr>
						<tr>
							<td>Categoria CNH:</td>
							<td><span id="cnh_cat" class="text-primary"></span></td>
							<td>Vencimento CNH:</td>
							<td><span id="cnh_venc" class="text-primary"></span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop