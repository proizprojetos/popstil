<?php defined('_JEXEC') or die; ?>
<?php echo $this->loadTemplate('page_heading'); ?>

<div class="container alterarsenha">
	<h3>ALTERAR MEUS DADOS</h3>
		<hr class="linha_divisao"/>
	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_popstil&task=painel.alterardados&idusuario='.$this->user->id); ?>" method="post" class="form-validate" name="adminForm" enctype="multipart/form-data">
		<div class="row">
			<div class="cadastro_input span12">
				<div class=" ">
					<span>*</span>
					<input type="text" name="cadastro[nomecompleto]" placeholder="Nome Completo" id="register_name" 
					value="<?php if(isset($this->data->nomecompleto)) { echo JText::_($this->data->nomecompleto);} ?>" 
					class="inputbox required validate-texto" required="required" maxlength="120" style="width:450px">
				</div>
			</div>		
			
			<div class="cadastro_input">
				<div class="span7">
					<span>*</span>
					<input type="text" name="cadastro[cpf]" placeholder="CPF" id="register_cpf" 
					value="<?php if(isset($this->data->cpf)) { echo JText::_($this->data->cpf);} ?>" 
					class="inputbox" maxlength="11" >
				</div>
			</div>
			
			<div class="cadastro_input">
				<div class=" span7">
					<span>*</span>
					<input type="text" name="cadastro[datanascimento]" placeholder="Data de nascimento"
					value="<?php if(isset($this->data->datanascimento)) { echo JText::_($this->data->datanascimento);} ?>" 
					id="register_datanascimento"class="inputbox" maxlength="8" >
				</div>
			</div>
			
			<div class="cadastro_input">
				<div class=" span7">
					<span>*</span>
					<select name="cadastro[sexo]" id="register_sexo"
					value="<?php if(isset($this->data->sexo)) { echo JText::_($this->data->sexo);} ?>" >
						<option value="S">Sexo</option>
						<option value="M" <?php if(isset($this->data->sexo) && ($this->data->sexo == 'M')) { echo 'selected';} ?>>Masculino</option>
						<option value="F" <?php if(isset($this->data->sexo) && ($this->data->sexo == 'F')) { echo 'selected';} ?>>Feminino</option>
					</select>
				</div>
			</div>
			
			<div class="cadastro_input">
					<div class=" span7">
						<span>*</span>
						<input type="text" name="cadastro[ddd1]" placeholder="DDD"
						id="register_ddd1" class="inputbox" maxlength="3" style="width:50px" 
						value="<?php if(isset($this->data->ddd1)) { echo JText::_($this->data->ddd1);} ?>">
						<input type="text" name="cadastro[telefone1]" placeholder="Telefone preferencial"
						id="register_telefone1" class="inputbox" maxlength="9" 
						value="<?php if(isset($this->data->telefone1)) { echo JText::_($this->data->telefone1);} ?>">
					</div>
				</div>
				
				<div class="cadastro_input">
					<div class=" span7">
						<input type="text" name="cadastro[ddd2]" placeholder="DDD"
						id="register_ddd2" class="inputbox" maxlength="3" style="width:50px" 
						value="<?php if(isset($this->data->ddd2)) { echo JText::_($this->data->ddd2);} ?>">
						<input type="text" name="cadastro[telefone2]" placeholder="Telefone alternativo"
						id="register_telefone2" class="inputbox" maxlength="9" 
						value="<?php if(isset($this->data->telefone2)) { echo JText::_($this->data->telefone2);} ?>"
						>
					</div>
				</div>
				
				<div class="cadastro_input">
					<div class=" span7">
						<span>*</span>
						<input type="text" name="cadastro[username]" placeholder="Nome de usuário"
						id="register_username" class="inputbox" 
						value="<?php if(isset($this->data->username)) { echo JText::_($this->data->username);} ?>">
					</div>
				</div>
				
				<div class="cadastro_input">
					<div class=" span7">	
						<span>*</span>
						<input type="text" name="cadastro[email]" placeholder="Email" style="width:350px" id="register_email" 
						value="<?php if(isset($this->data->email)) { echo JText::_($this->data->email);} ?>"
						class="inputbox " maxlength="120">
					</div>
				</div>
				
				<div class="cadastro_input">
					<div class=" span4">
						<span>*</span>
						<p>Gostaria de receber e-mails com novidades, ofertas e promoções da popstil.com?</p>
					</div>
					<div class=" span2" value="<?php if(isset($this->data->enviaremail)) { echo JText::_($this->data->enviaremail);} ?>">						
						<input type="radio" name="cadastro[enviaremail]" value="S" 
						<?php if(isset($this->data->enviaremail) && ($this->data->enviaremail == 'S')) { echo 'checked';} ?>>
						Sim</input>
						<input type="radio" name="cadastro[enviaremail]" value="N"
						<?php if(isset($this->data->enviaremail) && ($this->data->enviaremail == 'N')) { echo 'checked';} ?>>
						Não</input>						
					</div>
				</div>
				<br />
				<br />
				<div class=" span12">
					<h3>CADASTRO DE ENDEREÇO</h3>
					<hr class="linha_divisao"/>
				</div>
				<input type="hidden" name="cadastro[id_endereco]" value="<?php echo $this->data->id; ?>" />
				<div class="cadastro_input">
					<div class=" span7">
						<span>*</span>
						<input type="text" name="cadastro[cep]" placeholder="CEP" 
						id="register_cep"class="inputbox" maxlength="120"
						value="<?php if(isset($this->data->cep)) { echo JText::_($this->data->cep);} ?>">
					</div>
				</div>
				
				<div class="cadastro_input">
					<div class=" span7">
						<span>*</span>
						<input type="text" name="cadastro[endereco]" placeholder="Endereço" 
						id="register_endereco" style="width:350px"class="inputbox" maxlength="240"
						value="<?php if(isset($this->data->endereco)) { echo JText::_($this->data->endereco);} ?>">
					</div>
				</div>
				
				<div class="cadastro_input">
					<div class=" span7">
						<span>*</span>
						<input type="text" name="cadastro[numero]" placeholder="Numero" 
						id="register_numero" class="inputbox" maxlength="240"
						value="<?php if(isset($this->data->numero)) { echo JText::_($this->data->numero);} ?>">
						<input type="text" name="cadastro[complemento]" placeholder="Complemento" 
						id="register_complemento" class="inputbox" maxlength="240"
						value="<?php if(isset($this->data->complemento)) { echo JText::_($this->data->complemento);} ?>">
					</div>
				</div>
				
				
				
				<div class="cadastro_input">
					<div class=" span7">
						<span>*</span>
						<input type="text" name="cadastro[bairro]" placeholder="Bairro" 
						id="register_bairro"
						value="<?php if(isset($this->data->bairro)) { echo JText::_($this->data->bairro);} ?>"
						class="inputbox" maxlength="240">
						
					</div>
				</div>
				
				<div class="cadastro_input">
					<div class=" span7">
						<span>*</span>
						<input type="text" name="cadastro[cidade]" placeholder="Cidade" 
						id="register_cidade"
						value="<?php if(isset($this->data->cidade)) { echo JText::_($this->data->cidade);} ?>"
						class="inputbox" maxlength="240">
					</div>
				</div>
				
				<div class="cadastro_input">
					<div class=" span7">
						<span>*</span>
						<select name="cadastro[estado]" id="register_estado">
							<option value="">Estado</option>
							<option value="AL">Alagoas</option>
							<option value="AP" <?php if(isset($this->data->estado) && ($this->data->estado == 'AP')) { echo 'selected';} ?>>Amapá</option>
							<option value="AM" <?php if(isset($this->data->estado) && ($this->data->estado == 'AM')) { echo 'selected';} ?>>Amazonas</option>
							<option value="BA" <?php if(isset($this->data->estado) && ($this->data->estado == 'BA')) { echo 'selected';} ?>>Bahia</option>
							<option value="CE" <?php if(isset($this->data->estado) && ($this->data->estado == 'CE')) { echo 'selected';} ?>>Ceará</option>
							<option value="DF" <?php if(isset($this->data->estado) && ($this->data->estado == 'DF')) { echo 'selected';} ?>>Distrito Federal</option>
							<option value="GO" <?php if(isset($this->data->estado) && ($this->data->estado == 'GO')) { echo 'selected';} ?>>Goiás</option>
							<option value="ES" <?php if(isset($this->data->estado) && ($this->data->estado == 'ES')) { echo 'selected';} ?>>Espírito Santo</option>
							<option value="MA" <?php if(isset($this->data->estado) && ($this->data->estado == 'MA')) { echo 'selected';} ?>>Maranhão</option>
							<option value="MT" <?php if(isset($this->data->estado) && ($this->data->estado == 'MT')) { echo 'selected';} ?>>Mato Grosso</option>
							<option value="MS" <?php if(isset($this->data->estado) && ($this->data->estado == 'MS')) { echo 'selected';} ?>>Mato Grosso do Sul</option>
							<option value="MG" <?php if(isset($this->data->estado) && ($this->data->estado == 'MG')) { echo 'selected';} ?>>Minas Gerais</option>
							<option value="PA" <?php if(isset($this->data->estado) && ($this->data->estado == 'PA')) { echo 'selected';} ?>>Pará</option>
							<option value="PB" <?php if(isset($this->data->estado) && ($this->data->estado == 'PB')) { echo 'selected';} ?>>Paraiba</option>
							<option value="PR" <?php if(isset($this->data->estado) && ($this->data->estado == 'PR')) { echo 'selected';} ?>>Paraná</option>
							<option value="PE" <?php if(isset($this->data->estado) && ($this->data->estado == 'PE')) { echo 'selected';} ?>>Pernambuco</option>
							<option value="PI" <?php if(isset($this->data->estado) && ($this->data->estado == 'PI')) { echo 'selected';} ?>>Piauí­</option>
							<option value="RJ" <?php if(isset($this->data->estado) && ($this->data->estado == 'RJ')) { echo 'selected';} ?>>Rio de Janeiro</option>
							<option value="RN" <?php if(isset($this->data->estado) && ($this->data->estado == 'RN')) { echo 'selected';} ?>>Rio Grande do Norte</option>
							<option value="RS" <?php if(isset($this->data->estado) && ($this->data->estado == 'RS')) { echo 'selected';} ?>>Rio Grande do Sul</option>
							<option value="RO" <?php if(isset($this->data->estado) && ($this->data->estado == 'RO')) { echo 'selected';} ?>>Rondônia</option>
							<option value="RR" <?php if(isset($this->data->estado) && ($this->data->estado == 'RR')) { echo 'selected';} ?>>Roraima</option>
							<option value="SP" <?php if(isset($this->data->estado) && ($this->data->estado == 'SP')) { echo 'selected';} ?>>São Paulo</option>
							<option value="SC" <?php if(isset($this->data->estado) && ($this->data->estado == 'SC')) { echo 'selected';} ?>>Santa Catarina</option>
							<option value="SE" <?php if(isset($this->data->estado) && ($this->data->estado == 'SE')) { echo 'selected';} ?>>Sergipe</option>
							<option value="TO" <?php if(isset($this->data->estado) && ($this->data->estado == 'TO')) { echo 'selected';} ?>>Tocantins</option>							
						</select>
					</div>
				</div>
			
			<div class="span7" style="text-align: right;">
				<div class="bt_salvar">
					<input type="submit" class="" value="Salvar"/>
				</div>
			</div>
		</div>
			
	</div>
</div>