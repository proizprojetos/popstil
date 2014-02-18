$(function() {
      $('#dialog-modal-novafoto').popup();
 });
 
 $(function() {
       $('#dialog-modal').popup();
  });
 

 function uploadImage(input) {
 	if(input.files && input.files[0]) {
 		$('#img_carregando img').css('display','block');
 		
 		//$('#total_foto').attr('src','../components/com_popstil/assets/img/customizacao_total_andamento.gif');
 		$("#formimage").vPB({
 			url: 'http://'+window.location.host+'/index.php?option=com_popstil&format=raw',
 			data: {
 				option:'com_popstil',
 				task:'uploadImageCliente'
 			},
 			success: function(response) 
 			{	
 				$('#idImagem').val(response);
 				var reader = new FileReader();
 				
 				reader.onload = function (e) {
 					//document.getElementById('textopreview').innerHTML = "";
 					$('.textopreview').text('');
 					$('#blah').attr('src', e.target.result)
 							.height(220).css('display', 'block');
 					$('#foto_tab_resumo img').attr('src', e.target.result)
 							.height(220).css('display', 'block');
 					
 				}
 				reader.readAsDataURL(input.files[0]);
 				$('#img_carregando img').hide('slow');
 			},
 			error:function(){
 			    alert('Erro ao enviar a foto, tente novamente.');
 			    $('#img_carregando img').hide('slow');
 			}			
 		}).submit();
 	}
 }
 
 function validacoes() {
 	var validacao = true;
 	var msg = '';
 	if($("#idImagem").val() == '') {
 		validacao = false;
 	}
 	return validacao;
 }