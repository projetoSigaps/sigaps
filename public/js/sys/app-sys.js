$(document).ready(function () {

	function stopPropagation(evt) {
		if (evt.stopPropagation !== undefined) {
			evt.stopPropagation();
		} else {
			evt.cancelBubble = true;
		}
	}

	function verificaNumero(e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	}

	/* TRANSFORMA TODOS INPUT EM LETRA MAIUSCULA */
	$('input[type=text]').each(function () {
		$(this).val($(this).val().toUpperCase());
		$(this).bind('keyup', function () {
			$(this).val($(this).val().toUpperCase());
		});
	});

	$(".checkbox_cracha").change(function () {
		if (this.checked) {
			$('.panel-pesquisa').show();
		} else {
			$('.panel-pesquisa').hide();
			$('#panel-militar').hide();
		}
	});

	$('#cor_cracha').colorpicker();

	$('select[name="mes_cnh"]').change(function () {
		$('input[name="ano_cnh"]').removeAttr('disabled');
		if ($(this).val() == 00) {
			$('input[name="ano_cnh"]').prop('disabled', true);
		}
	});

	$('select[name="mes_doc"]').change(function () {
		$('input[name="ano_doc"]').removeAttr('disabled');
		if ($(this).val() == 00) {
			$('input[name="ano_doc"]').prop('disabled', true);
		}
	});

	$("select[name='om_viatura']").change(function () {
		var om = $("select[name='om_viatura']").val();
		$("input[name='om_id']").val(om);
		$('#panel-viatura').show();
	});

	$("#tooltip").tooltip({ placement: 'right' });
	$(".maskNum").keypress(verificaNumero);

	/*
	*
	* MASCARAS
	*
	*/

	$(".maskPlaca").mask("SSS-9999"), { clearIfNotMatch: true };
	$(".maskPlaca").keyup(function () {
		$(this).val($(this).val().toUpperCase());
	});

	$(".maskCNHCAT").keyup(function () {
		$(this).val($(this).val().toUpperCase());
		$(".maskCNHCAT").mask("S/S/S/S/S");
	});

	$(".maskData").keyup(function () {
		$(this).mask("00/00/0000", { clearIfNotMatch: true });
		$(this).keypress(verificaNumero);
	});

	$(".maskDataHora").mask("99/99/9999 99:99");
	$(".maskDataHora").keypress(verificaNumero);
	$(".maskHora").mask("99:99");
	$(".maskHora").keypress(verificaNumero);
	$(".maskAno").mask("9999");
	$(".maskAno").keypress(verificaNumero);
	$(".maskTelefone").mask('(00) 00000-0000', { clearIfNotMatch: true });
	$(".maskTelefone").keypress(verificaNumero);
	$(".maskCPF").mask("999.999.999-99");
	$(".maskCPF").keypress(verificaNumero);
	$(".maskIdentidade").mask("999999999-9");
	$(".maskIdentidade").keypress(verificaNumero);
	$(".maskCNPJ").mask("99.999.999/9999-99");
	$(".maskCNPJ").keypress(verificaNumero);
	$(".maskCEP").mask('00000-000', { clearIfNotMatch: true });
	$(".maskCEP").keypress(verificaNumero);
	$(".maskMoney").mask("000.000.000,00", { reverse: true });
	$(".maskMoney").keypress(verificaNumero);


	$('#placa').unmask();
	$('#categoria').change(function () {
		var cat = $(this).find('option:selected').val();
		if (cat == "OP") $('#placa').val('').unmask();
		if (cat == "ADM") $('#placa').val('').mask("SSS-9999");
	});

	$.validator.addMethod(
		"regex",
		function (value, element, regexp) {
			var check = false;
			return this.optional(element) || regexp.test(value);
		},
		"A senha dever ter letras e números."
	);

	$('button[name="trocar_ps"]').on('click', function () {
		var $val = $("input[name='login_usuario']").val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.form input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/webservices/configuracoes/usuario",
			dataType: 'json',
			data: { login: $val },
			type: "POST",
			success: function (data) {
				if (data.error) {
					alert(data.error);
				} else
					alert(data.msg);
			}
		});
	});

	$('.form-senha').validate({
		rules: {
			password_new: {
				minlength: 6,
				required: true,
				regex: /(?!^\d+$)^.+$/i,
			},
			password_confirmation: {
				minlength: 6,
				required: true,
				regex: /(?!^\d+$)^.+$/i,
				equalTo: "#password_new"
			}
		},
		errorElement: 'span'
	});

	/*
	*
	* CONSULTA CEP
	*
	*/
	$(".maskCEP").keyup(function (event) {
		// recupera o valor do cep
		var $v = $(this).val();

		// impede de fazer mais de uma consulta se ja estiver sendo executada
		if ($('body').find('#box-opaco-find').length > 0) {
			return false;
		}

		// se o cep estiver com 9digitos (completo)
		if ($v.length == 9 && event.which != 13) {
			// cria a div pra bloquear a tela
			$bx = '<div id="box-opaco-find" class="box-opaco"></div>';
			$('body').append($bx);

			$v = $(this).val().replace(/\D/g, '');
			// envia um ajax para viacep solicitando os dados
			$.ajax({
				url: "https://viacep.com.br/ws/" + $v + "/json/",
				type: "GET",
				success: function ($rep) {
					if ($rep.erro) {
						$('body').find('#box-opaco-find').remove();
						alert('Cep não encontrado, digite manualmente o endereço!');
						$('input[name=cidade]').val('');
						$('input[name=estado]').val('');
						$('input[name=endereco]').val('');
						$('input[name=bairro]').val('');
						$('input[name=estado]').focus();
					} else {
						// completa os inputs com os valores retornados
						$('input[name=cidade]').val($rep.localidade);
						$('input[name=estado]').val($rep.uf);
						$('input[name=endereco]').val($rep.logradouro);
						$('input[name=bairro]').val($rep.bairro);
						$('input[name=numero]').focus();
						$('body').find('#box-opaco-find').remove();
					}
				},
				error: function () // se estiver sem conexao com a internet vai vir para cá
				{
					alert('Erro ao estabilizar conexão com ws,\ncontate o administrador do sistema');
					$('body').find('#box-opaco-find').remove();
				}
			});
		}
	});


	/*
	*
	* AÇÕES PARA CADASTRAR UM NOVO VEÍCULO
	*
	*/


	$('.novo-veiculo').click(function () {
		var $num_doc = $("input[name='ident_militar']").val();
		var npage = window.open('/veiculos/cadastro');
		npage.addEventListener('load', setValues, true);

		function setValues() {
			$(npage.document).contents().find('#documentacao_tipo').val("ident_militar");
			$(npage.document).contents().find('#numero_documento').val($num_doc);
		};
	});


	$('#documentacao_tipo').change(function () {
		var $t = $(this).find('option:selected').val();
		if ($t == "cnh") $('#numero_documento').val('').unmask().keypress(verificaNumero);
		if ($t == "ident_militar") $('#numero_documento').val('').unmask().mask("999999999-9").keypress(verificaNumero);
	});


	$('.buscar-militar').click(function () {
		/* Limpa o formulario */
		$("#form-veiculo").find(".field").removeClass("has-success");
		$("#form-veiculo").find(".fa").removeClass("fa-check");

		$('body').append('<div id="box-opaco-find" class="box-opaco"></div>');
		var $tip_doc = $('#documentacao_tipo').find('option:selected').val();
		var $num_doc = $('#numero_documento').val();

		if (!$num_doc) {
			alert("Preencha o número do documento");
			$('body').find('#box-opaco-find').remove();
			return false;
		}
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('#form-pesquisa input[name=_token]').val()
			}
		});
		$.ajax({
			type: "POST",
			url: "/webservices/militares/pesquisar",
			dataType: "JSON",
			data: { tipo_documento: $tip_doc, numero_documento: $num_doc },
			success: function (data) {
				$('body').find('#box-opaco-find').remove();
				$("#form-veiculo").trigger('reset');
				$('#numero_documento').val('');
				$("#nome").html(data.nome);
				$("#nome_guerra").html(data.nome_guerra);
				$("#posto").html(data.posto_nome);
				$("#militar_id").val(data.militar_id);
				$("#ident_militar").html(data.ident_militar);
				$("#om").html(data.om_nome);
				$("#cnh").html(data.cnh);
				$("#cnh_cat").html(data.cnh_cat);
				$("#cnh_venc").html(data.cnh_venc);
				$('#panel-militar').show();
				$('#panel-veiculo').show();
				$('#panel-alert').hide();

				if (!data.cnh || !data.cnh_cat || !data.cnh_venc) {
					$('#panel-alert').show();
					$('#panel-veiculo').hide();
				}

				if (data.error) {
					$('body').find('#box-opaco-find').remove();
					$('#numero_documento').val('');
					$('#numero_documento').focus();
					$('#panel-militar').hide();
					$('#panel-veiculo').hide();
					$('#panel-alert').hide();
					alert(data.error);
				}
			}

		});
	});

	/*
	*
	* CONSULTAS PARA TIPO E MARCA DE AUTO
	*
	*/

	$('.automovel_tipo').change(function () {
		$('.automovel_marca').prop("disabled", true);
		$('.automovel_modelo').prop("disabled", true);
		$('.automovel_modelo').html('');
		$('.automovel_marca').html('');
		var $id = $(this).find('option:selected').val();
		$('body').append('<div id="box-opaco-find" class="box-opaco"></div>');
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.form input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/webservices/veiculos/marca/pesquisar",
			type: "POST",
			dataType: 'html',
			data: { id_tipo: $id },
			success: function (data) {
				if (data) {
					$('body').find('#box-opaco-find').remove();
					$('.automovel_marca').prop("disabled", false);
					$('.automovel_marca').html('<option value="" disabled selected>- Selecione -</option>').append(data);
				}
				else {
					$('body').find('#box-opaco-find').remove();
				}
			}
		});
	});

	$('.automovel_marca').change(function () {
		var $id = $(this).find('option:selected').val();
		$('body').append('<div id="box-opaco-find" class="box-opaco"></div>');
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.form input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/webservices/veiculos/modelo/pesquisar",
			type: "POST",
			data: { id_marca: $id },
			success: function (data) {
				if (data) {
					$('body').find('#box-opaco-find').remove();
					$('.automovel_modelo').prop("disabled", false);
					$('.automovel_modelo').html('<option value="" disabled selected>- Selecione -</option>').append(data);
				}
				else {
					$('body').find('#box-opaco-find').remove();
					$('.automovel_modelo').prop("disabled", true);
					$('.automovel_modelo').html('');
				}
			}
		});
	});

	/*
	*
	* VERIFICAÇÃO DE REGISTROS DUPLICADOS
	*
	*/

	$('.form input[name=ident_militar]').change(function () {
		var $inp = $(this);
		var $val = $(this).val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.form input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/webservices/validacao/identidade",
			type: "POST",
			dataType: 'json',
			data: { ident_militar: $val },
			success: function (data) {
				if (data.error) {
					alert(data.error);
					$("#ident_militar1").removeClass('fa fa-check fa-lg').addClass('fa fa-remove fa-lg');
					$inp.closest('.field').removeClass('has-success').addClass('has-error');
					return $inp.val('').focus();
				}
			}
		});
	});

	$('.form input[name=cnh]').change(function () {
		var $inp = $(this);
		var $val = $(this).val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.form input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/webservices/validacao/cnh",
			type: "POST",
			dataType: 'json',
			data: { cnh: $val },
			success: function (data) {
				if (data.error) {
					alert(data.error);
					$("#cnh1").removeClass('fa fa-check fa-lg').addClass('fa fa-remove fa-lg');
					$inp.closest('.field').removeClass('has-success').addClass('has-error');
					return $inp.val('').focus();
				}
			}
		});
	});

	$('.form input[name=placa]').change(function () {
		var $inp = $(this);
		var $val = $(this).val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.form input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/webservices/validacao/placa",
			type: "POST",
			dataType: 'json',
			data: { placa: $val },
			success: function (data) {
				if (data.error) {
					alert(data.error);
					$("#placa1").removeClass('fa fa-check fa-lg').addClass('fa fa-remove fa-lg');
					$inp.closest('.field').removeClass('has-success').addClass('has-error');
					return $inp.val('').focus();
				}
			}
		});
	});

	$('.form input[name=renavan]').change(function () {
		var $inp = $(this);
		var $val = $(this).val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.form input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/webservices/validacao/renavam",
			type: "POST",
			dataType: 'json',
			data: { renavam: $val },
			success: function (data) {
				if (data.error) {
					alert(data.error);
					$("#renavan1").removeClass('fa fa-check fa-lg').addClass('fa fa-remove fa-lg');
					$inp.closest('.field').removeClass('has-success').addClass('has-error');
					return $inp.val('').focus();
				}
			}
		});
	});

	/*
	*
	* VALIDAÇÃO DOS FORMULÁRIOS
	*
	*/

	$('.form').validate({
		highlight: function (element) {
			var id_attr = "#" + $(element).attr("id") + "1";
			$(element).closest('.field').removeClass('has-success').addClass('has-error');
			$(id_attr).removeClass('fa fa-check fa-lg').addClass('fa fa-remove fa-lg');
		},
		unhighlight: function (element) {
			var id_attr = "#" + $(element).attr("id") + "1";
			$(element).closest('.field').removeClass('has-error').addClass('has-success');
			$(id_attr).removeClass('fa fa-remove fa-lg').addClass('fa fa-check fa-lg');
		},
		errorElement: 'span',
		errorClass: 'help-block',
		errorPlacement: function (error, element) {
			if (element.length) {
				error.insertAfter(element);
			} else {
				error.insertAfter(element);
			}
		}
	});

	/*
	*
	* RELATÓRIOS
	*
	*/

	$('.cod_cracha').keyup(function () {

		$('select[name="rel_om"]').attr('disabled', 'disabled');
		$('select[name="rel_posto"]').attr('disabled', 'disabled');
		$('select[name="rel_om"]').val(0).change();
		$('select[name="rel_posto"]').val(0).change();

		if ($(this).val() == '') {
			$('select[name="rel_om"]').removeAttr('disabled');
			$('select[name="rel_posto"]').removeAttr('disabled');
		}
	});

	$("#btn-pedestre").hide();
	$("#btn-auto").hide();
	$("#tpRelatorio_ped").click(function () {
		$('.cod_cracha').val('');
		$('select[name="rel_posto"]').removeAttr('disabled');
		$('select[name="rel_om"]').removeAttr('disabled');
		$("#btn-auto").hide();
		$("#btn-pedestre").show();
	});

	$("#tpRelatorio_aut").click(function () {
		$('.cod_cracha').val('');
		$('select[name="rel_posto"]').removeAttr('disabled');
		$('select[name="rel_om"]').removeAttr('disabled');
		$("#btn-auto").show();
		$("#btn-pedestre").hide();
	});

	$("#tpRelatorio_vtr").click(function () {
		$('.cod_cracha').val('');
		$('select[name="rel_posto"]').val(0).change();
		$('select[name="rel_posto"]').attr('disabled', 'disabled');
		$("#btn-auto").show();
		$("#btn-pedestre").hide();
	});

	$('#relatorio-automovel').click(function () {
		var form = $('.form').serialize();
		$.download('/relatorios/automoveis', decodeURIComponent(form), 'post');
	});

	$('#relatorio-militar').click(function () {
		var form = $('.form').serialize();
		$.download('/relatorios/militares', decodeURIComponent(form), 'post');
	});

	$('#relatorio-horario-auto').click(function () {
		var form = $('.form').serialize();
		$.download('/relatorios/horarios/automoveis', decodeURIComponent(form), 'post');
	});

	$('#relatorio-horario-pedestre').click(function () {
		var form = $('.form').serialize();
		$.download('/relatorios/horarios/pedestres', decodeURIComponent(form), 'post');
	});


	$('button[name="trocar_cracha"]').on('click', function () {
		var $item = $(".table").find(".ident_militar:first").text();
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/configuracoes/cracha/trocar",
			type: "POST",
			dataType: 'json',
			data: { ident_militar: $item },
			success: function (data) {
				if (data.error) {
					alert(data.error);
				} else {
					alert(data.msg);
				}
			}
		});
	});



	$('.tb_posto tbody').on('click', 'tr td button', function () {
		var $val = $(this).attr('id');
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.form input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/webservices/posto/consulta",
			type: "POST",
			dataType: 'json',
			data: { id: $val },
			success: function (data) {
				$("#editar-posto").modal('show');
				$("#nome_edt").val(data.nome);
				$("#tipo_edt").val(data.tipo);
				$('.form').attr('action', '/configuracoes/postos/editar/' + data.id);
			}
		});
	});

	$('.tb_tipo_v tbody').on('click', 'tr td button', function () {
		var $val = $(this).attr('id');
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.form input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/webservices/tipo_veiculo/consulta",
			type: "POST",
			dataType: 'json',
			data: { id: $val },
			success: function (data) {
				$("#editar-tipo-veiculo").modal('show');
				$("#nome_edt").val(data.nome);
				$('.form').attr('action', '/configuracoes/veiculos/tipo/editar/' + data.id);
			}
		});
	});

	$('.tb_marca_v tbody').on('click', 'tr td button', function () {
		var $val = $(this).attr('id');
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.form input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/webservices/marca_veiculo/consulta",
			type: "POST",
			dataType: 'json',
			data: { id: $val },
			success: function (data) {
				$("#editar-marca-veiculo").modal('show');
				$("#nome_edt").val(data.nome);
				$("#tipo_edt").val(data.tipo_id);
				$('.form').attr('action', '/configuracoes/veiculos/marca/editar/' + data.id);
			}
		});
	});

	$('.tb_modelo_v tbody').on('click', 'tr td button', function () {
		$('#marca_edt').empty();
		var $val = $(this).attr('id');
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.form input[name=_token]').val()
			}
		});
		$.ajax({
			url: "/webservices/modelo_veiculo/consulta",
			type: "POST",
			dataType: 'json',
			data: { id: $val },
			success: function (data) {
				$("#editar-modelo-veiculo").modal('show');
				$("#modelo_edt").val(data.modelo.nome);
				$("#tipo_edt").val(data.modelo.tipo_id);
				$('.form').attr('action', '/configuracoes/veiculos/modelo/editar/' + data.modelo.id);
				$.each(data.marca, function (k, v) {
					$('<option>').val(v.id).text(v.nome).appendTo('#marca_edt');
				});
				$('#marca_edt').val(data.modelo.marca_id).attr('selected', true);
			}
		});
	});

	var table_auto = $('.tb_auto').DataTable({
		lengthChange: false,
		pageLength: 20,
		ordering: false,
		processing: true,
		serverSide: true,
		language: {
			url: "/js/sys/components/datatables_pt-BR.json"
		},
		ajax: {
			url: '/webservices/militares/listagem',
			dataType: 'json',
			type: "POST",
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		},
		columns: [
			{
				className: 'details-control',
				orderable: false,
				data: null,
				defaultContent: ''
			},
			{ data: 'posto_nome' },
			{ data: 'nome_guerra' },
			{ data: 'nome' },
			{ data: 'ident_militar' },
			{ data: 'om_nome' }
		]
	});

	function format(rowData) {
		var div = $('<div>').addClass('loading').text('Processando ...');
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		});
		$.ajax({
			url: '/webservices/veiculos/pesquisar',
			type: 'POST',
			data: {
				id: rowData.id
			},
			dataType: 'html',
			success: function (json) {
				div.html(json).removeClass('loading');
			}
		});
		return div;
	}

	var detailRows = [];


	$('.tb_auto tbody').on('click', 'tr td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = table_auto.row(tr);
		var idx = $.inArray(tr.attr('id'), detailRows);

		if (row.child.isShown()) {
			tr.removeClass('details');
			row.child.hide();
			detailRows.splice(idx, 1);
		}
		else {
			tr.addClass('details');
			row.child(format(row.data())).show();

			if (idx === -1) {
				detailRows.push(tr.attr('id'));
			}
		}
	});

	table_auto.on('draw', function () {
		$.each(detailRows, function (i, id) {
			$('#' + id + ' td.details-control').trigger('click');
		});
	});

	$(".tb_auto thead input").on('keyup change', function () {
		table_auto
			.column($(this).parent().index() + ':visible')
			.search(this.value)
			.draw();
	});

	var tb_vtr = $('.tb_vtr').DataTable({
		searching: false,
		pageLength: 25,
		ordering: false,
		language: {
			url: "/js/sys/components/datatables_pt-BR.json"
		},
		ajax: {
			url: '/configuracoes/viaturas/listagem',
			dataType: 'json',
			type: "POST",
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		},
		columns: [
			{
				className: 'details-control',
				orderable: false,
				data: null,
				defaultContent: ''
			},
			{ data: 'nome' },
			{ data: 'descricao' },
			{ data: 'codom' }
		]
	});


	function detalhaVtr(rowData) {
		var div = $('<div>').addClass('loading').text('Processando ...');
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		});
		$.ajax({
			url: '/webservices/viaturas/pesquisar',
			type: 'POST',
			data: {
				id: rowData.id
			},
			dataType: 'html',
			success: function (json) {
				div.html(json).removeClass('loading');
			}
		});
		return div;
	}

	$('.tb_vtr tbody').on('click', 'tr td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = tb_vtr.row(tr);
		var idx = $.inArray(tr.attr('id'), detailRows);

		if (row.child.isShown()) {
			tr.removeClass('details');
			row.child.hide();
			detailRows.splice(idx, 1);
		}
		else {
			tr.addClass('details');
			row.child(detalhaVtr(row.data())).show();

			if (idx === -1) {
				detailRows.push(tr.attr('id'));
			}
		}
	});
	tb_vtr.on('draw', function () {
		$.each(detailRows, function (i, id) {
			$('#' + id + ' td.details-control').trigger('click');
		});
	});

	var table = $('.tb').DataTable({
		lengthChange: false,
		ordering: false,
		pageLength: 20,
		processing: true,
		serverSide: true,
		ajax: {
			url: '/webservices/militares/listagem',
			dataType: 'json',
			type: "POST",
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		},
		language: {
			url: "/js/sys/components/datatables_pt-BR.json"
		},
		columns: [
			{ data: 'id' },
			{ data: 'posto_nome' },
			{ data: 'nome_guerra' },
			{ data: 'nome' },
			{ data: 'ident_militar' },
			{ data: 'om_nome' },
			{ data: 'status' },
			{ data: 'options' }
		]
	});

	var tb_pedestre = $('.tb_pedestre').DataTable({
		searching: false,
		ordering: false,
		lengthMenu: [20, 40, 60, 100, 200, 500, 1000],
		processing: true,
		serverSide: true,
		language: {
			url: "/js/sys/components/datatables_pt-BR.json"
		},
		ajax: {
			url: '/webservices/consultas/pedestres',
			type: 'POST',
			dataSrc: 'data',
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		},
		columns: [
			{ data: 'posto_nome' },
			{ data: 'nome_guerra' },
			{ data: 'cod_cracha' },
			{ data: 'dtEntrada' },
			{ data: 'dtSaida' },
			{ data: 'om_nome' }
		]
	});

	var tb_automoveis = $('.tb_automoveis').DataTable({
		searching: false,
		ordering: false,
		lengthMenu: [20, 40, 60, 100, 200, 500, 1000],
		processing: true,
		serverSide: true,
		language: {
			url: "/js/sys/components/datatables_pt-BR.json"
		},
		ajax: {
			url: '/webservices/consultas/automoveis',
			type: 'POST',
			dataSrc: 'data',
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		},
		columns: [
			{ data: 'posto_nome' },
			{ data: 'nome_guerra' },
			{ data: 'cod_cracha' },
			{ data: 'marca_modelo' },
			{ data: 'placa' },
			{ data: 'dtEntrada' },
			{ data: 'dtSaida' },
			{ data: 'om_nome' }
		]
	});


	var tb_posto = $('.tb_posto').DataTable({
		searching: false,
		ordering: false,
		lengthMenu: [15, 20, 25],
		language: {
			url: "/js/sys/components/datatables_pt-BR.json"
		},
		ajax: {
			url: '/configuracoes/postos/listagem',
			type: 'POST',
			dataSrc: 'data',
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		},
		columns: [
			{ data: 'letra' },
			{ data: 'nome' },
			{ data: 'tipo' },
			{ data: 'options' }
		]
	});

	var tb_om = $('.tb_om').DataTable({
		searching: false,
		ordering: false,
		lengthMenu: [15, 20, 25],
		language: {
			url: "/js/sys/components/datatables_pt-BR.json"
		},
		ajax: {
			url: '/configuracoes/OM/listagem',
			type: 'POST',
			dataSrc: 'data',
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		},
		columns: [
			{ data: 'nome' },
			{ data: 'descricao' },
			{ data: 'options' }
		]
	});


	var tb_tipo_v = $('.tb_tipo_v').DataTable({
		searching: false,
		ordering: false,
		lengthMenu: [15, 20, 25],
		language: {
			url: "/js/sys/components/datatables_pt-BR.json"
		},
		ajax: {
			url: '/configuracoes/veiculos/tipo/listagem',
			type: 'POST',
			dataSrc: 'data',
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		},
		columns: [
			{ data: 'nome' },
			{ data: 'options' }
		]
	});

	var tb_marca = $('.tb_marca_v').DataTable({
		searching: false,
		ordering: false,
		lengthMenu: [20, 25, 40],
		language: {
			url: "/js/sys/components/datatables_pt-BR.json"
		},
		ajax: {
			url: '/configuracoes/veiculos/marca/listagem',
			type: 'POST',
			dataSrc: 'data',
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		},
		columns: [
			{ data: 'tipo' },
			{ data: 'nome' },
			{ data: 'options' }
		]
	});

	var tb_modelo_v = $('.tb_modelo_v').DataTable({
		searching: false,
		ordering: false,
		lengthMenu: [20, 25, 40],
		language: {
			url: "/js/sys/components/datatables_pt-BR.json"
		},
		ajax: {
			url: '/configuracoes/veiculos/modelo/listagem',
			type: 'POST',
			dataSrc: 'data',
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		},
		columns: [
			{ data: 'tipo' },
			{ data: 'marca' },
			{ data: 'modelo' },
			{ data: 'options' }
		]
	});

	var tb_usuarios = $('.tb_usuarios').DataTable({
		searching: false,
		ordering: false,
		lengthMenu: [20, 25, 40],
		language: {
			url: "/js/sys/components/datatables_pt-BR.json"
		},
		ajax: {
			url: '/configuracoes/usuarios/listagem',
			type: 'POST',
			dataSrc: 'data',
			headers: {
				'X-CSRF-Token': $('.table input[name=_token]').val()
			}
		},
		columns: [
			{ data: 'nome' },
			{ data: 'login' },
			{ data: 'om_nome' },
			{ data: 'perfil' },
			{ data: 'options' },
		]
	});


	/* FILE MANAGER - MILITARES */
	$('#lfm').filemanager('image');
});
