</br></br></br></br></br></br></br>
</div></div>
<div class="corpo_blog">	
	<style>
		.indice_resultado .titulo_resultado {
			border-bottom: 2px solid #a2a2a2;
			padding-bottom: 50px;
		}
		.indice_resultado .titulo_resultado a{
			margin-right: 10px;
			text-decoration: none;
			color: #4e4b48;
			font: normal 1em/1.5em "din_cond_medium", Tahoma;
		}
		.indice_resultado .titulo_resultado h4 {
			display: inline-block;
			color: #fdbf57;
			font: normal 2em/2em "din_cond_medium", Tahoma;
			text-transform: uppercase;
			letter-spacing: 2px;
		}
		.indice_resultado .titulo_resultado h4 span{
			color: #4e4b48;
		}
		
		.indice_resultado .resultado_materia_titulo p {
			display: inline-block;
			text-transform: uppercase;
			font: bold 1.1em/1.5em "din_cond_medium", Tahoma;
			margin: 0px 5px 0px 0px;
		}
		
		.indice_resultado .resultado_materia_titulo h3 {
			display: inline-block;
			text-transform: uppercase;
			font: bold 2em/1.5em "din_cond_medium", Tahoma;
			margin: 0px;
		}
		
		.indice_resultado .resultado_materia {
			margin: 30px 0px;
			padding-bottom: 20px;
			border-bottom: 2px solid #a2a2a2;
		}
		.indice_resultado .resultado_materia_resumo {
			font: normal 1.1em/1.5em "din_light", Tahoma;
			color: #4e4b48;
		}
		.indice_resultado .resultado_materia_resumo a{
			text-decoration: none;
			font: bold 1.1em/1.5em "din_cond_medium", Tahoma;
			color: #41c4dd;
			margin: 5px 0px;
			display: inline-block;
		}
		.indice_resultado .resultado_materia_resumo p{
			font: normal 1em/1.5em "din_light", Tahoma;
			color: #4e4b48;
		}
		
	</style>
	<?php echo $this->loadTemplate('head'); ?>
	<div class="corpo">
		<div class="corpo_indice coluna indice_resultado">
			<div class="col12 titulo_resultado">
				<a href="<?php echo JRoute::_('index.php?option=com_popstilblog&view=indice'); ?>">Voltar ao índice</a><h4>ARQUIVO / TAGS /<span> '<?php echo $this->tag; ?>'</span></h4>
			</div>
			
			<div class="col12 resultado">
				<?php foreach ($this->listaresultado as $key => $value) { ?>
				<div class="resultado_materia">
					<div class="resultado_materia_titulo">
						<p style="color: <?php echo '#'.$value->cor_tema; ?>;"><?php echo $value->titulo_categoria; ?></p><h3><?php echo $value->titulo; ?>.</h3>
					</div>
					<div class="resultado_materia_resumo">
						<span><?php echo substr(strip_tags($value->text), 0,300); ?>...<br/></span>
						
						<a href="<?php echo JRoute::_('index.php?option=com_popstilblog&view=materia&id='. 
							$value->id.'&titulo='.$value->titulo) ?>">Continuar lendo</a>
						<p>Publicado em <?php echo JHtml::_('date', $value->inicio_publicacao, JText::_('DATE_FORMAT_BLOG')); ?> por <span><?php echo $value->author ?></span></p>
						<div class="materia_tags">
							<ul>
								<?php foreach ($value->tags as $chave => $valor) {
									echo '<li style="background-color: #'. $value->cor_tema .'"><a href="'.JRoute::_('index.php?option=com_popstilblog&view=indice&layout=tag&tag='.$valor->titulo).'">'.$valor->titulo.'</a></li>';
								} ?>
							</ul>
						</div>
					</div>
				</div>
				<?php } ?>		
			</div>
			<?php 
				echo $this->loadTemplate('sugestao');
			?>
		</div>
	</div>
	<div class="clear" />
	
	<div class="blog_compartilhar coluna">
        <div class="linha">
            <div class="blog_facebook col4">
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "https://connect.facebook.net/pt_BR/all.js#xfbml=1&appId=650621928293773";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-like-box" data-href="http://www.facebook.com/meupopstil" data-height="215" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
            </div>
            
            <div class="blog_fale_conosco col4">
                <h2>FALE CONOSCO</h2>
                <p>Envie suas sugestões de pauta, comentários e perguntas. osingular@popsitl.com</p>
                
                <h2>Siga-nos também no twitter</h2>
                <p><a href="https://twitter.com/meuPopstil">@meuPopstil</a></p>
            </div>
            
            <div class="blog_newsletter col4">
                <h1>Receba as publicações de o singular no seu e-mail!</h1>
                <form method="post" action="#">
                    <input type="text" name="email" value="" placeholder="Insira aqui seu e-mail" />
                    <input type="submit" name="enviar" value="OK" />
                </form>
            </div>
        </div>	
</div>