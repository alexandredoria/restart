var page = 1;
/*************************************************
 * Exibe a caixa de diálogo para confirmar a ação
 *************************************************/
function showConfirm (acao,excluirID) {
	if (acao == 'show') {
		document.confirm.id_action.value = excluirID;
		$("#dialog_box").fadeIn('fast').css({
			'left': event.pageX - 490,
			'top': event.pageY - 200,
			'display': 'block',
			'position': 'absolute'
		});
	}
	else {
		$('#dialog_box').fadeOut('fast');
	}

}
/*************************************************
 * Exibe as mensagens após a conclusão de uma ação
 *************************************************/
function showGrowl () {
    $('#growl_box').fadeIn('slow',function(){
    	$('#growl_box').click(function(){
    		$(this).fadeOut();
    	});

        setTimeout(function () {
        	$('#growl_box').fadeOut();
        },10000);
    });
};

/*************************************************
 * Limpa os campos do formulario e retira classes
 *************************************************/
function resetForm (form) {
	document.getElementById(form).reset();
	cleanFormCSS(form, 'Cadastrar');
}
/*************************************************
 * Obtém os dados e joga no form
 *************************************************/
function ajaxEdit (location, form, value) {
	$.get(
		"nucleo/editrequests.php", 
		{module: location, id: value},
		function (data) {
			cleanFormCSS(form, value);
			conteudo	= data.split('||');
			dados		= conteudo[0].split('*');
			campos		= conteudo[1].split('*');
			switch (location) {
				case 'Patrimonio':
					var oposto = (dados[6] == 'ON') ? '#OFF' : '#ON';
					if ($(oposto).is(':checked')) {
						$(oposto).prop('checked', false);
					}
					$('#' + dados[6]).prop('checked', true);
				break;

				case 'usuario':
					for (var i = 5; i <= 13; i++) {	// Contador dos inputs de radio
						if (dados[i] == 1) {
							campos[i] = campos[i].concat('_s');
							$('#' + campos[i]).prop('checked', true);
						} else{
							campos[i] = campos[i].concat('_n');
							$('#' + campos[i]).prop('checked', true);
						};	
					}
					if ($("#plogin_n").is(':checked')) $("#steps form fieldset:nth-child(2) p:first label[for='plogin_n']").click();
					else $("#steps form fieldset:nth-child(2) p:first label[for='plogin_s']").click();
				break;
			}
			for (var i = campos.length - 1; i >= 0; i--) {
				$('#' + campos[i]).val(dados[i]);
			};
			if (location == 'cliente') { $('#tipo_cli').change(); }
			$('#' + campos[0]).select();
		}
	);
}
/*************************************************
 * Remove modificações de estilo nos inputs
 * Altera os parametros para estabelecer adicao ou exclusão
 *************************************************/
function cleanFormCSS (form_id, texto) {
	switch (form_id) {
		case 'formCateg':
			var word = ' Categoria';
		break;

		case 'formCli':
			var word = ' Cliente';
		break;

		case 'formUsuario':
			var word = ' Usuário';
			if (texto == 'Cadastrar') {
				$("#steps form fieldset:nth-child(2) p:first label[for='plogin_n']").click();
				$("#steps form fieldset:nth-child(1) p.enviar_edit").remove();
				$('input#login').rules("add", {
					remote: 'nucleo/uniquecheck.php'
				});
				$('input#email').rules("add", {
					remote: 'nucleo/uniquecheck.php'
				});
			}
			else {
				$("#steps form fieldset:nth-child(1) p.enviar_edit").remove();
				$("<p class='enviar_edit'><label>&nbsp;</label><input class='btn_black' type='submit' value='Editar'></p>").appendTo("#steps form fieldset:nth-child(1)");
				$('input#login').rules("remove", "remote");
				$('input#email').rules("remove", "remote");
			}
		break;

		case 'formProd':
			var word = ' Patrimonio';
			if ($('#OFF').is(':checked')) {
				$('#OFF').prop('checked', false);
			}
			$('#ON').prop('checked', true);
			if (texto != 'Cadastrar') {
				$('input#nome_prod').rules("remove", "remote");
			}
			else {
				$('input#nome_prod').rules("add", {
					remote: 'nucleo/uniquecheck.php'
				});
			}
		break;
	}

	var titulo = '#' + form_id + ' fieldset legend';
	$(titulo).parent().find('label.error').remove();
	$(titulo).parent().find('input').removeClass('valid error');
	if (texto == 'Cadastrar') {
		$('#' + form_id + ' input:hidden[name=acao]').val('add');
		$(titulo).text(texto + word);
	}
	else {
		$('#' + form_id + ' input:hidden[name=acao]').val(texto);
		$(titulo).text('Editar' + word);
	}
}
/*************************************************
 * Live Search - Procura, Obtém e Exibe resultados
 ************************************************/
function search() {
	var query_value = $('input#pesquisar').val();
	var s_module = $('input#s_module').val();
	$("article div#loader").show();
	if(query_value !== ''){
		$.ajax({
			type: "POST",
			url: "search.php",
			data: { query: query_value, module: s_module },
			cache: false,
			success: function(html){
				$("div.table-box table tbody").html(html);
				$("article div.table-box table").trigger("update");
				$("article div#loader").hide();
			}
		});
	} else {
		$.ajax({
			type: "POST",
			url: "search.php",
			data: { query: "bo0bi3s", module: s_module },
			cache: false,
			success: function(html){
				$("div.table-box table tbody").html(html);
				$("article div.table-box table").trigger("update");
				$("article div#loader").hide();
				page = 1;
			}
		});
	}
	return false;
}
/***************************************************
 **************************************************/
$(document).ready(function(){
	/*********************************
	 * Efeitos do box do usuario
	 ********************************/
	var altura = $("#user_info").height() * -1.1;
	$("#user_info").css({ 'bottom': altura });

	$("#user_info .header").click(function () {
		var posicao = parseInt($("#user_info").css('bottom'));
		var novaAltura = posicao < 0 ? 0 : altura;
		$("#user_info").animate({ bottom: novaAltura });
	});
	
	/*********************************
	 * Efeitos jQuery da tabela
	 ********************************/
	$('div.menu-op form.search').submit(function(e){ e.preventDefault(); });

	$("input#pesquisar").on("keyup", function(e) {
		clearTimeout($.data(this, 'timer'));	// Set Timeout
		$("article div#message").fadeOut();
		$(this).data('timer', setTimeout(search, 100));
	});
});