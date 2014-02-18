<div class="corpo">
	<div class="corpo_materias coluna">
		<div id="materia_destaque" class="coluna_destaque col12">
			<div>
				<img src="<?php echo $this->listamaterias[0]->imagem_intro ?>" />
				<h2><?php echo $this->listamaterias[0]->titulo; ?>.</h2>
				<a href="<?php echo JRoute::_('index.php?option=com_popstilblog&view=materia&id='. 
					$this->listamaterias[0]->id.'&titulo='.$this->listamaterias[0]->titulo) ?>">LEIA</a>
			</div><!--<?php echo JRoute::_('index.php?option=com_popstilblog&view=materia&id='. $this->listamaterias[0]->id) ?>-->
		</div>
		<div id="coluna_materias" class="coluna_materias">
				<?php foreach ($this->listamaterias as $key => $value) { 
					if($key > 0) { ?>
					<div class="materia col3 " style="border-bottom: 3px solid <?php echo '#'.$value->cor_tema; ?>;">
						<img src="<?php echo $value->imagem_capa; ?>" alt=""  style="border-bottom: 3px solid <?php echo '#'.$value->cor_tema; ?>;"/>
						<h4><?php echo $value->titulo; ?></h4>
						
						<p>Publicado há <?php echo $value->inicio_publicacao; ?></p>
				<a href="<?php echo JRoute::_('index.php?option=com_popstilblog&view=materia&id='. 
					$value->id.'&titulo='.$value->titulo) ?>" style="color: <?php echo '#'.$value->cor_tema; ?>;">LEIA</a>
				</div>
			<?php } 
			} ?>
		</div>
	</div>
	<style>
		
	</style>
	<div class="seta_topo">
		<a href="#top"><img src="<?php echo JURI::root() ?>/components/com_popstilblog/views/popstilblog/images/seta_topo.png" alt="" /></a>
	</div>
	
	<div id="carregar_posts" class="carregar_posts">
		<h3 data-value="10">Carregar mais posts</h3>
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