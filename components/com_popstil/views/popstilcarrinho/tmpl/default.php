<?php

defined('_JEXEC') or die('Restricted access');
?></div>
<div class="cabecalho_popstil">
	<div id="corpo" class="container">
		<div id="sub-header-wrap" class="row">
			<div class="span1 clearfix" >&nbsp</div>
			<div class="sub-header span10">
				<div class="painel_header">
					<h2>Carrinho</h2>
					<p>Confira abaixo os itens e os detalhes do seu pedido</p>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

</div>

<div class="cabecalho_carrinho">
		<div  id="wrapper_carrinho">
			<form action="<?php echo JRoute::_('index.php?option=com_popstil&task=carrinho.finalizarPedido'); ?>" method="post" name="adminForm" id="adminForm">
			<div id="inner_carrinho" style="width:100%">
				<div id="carrinhoMsg">
					<div id="imgCarrinhoMsg">
						
					</div>
					<div id="msgCarrinho">
	                    <h1>Você está a poucos passos de ter o seu Popstil exclusivo!</h1>
						<h3>Confira os detalhes ao lado e confirme seu pedido:</h3>
						<div id="btnconfirmapedido">
	        	            <button type="submit" class="btnconfirma ">Confirme seu pedido</button>	
        	            </div>
                    </div>
				</div>
			</form>
				<div id="carrinhoItens">
					<div id="conteudoCarrinho">
						<div id="tituloCarrinhoItens">
                            <h3>Detalhes do pedido</h3>	
                        </div>
                        <?php if(sizeof($this->carrinho_tela) == 0) { ?>
							<div id="carrinhoVazio">
                            	<h3>Seu carrinho está vazio</h3>
                                <br/ >
                                <a href="/index.php/customizacao" class="btazulpadrao">Faça o seu pedido agora mesmo.</a>
                            </div>
						<?php } ?>
                        <?php foreach($this->carrinho_tela as $chave => $item) { ?>
                        	<div class="item">
                            	<div class="itemCarrinho">
                                	<div class="fotoItem">
										<img src="<?php echo $item["imagem"] ?>"/>	
									</div>
                                    <div class="detalheItem">
										<h4>Quantidade de quadros: <?php echo $item['numquadros'] ?></h4>
										<h4>Nº de pessoas: <?php echo ($item['numpessoas']) ?></h4>
									</div>
                                    <div class="quadrosItem">
                                    	<?php foreach($item as $subchave => $quadro) {  ?>
                                        	<?php  if((string) $subchave == 'quadros') {
												$nrquadro = 0; ?>
                                            	<?php foreach($quadro as $subquadro => $quadroitem ) { ?>
                                                    <div class="detalheQuadro">
                                                        <div class="conteudoDetalheQuadro">
                                                        	<form action="<?php echo JRoute::_('index.php?option=com_popstil&task=carrinho.removerquadro'); ?>" method="post"
															name="popstil_carrinhoremovequadro_form" enctype="multipart/form-data">
                                                            	<input type="hidden" name="posicaoquadro" value="<?php echo $chave.','.$subquadro ?>" />
                                                                <input type="submit" class="btnremove" value="X" id="brremove_quadro"  />                                                                
                                                            </form>
                                                            <h2>Quadro <?php echo $nrquadro +=1;?></h2>
                                                            <h4>Tamanho: <?php echo $quadroitem['tamanho']?> </h4>
                                                            <h4>Moldura: <?php echo $quadroitem['moldura']?> </h4>
                                                        </div>
                                                    </div> 
                                                <?php } ?>
                                            <?php } ?>                                            
                                        <?php } ?>
                                     </div>
                                </div>
                            </div>
                        <?php } ?>
					
                    <div id="totalcarrinho">
                    
                        <hr style="border-bottom: 1px solid #dcdcdc" />
                        
                        <div id="carrinho_subtotal">
                            <p>Subtotal: <?php echo 'R$' . number_format($this->valorSubtotal, 2, ',', '.'); ?></p>
                        </div>
                        
                        <div id="carrinho_frete">
                        	<div id="calcularFrete">
                            	<form action="<?php echo JRoute::_('index.php?option=com_popstil&task=carrinho.calcularFrete'); ?>" method="post"
            						name="popstil_carrinhofrete_form" enctype="multipart/form-data">
                                    <input id="cep_carrinho" type="text" name="cepDestino" maxlength="8" value="<?php echo $this->cepdigitado ?>"/>
									<select name="tipo_frete">
                                    	<option value="pac" " <?php echo $this->fretepac == 1 ? 'selected' : '' ?>">PAC</option>
                                    	<option value="sedex" <?php echo $this->fretepac == 0 ? 'selected' : '' ?>>Sedex</option>
                                    </select>
                                    <input type="submit" class="btnconfirma" value="Calcular frete" id="btncarrinho_cep"  />                                
                              	</form>
                                <?php if(!$this->cepinvalido) { ?>
                                	<h5 class="msgErro"> Cep informado é invalido. </h5>
                                <?php } ?>
                            </div>
                            <p>Valor do frete: <?php echo 'R$' . number_format($this->getValorFrete(), 2, ',', '.'); ?></p>
                        </div>
                        
                        <div id="carrinho_frete">
                        	<div id="calcularFrete">
                            	<form action="<?php echo JRoute::_('index.php?option=com_popstil&task=carrinho.calcularDesconto'); ?>" method="post"
                        			name="adminForm" enctype="multipart/form-data">
                                    <input id="codigo_desconto" type="text" name="codDesconto" maxlength="100" 
                                    	value="<?php if(isset($this->descDesconto)) { echo $this->descDesconto; } ?>"/>
                                    <input type="submit" class="btnconfirma" value="Calcular desconto" id="btncarrinho_cep"  />                                
                              	</form>                            </div>
                            <p>Valor do desconto: <?php echo 'R$' . number_format($this->valorDesconto, 2, ',', '.'); ?></p>
                        </div>
                        
                        <div id="carrinho_total">
                            <p>Total: <?php echo 'R$' . number_format($this->valorTotal, 2, ',', '.');  ?></p>
                        </div>
                        
                        <hr style="border-bottom: 1px solid #dcdcdc" />
                     </div>
					
				</div>
			
				
				
				
			</div>
	
		</div>
		
</div>
