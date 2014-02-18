
$('#inputdroparea').droparea();

$(function() {
	atualizaPreco();
	$( "#tabs" ).tabs();
	var $tabs = $('#tabs_customizacao').tabs();
//	$("#tabs_customizacao li a").each(function(){
//		$(this).click(function(e){
//			e.preventDefault();
//          	return false;
//       });
//    });
	$(".painel_customizacao").each(function (i) {

		var totalSize = $(".painel_customizacao").size() - 1;
		
		if(i != totalSize) {
			next = i+1;
			$(this).append("<div class='bt_prosseguir'><a href='#' class='next-tab botao_amarelo' rel='"+next+"'>Prosseguir</a></div>");
		}
		
		if(i != 0) {
			prev = i -1;
			$(this).append("<div class='bt_retornar'><a href='#' class='prev-tab botao_amarelo' rel='"+prev+"'>Voltar</a></div>");
		}
		
	});
	
	$('.next-tab, .prev-tab').click(function () {
		$tabs.tabs('option','active', $(this).attr("rel"));
		return false;
	});
	
});

//$(document).ready(function () {	
//
//	$('.canvas').each(function() {
//		if (this.getContext) {
//			var ctx = this.getContext('2d');
//			
//			ctx.fillStyle = "#3096a9";
//			ctx.strokeStyle= '#3096a9';
//			ctx.lineWidth= 1;
//			
//			ctx.beginPath();
//			ctx.moveTo(-2,-2);
//			ctx.lineTo(150,80);
//			ctx.lineTo(0, 150);
//			ctx.lineTo(-2, -2);
//			
			// Done! Now fill the shape, and draw the stroke.
			// Note: your shape will not be visible until you call any of the two methods.
//			ctx.fill();
//			ctx.stroke();
//			ctx.closePath();
//		}
//	});
//	
//	$("#tabs_customizacao li").each(function(){
//		cor = $(this).css('background-color');
//		
//		$(this).click(function(e){
//			alert(cor);
//			$(this).find('.canvas').each(function() {
//				var ctx = this.getContext('2d');
//				
//				ctx.fillStyle = "#fff";
//				ctx.strokeStyle= '#fff';
//				ctx.lineWidth= 1;
//				
//				ctx.beginPath();
//				ctx.moveTo(-2,-2);
//				ctx.lineTo(150,80);
//				ctx.lineTo(0, 150);
//				ctx.lineTo(-2, -2);
//				
				// Done! Now fill the shape, and draw the stroke.
				// Note: your shape will not be visible until you call any of the two methods.
//				ctx.fill();
//				ctx.stroke();
//				ctx.closePath();
//			});
//	   });
//	   	$(this).hover(function(e){
//   			$(this).find('.canvas').each(function() {
//   				var ctx = this.getContext('2d');
//   				
//   				ctx.fillStyle = "#eee";
//   				ctx.strokeStyle= '#eee';
//   				ctx.lineWidth= 1;
//   				
//   				ctx.beginPath();
//   				ctx.moveTo(-2,-2);
//   				ctx.lineTo(150,80);
//   				ctx.lineTo(0, 150);
//   				ctx.lineTo(-2, -2);
//   				
   				// Done! Now fill the shape, and draw the stroke.
   				// Note: your shape will not be visible until you call any of the two methods.
//   				ctx.fill();
//   				ctx.stroke();
//   				ctx.closePath();
//   			});
//	   	});
//	   	$(this).mouseout(function(e){
//	   		$(this).find('.canvas').each(function() {
//	   			var ctx = this.getContext('2d');
//	   			
//	   			ctx.fillStyle = 'rgb(0,0,0)';
//	   			ctx.strokeStyle= 'rgb(0,0,0)';
//	   			ctx.lineWidth= 1;
//	   			
//	   			ctx.beginPath();
//	   			ctx.moveTo(-2,-2);
//	   			ctx.lineTo(150,80);
//	   			ctx.lineTo(0, 150);
//	   			ctx.lineTo(-2, -2);
//	   			
	   			// Done! Now fill the shape, and draw the stroke.
	   			// Note: your shape will not be visible until you call any of the two methods.
//	   			ctx.fill();
//	   			ctx.stroke();
//	   			ctx.closePath();
//	   		});
//	   	});
//	});
//	
//});

