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
	<div class="row" id="tela_faq">
		<div class="span9">
			<h4>FAQ</h4>
			<hr class="linha_divisao"/>
			<div id="faq">
				<?php foreach ($this->listaPerguntas as $key => $value) { ?>
					<div class="item">
						<h3><?php echo $value->titulo; ?></h3>
						<div class="texto">
							<p>
								<?php echo $value->texto; ?>
							</p>
						</div>
					</div>
					<hr class="linha_divisao"/>
				<?php } ?>
			</div>
		</div>
		<div class="span2">
			
		</div>
		<br/><br/>
	</div>	
</div>