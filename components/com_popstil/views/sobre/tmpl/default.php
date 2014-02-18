<?php

defined('_JEXEC') or die('Restricted access');


JHtml::_('behavior.keepalive');

?>
</div>
<div class="cabecalho_popstil">
	<div id="corpo" class="container">
		<div id="sub-header-wrap" class="row">
			<div class="span1 clearfix" >&nbsp</div>
			<div class="sub-header span10">
				<div class="painel_header">
					<h2>Popstil.com</h2>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<br/><br/>
		<div class="span9">
			<hr class="linha_divisao"/>
		</div>								
	</div>
	<div class="row" id="tela_sobre">
		<div class="span9">
			<div id="tabs_sobre">
				<ul class="tabs_sobre_menu">
					<?php foreach ($this->itens as $key => $value) { ?>
						<li><a href="#<?php echo str_replace(" ","",$value->titulo); ?>"><?php echo $value->titulo; ?> </a></li>
					<?php } ?>
				</ul>
				<?php foreach ($this->itens as $key => $value) { ?>
					<div id="<?php echo str_replace(" ","",$value->titulo); ?>">
						<hr class="linha_divisao"/>
						<h4><?php echo $value->titulo; ?></h4>
						<hr class="linha_divisao"/>
						<div class="texto">
							<?php echo $value->texto; ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="span2">
			
		</div>
		<br/><br/>
	</div>	
</div>