<?php

defined('_JEXEC') or die('Restricted access');
?></div>
<div class="cabecalho_popstil">
	<div id="corpo" class="container">
		<div id="sub-header-wrap" class="row">
			<div class="span1 clearfix" >&nbsp</div>
			<div class="sub-header span10">
				<div class="painel_header">
					<h2>Seja bem-vindo à área de customização do seu Popstil!</h2>
					<p>Abaixo você poderá definir os detalhes do seu quadro para deixá-lo com a sua cara!</p>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!--<hr class="linha_divisao"/>-->

<!--<div class="num_quadros container">
	<div class="span9">
		<span>Quantos quadros com a mesma arte?</span>
		<a class="bt_num_quadros" onclick="atualizaNumeroQuadros(true);" id="bt_mais">+1</a>
		<a class="bt_num_quadros" onclick="atualizaNumeroQuadros(false);" id="bt_menos">-1</a>
		<span id="numero_quadros">1</span>
		<input type="hidden" id="numerodequadros" name="numerodequuadros" value="1">
	</div>
</div>

<hr class="linha_divisao" />-->

	<!-- Novas alteração do layout popstil -->
	<br/>
	<div class="container">
		<div class="row">
			<div class="span12" id="msgValida">
			
			</div>
		</div>
	</div>
	<br/>
	<div class="container tela_customizacao">
		<div class="row">
			<div class="span9">
				<div class="tabs_customizacao" id="tabs_customizacao">
					<ul id="tab" class="nav nav-tabs">
						<li id="titulo_tab_foto" style="position: relative;">
							<a href="#tab_foto" data-toggle="tab"><p>A foto</p>
								
							</a>
						</li>							
						<li id="titulo_tab_tamanho"  style="position: relative;"><a href="#tab_tamanho" data-toggle="tab"><p>Tamanho e moldura</p>
							
						</a></li>
						<li id="titulo_tab_fundo"><a href="#tab_fundo" data-toggle="tab" style="position: relative;"><p>Plano de fundo</p></a></li>
						<li id="titulo_tab_finalizar"><a href="#tab_finalizar" data-toggle="tab"><p>Finalizar pedido</p></a></li>
					</ul>
					<div id="myTabContent" class="tab-content">							
						
						<div id="tab_foto" class="ui-tabs-panel active painel_customizacao">
							<div class="fundo_tab">
								<div class="span8 tab_foto_conteudo">
									<div class="span5">
										<h3>Escolha a fotografia para o seu popstil</h3>
									</div>
									<div class="span3 ">
										<div class="droparea">
											<div id="preview" class="dropareatext preview">
												<img id="blah" src="#" alt="your image" style='display: none;'/>
												<div id="textopreview" class="textopreview">
													Arraste aqui sua foto.
												</div>
											</div>
											
											<form id="formimage" runat="server">
												<!--<input type="file" id="inputdroparea" onchange="readImage(this);" />-->
												<input type="file" id="inputdroparea" name="file_upload" action="" onchange="uploadImage(this);" />
												<div id="img_carregando"><img src="<?php echo JURI::root() ?>/components/com_popstil/assets/img/loading.gif" /></div>
												
											</form>
										</div>
									</div>
									
									<form action="<?php echo JRoute::_('index.php?option=com_popstil&task=customizacao.finalizaPedido'); ?>" method="post"
											name="popstil_customizacao_form" enctype="multipart/form-data" id="form_customizacao">						
									<input type="hidden" id="idImagem" name="quadro[imagem]" value="">
									<!-- numero de pessoas -->
									<div class="tab_foto_direita">
										<div class="span2" id="quadropai0">
											<div class="num_pessoas_wrapper">
												<div class="num_pessoas">
													<h3>Quantas pessoas/animais na foto?</h3>
													<div class="num_pessoas-wrap" id="numero_pessoas">
														<ul id="quadro0">
															<?php foreach($this->listaNumPessoas as $pessoa) { ?>
																		<li id="quadro0pessoa<?php echo $pessoa->id_numpessoas ?>" 
																		data-id="<?php echo $pessoa->id_numpessoas ?>" 
																		data-numeropessoas="<?php echo $pessoa->numero_pessoas ?>"
																		
																		onmouseover="onOverNumPessoas(this)"
																		onmouseout="onOutNumPessoas(this)" 
																		onclick="onClickNumPessoas(this)" 
																		
																		class="tamanho<?php  echo $pessoa->id_tamanho ?>" >
																		<?php echo $pessoa->numero_pessoas ?>
																		</li>
																<?php
																}
																?>									
															</ul>
														</div>
														<input type="hidden" id="idNumeroPessoas" name="quadro[idnumpessoas]" data-preco="0" value="">	
													</div>
													<div id="num_pessoas_selecionado">
														<span id="num_pessoas_quadro"></span>
													</div>
											</div>
											<div style="display: inline-block ;">
												<span><p>Máximo de 5 pessoas</p></span>
											</div>
										</div>
										<div class="span2" id="quadropai0">
											<div  class="orientacao">
												<h3>Orientação do popstil</h3>
												<div class="paisagem">
													<div class="paisagem_image"></div>
													<p>Paisagem</p>
												</div>
												<input type="radio" id="check_paisagem" name="quadro[orientacao]" value="P" onclick="onClickOrientacao()" ></input>
												<div class="retrato">
													<div class="retrato_image"></div>
													<p>Retrato</p>
												</div>
												<input type="radio" id="check_retrato" name="quadro[orientacao]" value="R" onclick="onClickOrientacao()"></input>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div id="tab_tamanho" class="ui-tabs-panel painel_customizacao">
							<div class="fundo_tab">
								<div class="row quadro_wrapper" >
									<div class="span8" >
									<!--<hr class="linha_divisao"/>-->
									<div class="span5" >
										<div class="wrapper-tamanhos">
												
												<div class="wrapper-msgembreve" >
												    <div class="msgembreve" style="display:none;">
												      <h4>Selecione o numero de pessoas antes</h4>
												     </div>
												</div>
												
												<div class="div_tamanhos">
													<h3>Tamanho</h3>
													<?php 
													foreach($this->listaCategorias as $cat) { ?>
														<div class="wrap_<?php echo strtolower(substr($cat->titulo, 0,4)) ?>">
															<div id="<?php echo strtolower(substr($cat->titulo, 0,4)); ?>pai" 
																class="<?php echo strtolower(substr($cat->titulo, 0,4)); ?>">
																<?php 
																	foreach($this->getListaTamanhos($cat->id_cat_tamanho) as $tam) {  ?>
																		<div id="quad1<?php echo strtolower(substr($cat->titulo, 0,4))."".$tam->id_tamanho ?>numpessoa<?php echo $tam->id_numpessoas ?>"
																			data-idTamanho="<?php echo $tam->id_tamanho ?>"
																			data-idnumpessoas="<?php echo $tam->id_numpessoas ?>"
																			class="quadfilho1 quadro"
																			data-classe="quadfilho1"
																			style="<?php echo $tam->estilo?>"
																			data-texto="texto1<?php echo substr($cat->titulo, 0,4); ?>"
																			data-tamanho="<?php echo $tam->largura."x".$tam->altura?> cm"
																			onclick="flag[0] = !flag[0]; onmouseoverQuad(this)"
																			data-numerodoquadro="0"
																			onmouseover="onmouseoverQuad(this)" 
																			onmouseout="limpaTextoMouseOut(this)"
																			data-preco="<?php echo $tam->preco ?>"
																			>
																		</div>
																	<?php 
																	}
																?>
															</div>
															<div class="texto_<?php echo strtolower(substr($cat->titulo, 0,4)); ?>">
																<p><?php echo $cat->titulo; ?></p>
																<div id="texto1<?php echo (substr($cat->titulo, 0,4)); ?>">
																	&nbsp;
																</div>
															</div>
														</div>
													<?php 
														}							
													?>
												</div>	
											</div>	
											<input type="hidden" id="idTamanhoQuadro0" name="quadro[0][tamanho]" data-preco="0" value="">
									</div>
									
									<!-- Moldura do quaro -->
									<div class="span3">					
										<div class="cor_moldura" id="molduraquadro0">
											<h3>Moldura</h3>
											<?php foreach($this->listaMolduras as $moldura) { ?>
												<div class="cor_moldura_wrap">
													<span></span>
													<img id="idmoldura<?php echo $moldura->id_moldura; ?>quadro0" 
														 data-idMoldura="<?php echo $moldura->id_moldura; ?>"
														 alt="<?php echo $moldura->titulo; ?>"
														 src="<?php echo JURI::base().''.$moldura->url_moldura; ?>"
														 data-numerodoquadro="0"
														 onclick="onClickMoldura(this)"
													/>
													<p><?php echo $moldura->titulo; ?></p>
												</div>					
											<?php } ?>
										</div>
										<input type="hidden" id="idCorMoldura0" name="quadro[0][idcormoldura]" value="">
									</div>
									
									
									</div>
								</div>
							</div>
						</div>
						
						<div id="tab_fundo" class="ui-tabs-panel painel_customizacao">
							<div class="fundo_tab">
								<div class="row plano_fundo">
									<div class="span8">
										<h3>O plano de fundo terá</h3>
										<div id="tabs">
											<ul class="nav nav-tabs tab_fundo">
												<li >
													<a href="#tabs-1" data-toggle="tab"><p>Padrão gráfico</p></a>
												</li>							
												<li>
													<a href="#tabs-2" data-toggle="tab"><p>Única cor</p></a>
												</li>
											</ul>
											
											<div id="myTabContent" class="tab-content">				
												
												<div id="tabs-1" class="tab-pane ">
													<div class="tabcontent padraograficos">
														<select class="selectCategoriaQuadro0"  name="parent" size="10">
															<?php foreach ($this->padroes as $chave => $cat) { ?>
																<option value="<?php echo $cat->id; ?>"><?php echo $cat->descricao; ?></option>												
															<?php } ?>
														</select>
														<select class="selectSubCategoriaQuadro0" size="10">
															<?php foreach ($this->padroes as $chave => $cat) { 
																foreach ($cat->categorias as $key => $value) { ?>
																	<option value="<?php echo $value->id; ?>" class="sub_<?php echo $value->id_categoria; ?>"><?php echo $value->descricao; ?></option> 
																<?php } ?>
															<?php } ?>
														</select>
														<select class="selectItensQuadro0" size="10">
															<?php foreach ($this->padroes as $chave => $cat) { 
																foreach ($cat->categorias as $key => $value) { 
																	foreach ($value->itens as $item) { ?>
																		<option value="<?php echo $item->id_fundo; ?>" 
																				class="item_<?php echo $item->id_subcategoria; ?>"
																				data-imagem="<?php echo  JURI::root().''. $item->url_imagem; ?>"
																				data-quadro="0"
																				>
																			<?php echo $item->descricao; ?>
																		</option> 
																	<?php } ?>
																<?php } ?>
															<?php } ?>
														</select>
														<div class="grafico_imagem" id="idimgpadraquadro0">
															<img src="<?php echo JURI::root() ?>/components/com_popstil/assets/img/visualizacao_padraografico.jpg" alt="fundo"/>
														</div>
													</div>
												</div>
												<div id="tabs-2" class="tab-pane">
													<div class="tabcontent" id="fundoquadro0">
														<p>Selecione uma das cores abaixo:</p>
														<div id="cores">
															<?php foreach ($this->listaCores as $chave => $cor) { ?>
																<div class="cor">
																	<span style="background-color:#<?php echo $cor->codigo_cor ?>;" 
																		data-idFundo="<?php echo $cor->id_fundo ?>"
																		id="idfundo<?php echo $cor->id; ?>quadro0"
																		data-numerodoquadro="0"
																		onclick="onClickCorSolida(this)">													
																	</span>
																</div>
															<?php } ?>
														</div>
														
													</div>					
												</div>
												
												<input type="hidden" id="idFundo0" name="quadro[0][idfundo]" value="">
											</div>
										</div>	
									</div>							
								</div>
							</div>
						</div>
						
						<div id="tab_finalizar" class="ui-tabs-panel painel_customizacao">
							<div class="fundo_tab fundo_tab_resumo">
								<div class="row">
									<div class="span8 tab_resumo">
										<div id="foto_tab_resumo" class="dropareatext preview">
											<img  src='#' style="display:none ;"/>
											<div id="textopreview" class="textopreview">
												Selecione uma foto!
											</div>
										</div>
										<div id="mensagem_tab_resumo" >										
											<h2>Ops...!Você ainda não completou todas as etapas!</h2>
											<h4>&nbsp</h4>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>				
		<div class="span2 customizacao_direita">
			<hr class="linha_divisao"/>	
			<h4><img id="total_foto" src="<?php echo JURI::root() ?>/components/com_popstil/assets/img/customizacao_total_aguardando.png" alt="" />Foto</h4>
			<hr class="linha_divisao"/>
			<h4><img id="total_pessoas" src="<?php echo JURI::root() ?>/components/com_popstil/assets/img/customizacao_total_aguardando.png" alt="" />Número de Pessoas</h4>
			<hr class="linha_divisao"/>
			<h4><img id="total_orientacao" src="<?php echo JURI::root() ?>/components/com_popstil/assets/img/customizacao_total_aguardando.png" alt="" />Orientação</h4>
			<hr class="linha_divisao"/>
			<h4><img id="total_tamanho" src="<?php echo JURI::root() ?>/components/com_popstil/assets/img/customizacao_total_aguardando.png" alt="" />Tamanho</h4>
			<hr class="linha_divisao"/>
			<h4><img id="total_moldura" src="<?php echo JURI::root() ?>/components/com_popstil/assets/img/customizacao_total_aguardando.png" alt="" />Moldura</h4>
			<hr class="linha_divisao"/>
			<h4><img id="total_fundo" src="<?php echo JURI::root() ?>/components/com_popstil/assets/img/customizacao_total_aguardando.png" alt="" />Plano de fundo</h4>
			<hr class="linha_divisao"/>
			
			
			<div id="total" style="display:none ;">
				<h2 id="valorTotal"></h2>
				<h3 >Ou 10x de <span id="parcelas"></span> sem juros no cartão</h3>
			</div>
			<div class="bt_azul" ><a href='#'  onclick="if(!validacoes()) {
						return false;
					}else {
						document.popstil_customizacao_form.submit();
					}">Finalizar pedido</a>
			</div>
		</div>
		
	</div>
</div>	
</div>