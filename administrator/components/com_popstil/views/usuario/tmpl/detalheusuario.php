<?php

?>

<fieldset>
	
	<?php echo JHtml::_('bootstrap.startTabSet','myTab', array('active' => 'details')); ?>
	
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('Detalhe do cliente',true)); ?>
		<h3>Detalhe do cliente</h3>
		<div class="item">
			<p>Nome completo: <?php echo $this->escape($this->cliente->nomecompleto); ?>	 </p>
		</div>
		<div class="item">
			<p>Email: <?php echo $this->escape($this->cliente->email); ?>	 </p>
		</div>
		<div class="item">
			<p>Nome de usuário: <?php echo $this->escape($this->cliente->username);  ?>	 </p>
		</div>
		<div class="item">
			<p>CPF: <?php echo $this->escape($this->cliente->cpf);  ?>	 </p>
		</div>
		<div class="item">
			<p>Data de nascimento <?php echo date("d/m/Y", strtotime($this->escape($this->cliente->datanascimento)));  ?>	 </p>
		</div<div class="item">
			<p>Sexo: <?php echo ($this->escape($this->cliente->sexo) == 'M' ? 'Masculino' : 'Feminino');  ?>	 </p>
		</div>
		<div class="item">
			<p>Recebe newsletter? <?php echo ($this->escape($this->cliente->enviaremail) == 'S' ? 'Sim' : 'Não');  ?>	 </p>
		</div>
		<div class="item">
			<p>Data de registro: <?php echo date("d/m/Y G:i:s", strtotime($this->escape($this->cliente->dataregistro))); ?>	 </p>
		</div>
		<div class="item">
			<p>Telefone 1: <?php echo $this->escape('('.$this->cliente->ddd1.') '.$this->cliente->telefone1);  ?>	 </p>
		</div>
		<div class="item">
			<p>Telefone 2: <?php echo $this->escape('('.$this->cliente->ddd2.') '.$this->cliente->telefone2);  ?>	 </p>
		</div>
		
<!--		
		<?php foreach ($this->form->getFieldset('detalhes_slider') as $field) { ?>
			<div class="control-group">
				<div class="control-label">
					<?php echo $field->label; ?>
				</div>
				<div class="controls">
					<?php echo $field->input; ?>
				</div>
			</div>
		<?php } ?>-->
	<?php echo JHtml::_('bootstrap.endTab'); ?>		
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'detailsend', JText::_('Detalhe do endereço',true)); ?>
		<h3>Endereço para entrega</h3>
		<div class="item">
			<p>Endereco: <?php echo $this->escape($this->cliente->endereco); ?> </p>
		</div>
		<div class="item">
			<p>Número: <?php echo $this->escape($this->cliente->numero); ?> </p>
		</div>
		<div class="item">
			<p>Complemento: <?php echo isset($this->cliente->complemento) ? $this->escape($this->cliente->complemento) : 'Nenhum'; ?> </p>
		</div>
		<div class="item">
			<p>CEP: <?php echo $this->escape($this->cliente->cep); ?> </p>
		</div>
		<div class="item">
			<p>Bairro: <?php echo $this->escape($this->cliente->bairro); ?> </p>
		</div>
		<div class="item">
			<p>Cidade: <?php echo $this->escape($this->cliente->cidade); ?> </p>
		</div>
		<div class="item">
			<p>Estado: <?php echo $this->escape($this->cliente->estado); ?> </p>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>		
</fieldset>	