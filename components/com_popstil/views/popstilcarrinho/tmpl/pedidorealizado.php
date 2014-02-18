<?php

defined('_JEXEC') or die('Restricted access');


JHtml::_('behavior.keepalive');
?>
</div>
<div>
		<hr class="linha_divisao"/>
		<div  id="wrapper_carrinho">
			<div id="inner_carrinho" style="width:100%" class="finalizada">
				<div id="carrinhoMsg">
					<div id="imgCarrinhoMsg">
					</div>
					<div id="msgCarrinho" >
	                    <h1>Pedido realizado com sucesso!</h1>
						<h3>Sua fotografia está sendo analisada por nossa equipe.<br/>
						Você efetuará o pagamento apenas quando sua foto for aprovada.						
						</h3>
						<h5>Uma confirmação do pedido foi enviada para seu email.	</h5>
                    </div>
				</div>
				<div id="carrinhoItens">
					<div id="conteudoCarrinho">
						<div id="tituloCarrinhoItens">
                            <h3>Detalhes do pedido</h3>	
                        </div>
                       	<div class="detalhepedidorealizado">
	                       <h4>Numero do pedido: <?php if(isset($this->dadospedidorealizado['numeropedido'])) { echo JText::_($this->dadospedidorealizado['numeropedido']);} ?></h4>
	                    </div>
	                    
					
                    <div id="totalcarrinho">
                    
                        <hr style="border-bottom: 1px solid #dcdcdc" />
                        
                        <div id="carrinho_subtotal">
                            <p>Subtotal: R$<?php if(isset($this->dadospedidorealizado['subtotal'])) { echo ($this->dadospedidorealizado['subtotal']);}  ?></p>
                        </div>
                        
                        <div id="carrinho_fretefinalizado">
                            <p>Valor do frete: R$<?php if(isset($this->dadospedidorealizado['valorfrete'])) { echo ($this->dadospedidorealizado['valorfrete']);} ?></p>
                        </div>
                        
                        <div id="carrinho_total">
                            <p>Total: R$<?php if(isset($this->dadospedidorealizado['total'])) { echo ($this->dadospedidorealizado['total']);} ?></p>
                        </div>
                        
                        <hr style="border-bottom: 1px solid #dcdcdc" />
                     </div>
					
				</div>
			
				
				
				
			</div>
	
		</div>
		
</div>