$(document).ready(function () {	
	$('#proximos_passos h3').click(function() {
	  	var pai = $(this);
	  	$(this).parent().find('div p').slideToggle('slow',function() {
	  		if($(pai).hasClass('ativo')) {
		  		$(pai).removeClass('ativo');
	  		}else {
	  			$(pai).addClass('ativo');	
	  		}
	  		
	  	});						
	});
});

//Botoes prosseguir e anterior da navegaçao da customização
var flag = [false,false,false];
var idTamanho = '';
var valorTotal;
flagNumPessoas = false;
numPessoasId = '';

function onmouseoverQuad(e) {
	
	if(numPessoasId != '') {
	
		var quadro = e.getAttribute("data-numerodoquadro");
		
		
		if(flag[quadro] && $('#idTamanhoQuadro'+quadro).val() == '') {
			//O usuario clicou em um tamanho de quadro.
			
			var idtam = e.getAttribute("data-idtamanho");
			var precoquadro = e.getAttribute("data-preco");
			$('#idTamanhoQuadro'+quadro).val(idtam);
			$('#idTamanhoQuadro'+quadro).attr("data-preco",precoquadro);
			//atualizaNumeroPessoas(idtam,e);
			//alert($('#idTamanhoQuadro'+quadro).val());
			//atualiza o preco quando clica em um tamanho;
			
			$('#total_tamanho').attr('src','../components/com_popstil/assets/img/customizacao_total_pronto.png');
			
			//atualizaPreco();
		}if(!flag[quadro] && $('#idTamanhoQuadro'+quadro).val() != '') {
			$('#idTamanhoQuadro'+quadro).val('');
			//Caso o usuario desmarcar o tamanho do quadro ele limpa o numero de pessoas e 
			//subtrai o preço
			//Seta o preço no input do tipo hidden
			$('#idTamanhoQuadro'+quadro).attr("data-preco",0);
			//$('#idNumeroPessoas'+quadro).attr("data-preco",0);
			//Atualiza o preço total
			
			$('#total_tamanho').attr('src','../components/com_popstil/assets/img/customizacao_total_aguardando.png');			
			//atualizaPreco();
		}
		limpaOutrosElementos(e);
		atualizaPreco();
	}
}

function atualizaPreco() {
	mensagens = verificaCampos();
	if(verificaCampos() == '') {
		var total = 0;
		//total += parseInt(precoParcial);
		$("#valorTotal").html('');
		var preco;
		for(var i = 0;i<numeroQuadros;i++ ) {	
			preco = (parseFloat($('#idTamanhoQuadro'+i).attr("data-preco")));
			//preco = parseInt($('#idNumeroPessoas'+i).attr("data-preco"));
			if(preco > 0) {
				total = preco;
			}
		}
		if(total === 0 ) {
			$("#valorTotal").html('');
			$("#parcelas").html('');
			$("#total").hide();
			//Oculta a div total
			//$('#total_wrapper').hide('slow');
		}else{
			$("#valorTotal").html('R$'+total.toFixed(2));
			$('#mensagem_tab_resumo h2').html('PRONTO! AGORA SÓ FALTA CONFIRMAR O SEU PEDIDO!');
			$('#mensagem_tab_resumo h4').html('Você receberá um e-mail de confirmação e só efetuará o pagamento quando sua foto for aprovada.');
			
			var totalparcelado = total/10;
			$("#parcelas").html('R$'+totalparcelado.toFixed(2));
			
			$("#total").show();
			
			//Mostra a div total
			//$('#total_wrapper').show('slow');
		}
	}else {
		$("#valorTotal").html('');
		$("#parcelas").html('');
		$("#total").hide();
		$('#mensagem_tab_resumo h2').html('Você ainda não completou todas as etapas!');
		$('#mensagem_tab_resumo h4').html(mensagens);
	}
	
	//alert(verificaCampos());
}

function verificaCampos() {
	retorna = '';
	
	if($("#inputdroparea").val() == '' || $("#idImagem").val() == '') {
		retorna += 'Falta você enviar a sua foto.<br/>';
	}
//	if($("#idImagem").val() == '') {
//		retorna += 'A sua foto esta sendo enviada.<br/>';
//	}
	
	if($("#idNumeroPessoas").val() == '') {
		retorna += 'Você ainda não escolheu o número de pessoas.<br/>';
	}
		
	if(!document.getElementById("check_paisagem").checked && !document.getElementById("check_retrato").checked) {
		retorna += 'Falta você escolher a orientação do seu Popstil.<br/>';
	}
	
	r = validaQuadro(0);
	
	if(r != '') {
		retorna += r;
	}
	
	return retorna;
}

