$(function() {

	$('#faq h3').click(function() {
	  	var pai = $(this);
	  	$(this).parent().find('.texto').slideToggle('slow',function() {
	  		if($(pai).hasClass('ativo')) {
		  		$(pai).removeClass('ativo');
	  		}else {
	  			$(pai).addClass('ativo');	
	  		}
	  		
	  	});						
	});
});