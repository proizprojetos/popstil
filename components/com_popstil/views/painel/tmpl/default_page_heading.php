<?php 

defined('_JEXEC') or die;

?></div>
<div class="cabecalho_popstil">
	<div id="corpo" class="container">
		<div id="sub-header-wrap" class="row">
			<div class="span1 clearfix" >&nbsp</div>
				<div class="sub-header span10">
					<div class="painel_header">
						<h2><b>Olá, <?php echo $user =JFactory::getUser()->name; ?>!</b> Este é o seu espaço no popstil.com</h2>					
						<p>
							Acompanhe seus pedidos, entre em contato conosco e fique por dentro das novidades Popstil.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="painel_menu">
		<div class="span12 clearfix navbar" >
			<ul class="nav direita">
				<li class=""><a href="<?php echo JRoute::_('index.php?option=com_popstil&view=painel'); ?>">Acompanhar pedidos</a></li>
				<li class=""><a href="<?php echo JRoute::_('index.php?option=com_popstil&view=painel&layout=alterardados'); ?>">Seus dados</a></li>
				<li class=""><a href="<?php echo JRoute::_('index.php?option=com_popstil&view=painel&layout=alterarsenha'); ?>">Alterar senha</a></li>
			</ul>
		</div>
	</div>
</div>