function filtraTamanhos() {
	var tam = 0;
	//Seta display block para todos 
	$('.quadro').map(function () {
		var quadro = this.getAttribute("data-numerodoquadro");
		$('#idTamanhoQuadro'+quadro).val('');
		$('#idTamanhoQuadro'+quadro).attr("data-preco",0);
		$(this).css('display','block');
	});
	//agora seta display none para todos que tenham idnumpessoas diferente do escolhido.
	$('#total_tamanho').attr('src','../components/com_popstil/assets/img/customizacao_total_aguardando.png');
	$('.quadro').map(function () {
		//id do numero de pessoas da div em questao
		if(parseInt(this.getAttribute("data-idnumpessoas")) != (numPessoasId)) {
			$(this).css('display','none');
		}
	});
	
	flag = [false,false,false];
	
	
	atualizaPreco();
	
	//alert(tam);
	
}

function limpaOutrosElementos(e) {
	var quadro = e.getAttribute("data-numerodoquadro");
	if(!flag[quadro]) {
		e.style.backgroundColor = 'gray';
		var divTexto = e.getAttribute("data-texto");
		var elemento = document.getElementById(divTexto);
		elemento.innerHTML = e.getAttribute("data-tamanho");
		$("."+e.getAttribute("data-classe")).map(function () {
			if(this.id != e.id) {
				document.getElementById(this.id).style.backgroundColor = 'white';
			}
			if(this.getAttribute("data-texto") != divTexto) {
				document.getElementById(this.getAttribute("data-texto")).innerHTML = "";
			}
		})
		
	}
	
}
function limpaTextoMouseOut(e) {
	if(!flag) {
		var divTexto = e.getAttribute("data-texto");
		document.getElementById(divTexto).innerHTML = "";
		document.getElementById(e.id).style.backgroundColor = 'white';
		
	}
}

function atualizaNumeroPessoas(idTamanho,e) {
	var quadro = e.getAttribute("data-numerodoquadro");

	$("#quadropai"+quadro+" .num_pessoas-wrap #quadro"+quadro+" li").map(function () {					
		if(this.className == 'tamanho'+idTamanho) {
			$(this).css('display', 'inline');
		}
	});
	$("#quadropai"+quadro+" .num_pessoas-wrap #quadro"+quadro+" .numPessoas-demo").css('display','none');
	
}



