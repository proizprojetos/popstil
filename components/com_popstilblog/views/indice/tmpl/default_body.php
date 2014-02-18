<div class="corpo">
	<div class="corpo_indice coluna">
		<div class="col6">
			<div class="indice_arquivo">
				<h2>ARQUIVO</h2>
				<?php foreach ($this->listaMaterias as $key => $value) {
					echo '<div class="arquivo_ano">';
					echo '<p>'.$value['ano'].'</p>'; 
					if($key !== 'ano') {
						echo '<ul>';
						foreach ($value as $chave => $valor) {
							if(is_array($valor)) {
								echo '<li><a href="'.JRoute::_('index.php?option=com_popstilblog&view=indice&layout=mes&ano='.$value['ano'].'&mes='.$valor['mes']).'">'.$valor['mesextenso'].'</a><span>('.$valor['quantidade'].')</span></li>';
							}
						}
						echo '</ul></div>';
					}
					
				} ?>
			</div>
		</div>
		<div class="col6">
			<H2>TAGS</H2>
			<div class="indice_tags">
				<?php foreach ($this->listaTags as $key => $value) { 
					$tamanho = 1.1;
					if($value->quantidade >= 10 && $value->quantidade < 20) {
						$tamanho = 1.5;
					}else if($value->quantidade >=20 && $value->quantidade <30) {
						$tamanho = 1.8;
					}else if($value->quantidade >=30 ) {
						$tamanho = 2.1;
					}
				?>					
					<a href="<?php echo JRoute::_('index.php?option=com_popstilblog&view=indice&layout=tag&tag='.$value->titulo); ?>" style="font-size:<?php echo $tamanho; ?>em ;"><?php echo $value->titulo; ?></a>	
				<?php } ?>				
			</div>
		</div>
    	<?php 
			echo $this->loadTemplate('sugestao');
		?>
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