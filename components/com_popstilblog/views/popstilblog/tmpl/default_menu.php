<div id="menu_superior">	
	<div class="blog_topo">
		<img src="<?php echo JURI::root() ?>/components/com_popstilblog/assets/img/logo_osingular.png" alt="" />
	</div>
	
	<hr />	
	<div class="blog_menu_categorias">
	<nav>
		<ul>
			<li >
				<a href="#" data-categoria="#" class="ativo" style="border-bottom: 3px solid #808285;">TODOS</a>
			</li>
			<?php foreach ($this->listacategorias as $key => $value) { ?>
			<li>
				<a href="#" data-categoria="<?php echo strtolower($value->titulo) ?>" style="border-bottom: 3px solid #<?php echo $value->cor_tema ?>;"><?php echo trim($value->titulo) ?></a>
			</li>
			<?php } ?>
		</ul>
	</nav>
	</div>
</div>



<script type="text/javascript">
var categoria = "<?php echo $this->categoria; ?>";

$(function(){
	
	//Verifica se o usuario passou alguma categoria, ele verifica se a categoria existe, atualiza o menu 
	//ativo e atualiza as materias
	if(categoria != '') {
		$('.blog_menu_categorias ul li a').each(function (i) {
		  if( $(this).data('categoria') == categoria) {
			$('.blog_menu_categorias ul li a').removeClass('ativo');
		  	$(this).addClass('ativo');
		  	atualizaMaterias(categoria);
		  }
		});
	}

	//Adiciona a função de click no item de menu das categorias
	$('.blog_menu_categorias ul li a').click(function() {
		$('.blog_menu_categorias ul li a').removeClass('ativo');
		$(this).addClass('ativo');
		categoria = ($(this).data('categoria'));
		atualizaMaterias(categoria);
	})
	
	$('#carregar_posts h3').click(function () {
		valor = $(this).data('value');
		
		if(categoria == '') {
			categoria = '#';
		}
		carregaMaterias(categoria,valor);
		valor = valor+10;
		$(this).data('value',valor);
		
	});
});
//Essa funcão carrega mais matéria sem atualizar a página.
function carregaMaterias(categoria,inicio) {

	jQuery.ajax({
		async: false,
		type: 'POST',
		url: "<?php echo JURI::base() . "index.php?option=com_popstilblog&format=json"?>",
		data: {
			option: 'com_popstilblog',
	        task: 'getNovasMaterias',
	        data: categoria+"&"+inicio
		},
		success: function( data ) {
			//alert(data);
//			Monta o html para colocar na pagina
			
			jQuery.each(data, function(index, val) {
				html = '';
				html += '<div class="materia col3 " style="border-bottom: 3px solid #'+data[index].cor_tema+';">';
				html += '<img src="/'+data[index].imagem_capa+'" alt="" style="border-bottom: 3px solid #'+data[index].cor_tema+';">';
				html += '<h4>'+data[index].titulo+'</h4>';
				html += '<p>Publicado a '+data[index].inicio_publicacao+'</p>';
//				'+data[index].titulo
//				+data[index].id+
//				a = ;
//				alert(data[index].id);
				var txt = 'index.php?option=com_popstilblog&view=materia&id='+data[index].id+'&titulo='+data[index].id;
				html += '<a href="/osingular/materia/'+data[index].titulo.replace(' ','-')+'">LEIA</a>';
				html += '</div>';
				
				$(html).hide().appendTo('#coluna_materias').fadeIn(900);
				//$('#coluna_materias').append(html);
				
			});
			//$('#coluna_materias').fadeIn(300, function() { $(this).append(html); });
		},
		error:function(){
            alert('Erro');
            //$('#errors').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
        }
	});
}



function atualizaMaterias(categoria) {
	jQuery.ajax({
		async: false,
		type: 'POST',
		url: "<?php echo JURI::base() . "index.php?option=com_popstilblog&format=json"?>",
		data: {
			option: 'com_popstilblog',
	        task: 'getMaterias',
	        param: categoria
		},
		success: function( data ) {
			//Remove as matérias que estao aparecendo na pagina
			$('#coluna_materias div').fadeOut(200, function() { $(this).remove(); });
			$('#materia_destaque div').fadeOut(200, function() { $(this).remove(); });
			//Retorna um json das méterias filtradas por categoria
			//Monta o html para colocar na pagina
			//window.setTimeout(montar,1000)
			//function  montar() {
				html = '';
				html += '<div>';
				html += '<img src="/'+data[0].imagem_intro+'" alt="" />';
				html += '<h2>'+data[0].titulo+'</h2>';
				html += '<a href="/osingular/materia/'+data[0].id+'/'+data[0].url+'.html">LEIA</a>';
				html += '</div>';
				//$('#materia_destaque').fadeIn(300, function() { $(this).append(html); });
				$(html).hide().appendTo('#materia_destaque').fadeIn(900);
				//$('#materia_destaque').append(html)
				
				html = '';
				jQuery.each(data, function(index, val) {
					if(parseInt(index) > 0) {

						html += '<div class="materia col3 " style="border-bottom: 3px solid #'+data[index].cor_tema+';">';
						html += '<img src="/'+data[index].imagem_capa+'" alt="" style="border-bottom: 3px solid #'+data[index].cor_tema+';">';
						html += '<h4>'+data[index].titulo+'</h4>';
						html += '<p>Publicado a '+data[index].inicio_publicacao+'</p>';
						//'+data[index].titulo
						//+data[index].id+
						//a = ;
						//alert(data[index].id);
						//var txt = 'index.php?option=com_popstilblog&view=materia&id='+data[index].id+'&titulo='+data[index].id;
						html += '<a href="/osingular/materia/'+data[index].id+'/'+data[index].url+'.html">LEIA</a>';
						html += '</div>';
					}
				});
				//$('#coluna_materias').fadeIn(300, function() { $(this).append(html); });
				$(html).hide().appendTo('#coluna_materias').fadeIn(900);
				//$('#coluna_materias').append(html);
			//}
		},
		error:function(){
            alert('Erro');
            //$('#errors').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
        }
	});
}
</script>