function onOverNumPessoas(e) {
	var quadro = e.getAttribute("data-numerodoquadro");
	
	$("#numero_pessoas ul>li").map(function () {
					
		if(parseInt(this.getAttribute("data-id")) <= parseInt(e.getAttribute("data-id"))) {
			document.getElementById(this.id).style.background = 'url("../components/com_popstil/assets/img/icon-pessoas.png") 0px 0px no-repeat';
		}else{
			document.getElementById(this.id).style.background = 'url("../components/com_popstil/assets/img/icon-pessoas.png") -16px 0px no-repeat;';
		}
	})
}
function onOutNumPessoas(e) {
	var quadro = e.getAttribute("data-numerodoquadro");
	$("#numero_pessoas ul>li").map(function () {					
		if(parseInt(this.getAttribute("data-id")) > parseInt(numPessoasId)) {
			document.getElementById(this.id).style.background = 'url("../components/com_popstil/assets/img/icon-pessoas.png") -16px 0px no-repeat';
		}
	})
	$("#numero_pessoas ul>li").map(function () {
		if($('#idNumeroPessoas').val() == '') {
			document.getElementById(this.id).style.background = 'url("../components/com_popstil/assets/img/icon-pessoas.png") -16px 0px no-repeat';
		}
	});
}
//Quando o usuario clica sobre o numero de pessoas
function onClickNumPessoas(e) {
	//var quadro = e.getAttribute("data-numerodoquadro");
	//Pega o numero de pessoas que o quadro tem
	var divTexto = e.getAttribute("data-numeropessoas");
	//E coloca no campo para mostrar para o usuario
	$("#num_pessoas_quadro").html('<p>'+divTexto+'</p>');
	
	flagNumPessoas = true;
	var idNumPessoas = e.getAttribute("data-id");
	$('#idNumeroPessoas').val(idNumPessoas);
	numPessoasId = e.getAttribute("data-id");
	
	//Muda a imagem do icone na div total do canto direito
	$('#total_pessoas').attr('src','../components/com_popstil/assets/img/customizacao_total_pronto.png');
		
	//Seleciona somente os tamanhos referentes ao numero de pessoas para calcular o valor correto
	filtraTamanhos();
	
	//Ativa o campo dos tamanhos para o usuario selecionar
	ativaTamanhos();
	
	//Pega o valor do quadro com aquele numero de pessoas.
	//var preco = e.getAttribute("data-preco");
	//Seta o preço no input do tipo hidden
	//$('#idNumeroPessoas'+quadro).attr("data-preco",preco);
	//Atualiza o preço total
	atualizaPreco();
}
//Método para "limpar" o numero de pessoas, volta para o padrao sem cor
function limpaNumeroPessoas(e) {

	var quadro = e.getAttribute("data-numerodoquadro");

	$("#quadropai"+quadro+" .num_pessoas-wrap #quadro"+quadro+">li").map(function() {
		$(this).css('display', 'none');
	});
	$("#num_pessoas_quadro"+quadro).html('&nbsp');
	
	$("#quadro"+quadro+" .numPessoas-demo").css('display','inline');
	
	$("#quadropai"+quadro+" .num_pessoas-wrap #quadro"+quadro+" li").map(function() {	
		document.getElementById(this.id).style.background = 'url("../components/com_popstil/assets/img/icon-pessoas.png") -16px 0px no-repeat';
	})
}
function onClickMoldura(e) {
	var quadro = e.getAttribute("data-numerodoquadro");
	$("#molduraquadro"+quadro+" img").map(function () {					
		document.getElementById(this.id).style.background = 'none';
		if(this.id == e.id) {
			document.getElementById(this.id).style.background = "url('../components/com_popstil/assets/img/moldura_hover.png') 0px 0px no-repeat";
		}
	});
	var idCorMoldura = e.getAttribute("data-idMoldura");
	$('#idCorMoldura'+quadro).val(idCorMoldura);
	
	//Muda a imagem do icone na div total do canto direito
	$('#total_moldura').attr('src','../components/com_popstil/assets/img/customizacao_total_pronto.png');
	
	atualizaPreco();
}



function limpaSubSelects(subcategoria, itens){
	opcoesSubCategorias	= $(subcategoria.find('option:not(.static)'));
	subcategoria.data('options',opcoesSubCategorias);
	opcoesSubCategorias.remove();
	opcoesItens	= $(itens.find('option:not(.static)'));
	itens.data('options', opcoesItens);
	opcoesItens.remove();
}


function cascadeSelect(categoria, subcategoria, itens) {
	
	//var quadro = e.getAttribute("data-numerodoquadro");
	var opcoesSubCategorias	= $(subcategoria.find('option:not(.static)'));
	subcategoria.data('options',opcoesSubCategorias);
	
	var opcoesItens	= $(itens.find('option:not(.static)'));
	itens.data('options', opcoesItens);
	
	categoria.change(function() {	
		opcoesSubCategorias.remove();
		subcategoria.append(subcategoria.data('options').filter('.sub_'+this.value)).change();
	});
	subcategoria.change(function() {
		opcoesItens.remove();
		itens.append(itens.data('options').filter('.item_'+this.value)).change();
		itens.find('option:first').attr("selected","selected");
	});
	itens.click(function() {
		var selected = $(this).find('option:selected');
		var imagem = selected.data('imagem'); 
		var quadro = selected.data('quadro'); 
		var idfundo = this.value;
		$('#idimgpadraquadro'+quadro+' img').attr("src",imagem);
		$('#idFundo'+quadro).val(idfundo);
		$('#total_fundo').attr('src','../components/com_popstil/assets/img/customizacao_total_pronto.png');
		//Caso o usuario tenha marcado alguma cor solida ele desmarca ela.
		desmarcarCorSolida(quadro);
		atualizaPreco();
	});
	
	
	
	//categoria.find('option:last').click(function () {alert('tete')});
	categoria.find('option:last').attr("selected","selected");
}

