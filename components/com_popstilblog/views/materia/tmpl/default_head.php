<div id="menu_superior">
	<div class="blog_topo">
		<img src="<?php echo JURI::root() ?>/components/com_popstilblog/assets/img/logo_osingular.png" alt="" />
	</div>
	
	<hr />	
	<div class="blog_menu_categorias">
		<ul>
			<li>
				<a href="/osingular" data-categoria="#" style="border-bottom: 3px solid #808285;">TODOS</a>
			</li>
			<?php foreach ($this->listacategorias as $key => $value) { ?>
			<li>
				<a href="index.php/osingular/<?php echo strtolower($value->titulo) ?>" 
					class="<?php if($this->item->id_categoria == $value->id) {echo 'ativo';}?>"
					data-categoria="<?php echo strtolower($value->titulo) ?>" style="border-bottom: 3px solid #<?php echo $value->cor_tema ?>;"><?php echo trim($value->titulo) ?></a>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>