<style>
.banner_popstil .linha {
	border-top: 1px solid #e6e7e8;
	padding-top: 30px;
}
.banner_popstil .titulo {
	font: normal 1.4em/1.5em "din_cond_medium_alter", Tahoma;
	color: #939598;
	text-transform: uppercase;
	margin-bottom: 15px;
}

.banner_popstil .sugestao, .banner_popstil .instagram {
	border-top: 1px solid #e6e7e8;
	padding-top: 30px;
}
.banner_popstil .sugestao_imagem {
	width: 300px;
	height: 300px;
	float: left;
	margin-right:30px
}
.banner_popstil .sugestao_titulo {
	font: normal 2.4em/1.5em "din_cond_medium", tahoma;
	color:#4e4b48;
	margin-bottom: -10px;
}
.banner_popstil .sugestao_subtitulo {
	font: normal 1.8em/1.5em "din_cond_medium", tahoma;
	color:#4e4b48;
	margin-bottom: 20px;
}
.banner_popstil .sugestao_texto {
	font: normal 1em/1.5em "din_light", tahoma;
	color:#131313;
	padding-right:40px;
	margin-bottom: 30px;
}
.banner_popstil .sugestao_preco {
	font: normal 2.1em/1.5em "din_cond_medium", tahoma;
	color:#ffa800;
	margin-bottom: 10px;
}
.banner_popstil .botaoamarelo {
	font-family: 'din_cond_medium';
	font-size: 20px;
	letter-spacing: 1pt;
	color: #FFF;
	background-color: #ffa800 !important;
	border: 1px solid #d58401;
	padding: 10px 15px;
	text-transform: uppercase;
	-webkit-box-shadow: 2px 2px 3px 0px #a3a3a5;
	-moz-box-shadow: 2px 2px 3px 0px #a3a3a5;
	box-shadow: 2px 2px 3px 0px #a3a3a5;
	margin-top: 0px;
	display: inline-table;
	text-decoration:none;	
}
.banner_popstil .botaoamarelo:active {
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;	
}
.banner_popstil .instagram h5 {
	text-align:center;	
}
.banner_popstil .instagram h5 a,.banner_popstil .instagram h5 a:hover {
	font: normal 14px/1.5em "din_ligth", Tahoma;
	color:#4e4b48;
	text-decoration:underline;
}
</style>
<div class="banner_popstil">
<div class="col12 linha">

</div>
<div class="col8">
	<div class="titulo">
		sugestao popstil
	</div>
	<div class="sugestao">
		<div class="sugestao_imagem">
			<img src="<?php echo JURI::root().''.$this->sugestaopopstil->imagem ?>" />
		</div>
		<div class="sugestao_titulo">
			<?php echo $this->sugestaopopstil->titulo; ?>
		</div>
		<div class="sugestao_subtitulo">
			<?php echo $this->sugestaopopstil->subtitulo; ?>
		</div>
		<div class="sugestao_texto">
			<?php echo $this->sugestaopopstil->texto; ?>
		</div>
		<div class="sugestao_preco">
			R$ <?php echo $this->sugestaopopstil->preco; ?>
		</div>
		<div >
			<a href="/index.php?option=com_popstil&view=popstilcustomizacao" class="botaoamarelo">Peça já o seu</a>
		</div>
	</div>
</div>
<div class="col2">

</div>
<div class="col4">
	<div class="titulo">
		Últimas do popstil no instagram
	</div>
	<div class="instagram">
		<div id="slider-instagram">
			<ul class="bjqs">
				<?php if(!empty($this->imagesinstagram)) { 
					foreach($this->imagesinstagram->data as $post => $item ) {?>
				 <li>
				   <a href="<?php echo ( $item->link)?>" target="_blank">
					<img src="<?php print_r( $item->images->low_resolution->url )?>" />
				   </a>
				 </li>
				<?php } }?>
			</ul>
		</div>
		<h5><a href="http://instagram.com/popstil" target="_blank">Siga nosso instagram</a></h5>
	</div>			
</div>				
</div>