$(function () {
	var opcoesSubCategorias;
	var opcoesItens;
	//$( ".selectItens" ).selectable();
	cascadeForm 	= $('.padraograficos');
	
	categoria 		= cascadeForm.find('.selectCategoriaQuadro0');
	subcategoria 	= cascadeForm.find('.selectSubCategoriaQuadro0');
	itens			= cascadeForm.find('.selectItensQuadro0');
	//limpaSubSelects(subcategoria, itens);
	cascadeSelect(categoria, subcategoria, itens);
	
//	categoria 		= cascadeForm.find('.selectCategoriaQuadro1');
//	subcategoria 	= cascadeForm.find('.selectSubCategoriaQuadro1');
//	itens			= cascadeForm.find('.selectItensQuadro1');
	//limpaSubSelects(subcategoria, itens);
//	cascadeSelect(categoria, subcategoria, itens);
//	
//	categoria 		= cascadeForm.find('.selectCategoriaQuadro2');
//	subcategoria 	= cascadeForm.find('.selectSubCategoriaQuadro2');
//	itens			= cascadeForm.find('.selectItensQuadro2');
	//limpaSubSelects(subcategoria, itens);
	cascadeSelect(categoria, subcategoria, itens);
});

function onClickCorSolida(e) {
	
	var quadro = e.getAttribute("data-numerodoquadro");
	
	var idFundo = e.getAttribute("data-idFundo");
	$('#idFundo'+quadro).val(idFundo);

	$('#fundoquadro'+quadro+' .cor span').map(function() {
		document.getElementById(this.id).style['boxShadow'] = 'none';
		if(this.id == e.id) {
			document.getElementById(this.id).style['boxShadow'] = 'inset 0px 0px 0px 5px #4e4b48';
		}
	});
	
	//Caso o usuario tenha marcado alguma fundo de padrao grafico, ele desmarca ele
	$('#idimgpadraquadro'+quadro+' img').attr("src",'../components/com_popstil/assets/img/visualizacao_padraografico.jpg');
	
	//Muda a imagem do icone na div total do canto direito
	$('#total_fundo').attr('src','../components/com_popstil/assets/img/customizacao_total_pronto.png');
	/*$("#cores .cor span").map(function () {					
		document.getElementById(this.id).style['boxShadow'] = 'none';
		if(this.id == e.id) {
			document.getElementById(this.id).style['boxShadow'] = 'inset 0px 0px 0px 5px white';
		}
	});*/
	
	atualizaPreco();
}
function desmarcarCorSolida(quadro) {
	$("#fundoquadro"+quadro+" .cor span").map(function () {					
		$(this).css('boxShadow','none');
	});
}


var numeroQuadros = 1;

function atualizaNumeroQuadros(sinal) {
	//Se o cliente clicar no +1
	/*Se o usuario clicar no mais quadros o método geraQuadro ira criar randomicamente
	  o codigo html para o usuario - testar*/
	//geraQuadro(numeroQuadros);
	if(sinal) {
		switch(numeroQuadros) {
			case 1: {
				numeroQuadros += 1;
				$('#numero_quadros').html(numeroQuadros);
				//$('#quadropai1').slideDown();
				$('#quadropai1').stop(true,true).animate({height:"toggle",opacity:"toggle"},1000);
				break;
			}
			case 2: {
				numeroQuadros += 1;
				$('#numero_quadros').html(numeroQuadros);
				$('#quadropai2').stop(true,true).animate({height:"toggle",opacity:"toggle"},1000);
				break;
			}			
			case 3: {
				$('#numero_quadros').html(numeroQuadros);
				break;
			}
		}
	}else if(!sinal) {
		switch(numeroQuadros) {
			case 1: {
				$('#numero_quadros').html(numeroQuadros);
				break;
			}
			case 2: {
				numeroQuadros -= 1;
				$('#numero_quadros').html(numeroQuadros);
				$('#quadropai1').stop(true,true).animate({height:"toggle",opacity:"toggle"},1000);
				break;
			}			
			case 3: {
				numeroQuadros -= 1
				$('#numero_quadros').html(numeroQuadros);
				$('#quadropai2').stop(true,true).animate({height:"toggle",opacity:"toggle"},1000);
				break;
			}
		}
	}
}

