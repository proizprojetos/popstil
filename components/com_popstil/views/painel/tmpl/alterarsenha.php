<?php defined('_JEXEC') or die; ?>
<?php echo $this->loadTemplate('page_heading'); ?>

<div class="container alterarsenha">
	<h3>ALTERACAÇÃO DA SENHA</h3>
		<hr class="linha_divisao"/>
	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_popstil&task=painel.alterarsenha&idusuario='.$this->user->id); ?>" method="post" class="form-validate" name="adminForm" enctype="multipart/form-data">
		<div class="row">
			<div class="cadastro_input span12">
				<div class="">
					<span>*</span>
					<input name="senha[atual]" placeholder="Senha atual" type="password" id="senha_atual" 
					value=""label="Please say if it was full-time or the part-time equivalent?"
					class="inputbox required validate-texto" required="required" maxlength="120" style="width:250px">
				</div>
			</div>
			
			<div class="cadastro_input span10">
				<div class="">
					<span>*</span>
					<input  name="senha[senha1]" placeholder="Nova senha" id="senha1" type="password"
					value=""
					class="inputbox required validate-texto" required="required" maxlength="120" style="width:250px">
				</div>
			</div>
			
			<div class="cadastro_input span10">
				<div class="">
					<span>*</span>
					<input  name="senha[senha2]" placeholder="Confirme sua senha" id="senha2" type="password"
					value="" 
					class="inputbox required validate-texto" required="required" maxlength="120" style="width:250px">
				</div>
			</div>
			<div class="span5" style="text-align: right;">
				<div class="bt_salvar">
					<input type="submit" class="" value="Salvar"/>
				</div>
			</div>
		</div>
			
	</div>
</div>