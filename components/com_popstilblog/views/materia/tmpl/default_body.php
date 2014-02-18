<div class="corpo">
		<div class="corpo_materia coluna">
			<div class="materia_titulo col12">
				<h2><?php echo $this->item->titulo ?></h2>
				<p>Publicado em <?php echo JHtml::_('date', $this->item->inicio_publicacao, JText::_('DATE_FORMAT_BLOG')); ?> por <span><?php echo $this->item->author ?></span></p>	
				</p>			
			</div>	
			
			<div class="linha">
				<div class="col6 materia_tags">
					<ul>
						<?php foreach ($this->item->tags as $chave => $valor) {
							echo '<li><a href="'.JRoute::_('index.php?option=com_popstilblog&view=indice&layout=tag&tag='.$valor->titulo).'">'.$valor->titulo.'</a></li>';
						} ?>
					</ul>
				</div>
				<?php 	
					//$json = json_decode(file_get_contents('https://graph.facebook.com/?ids=http://popstil.com/osingular/materia/Materia-2.html'));
					//$a = ($json->$url->comments) ? $json->$url->comments : 0;
					//echo '<br/><br/><h1>'.print_r($json).'</h1>';
				?>
				</script>
				<div class="col2 materia_comentarios">
					<h1><?php echo $this->comentarios; ?></h1>
					<h3>Comentarios</h3>
				</div>
				<div class="col4 materia_compartilhar">
					<h3>Compartilhe</h3>
					<div class="topo_compartilhar">
						<div class="bt">
							<a href="<?php echo 'http://popstil.com'.JRoute::_('index.php?option=com_popstilblog&view=materia&id='. 
								$this->item->id.'&titulo='.$this->item->titulo); ?>" class="twitter-share-button">Tweet</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
						</div>
						<div class="bt">
							<div id="fb-root"></div>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
							<div class="fb-like" data-href="<?php echo 'http://popstil.com'.JRoute::_('index.php?option=com_popstilblog&view=materia&id='. 
								$this->item->id.'&titulo='.$this->item->titulo); ?>" data-colorscheme="light" data-layout="button_count" data-action="like" data-show-faces="false" data-send="false">
							</div>
						</div>
						
						<div class="bt">
							<!-- Posicione esta tag onde você deseja que o botão +1 apareça. -->
							
							<script type=”text/javascript” src=”http://apis.google.com/js/plusone.js”></script>
							
							
							<!-- Coloque este código no lugar que voce quer que o +1 apareca -->
							<g:plusone size='medium'>								</g:plusone>
							
							<!-- Posicione esta tag depois da última tag do botão +1. -->
							<script type="text/javascript">
							  window.___gcfg = {lang: 'pt-BR'};
							
							  (function() {
							    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
							    po.src = 'https://apis.google.com/js/plusone.js';
							    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
							  })();
							</script>
						</div>
					</div>
				</div>
			</div>
			<div class="linha">
				<div class="materia_texto">
					<div class="texto_imagem">
						<img src="<?php echo $this->item->imagem_intro ?>" alt="" />
					</div>
					<div class="texto_inicial ">
						<?php echo strip_tags($this->item->texto_intro) ?>
					</div>
					<div class="texto">
						   <?php echo $this->item->text ?>
						    <br>
				    </div>
				    <style>
				    	
				    </style>
				    <div class=" materia_comentarios_facebook">
				   
				    	<div class="fb_coments_titulo">
				    		<h2>COMENTÁRIOS</h2> 
				    	</div>
				    	<div class="fb-comments" data-href="<?php echo 'https://popstil.com'.JRoute::_('index.php?option=com_popstilblog&view=materia&id='. 
				    		$this->item->id.'&titulo='.$this->item->titulo); ?>" data-numposts="10" data-width:"660">
				    		</div>
				    	
				    </div>
				</div>			
			</div>
			<?php echo $this->loadTemplate('sugestao'); ?>
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
		
	</div>	