function onClickOrientacao() {
	$('#total_orientacao').attr('src','../components/com_popstil/assets/img/customizacao_total_pronto.png');
}

function validacoes() {
	var validacao = false;
	var msg = '';
	
	if($("#inputdroparea").val() == '') {
		msg += "Ops... parece que você nao escolheu uma imagem para a arte </br>";
	}
	if($("#idImagem").val() == '') {
		msg += "Aguarde até que a imagem seja enviada aos nossos servidores </br>";
	}
	
	if($("#idNumeroPessoas").val() == '') {
		msg += "Você nao selecionou o número de pessoas.<br/>";
	}
		
	if(!document.getElementById("check_paisagem").checked && !document.getElementById("check_retrato").checked) {
	  msg += "Você não selecionou se o quadro sera retrato ou paisagem.<br/>";
	}
	
	switch(numeroQuadros) {
		case 1: {
			msg += validaQuadro(0);
			break;
		}
		case 2: {
			msg += validaQuadro(0);
			msg += validaQuadro(1);
			break;
		}
		case 3: {
			msg += validaQuadro(0);
			msg += validaQuadro(1);
			msg += validaQuadro(2);
			break;
		}
	}
	
	if($.trim(msg) != '') {
		$("#msgValida").html(msg);
	}
	
	if(msg == '') {
		validacao = true;
	}else {
		validacao = false;
	}
	return validacao;
}

function validaQuadro(quadro) {
	var retorno = '';
	
	if($("#idTamanhoQuadro"+quadro).val() == '') {
		retorno = "Você nao escolheu o tamanho do seu Popstil </br>";
	}
	if($("#idCorMoldura"+quadro).val() == '') {
		retorno += "Você nao escolheu a cor da moldura do seu Popstil </br>";
	}
	
	if($("#idFundo"+quadro).val() == '') {
		retorno += "Você nao escolheu o fundo para o seu Popstil </br>";
	}
	
	return retorno;
		
}

function desativaTamanhos() {

	$(".wrapper-msgembreve").addClass("fundotransparente");
	
	$(".wrapper-tamanhos").hover(
	  function() { $('.msgembreve').fadeIn("slow"); },
	  function() { $('.msgembreve').fadeOut("slow"); }
	);
}

function ativaTamanhos() {
	$(".wrapper-msgembreve").removeClass("fundotransparente");
	$('.wrapper-tamanhos').unbind('hover');
}

function readImage(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			document.getElementById('textopreview').innerHTML = "";
			$('#blah').attr('src', e.target.result)
					.height(220).css('display', 'block');
			
		}
		reader.readAsDataURL(input.files[0]);
	}	
}
 
function uploadImage(input) {
	if(input.files && input.files[0]) {
		
		$('#img_carregando img').css('display','block');
		$('#blah').css('display','none');
		
		$('#total_foto').attr('src','../components/com_popstil/assets/img/customizacao_total_andamento.gif');

		$("#formimage").vPB({
			url: 'https://'+window.location.host+'/index.php?option=com_popstil&format=raw',
			data: {
				option:'com_popstil',
				task:'uploadImageCliente'
			},
			beforeSubmit: function()
			{
	//			$("#vpb_upload_status").html('<div style="font-family: Verdana, Geneva, sans-serif; font-size:12px; color:black;" align="center">Please wait <img src="images/loadings.gif" align="absmiddle" title="Upload...."/></div><br clear="all">');
			},
			success: function(response) 
			{	
				$('#idImagem').val(response);
				$('#img_carregando').hide();
				var reader = new FileReader();
				
				reader.onload = function (e) {
					//document.getElementById('textopreview').innerHTML = "";
					$('.textopreview').text('');
					$('#blah').attr('src', e.target.result)
							.height(220).css('display', 'block');
					$('#foto_tab_resumo img').attr('src', e.target.result)
							.height(220).css('display', 'block');
					
				}
				reader.readAsDataURL(input.files[0]);
				$('#img_carregando img').hide('slow');
				$('#total_foto').attr('src','../components/com_popstil/assets/img/customizacao_total_pronto.png');
				atualizaPreco();
				//$("#vpb_upload_status").hide().fadeIn('slow').html(response);
			},
			error:function(){
			    alert('Erro ao enviar a foto, tente novamente.');
			    $('#img_carregando img').hide('slow');
			}			
		}).submit();
		
	}
}