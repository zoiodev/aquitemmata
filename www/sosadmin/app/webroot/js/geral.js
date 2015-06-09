$(document).ready(function(){
	
	$('[data-toggle]._menos, [data-toggle]._mais').click(function(){
		var classNow	= $(this).attr('class');

		// if($(this).children('p').text() == '-'){
		// 	console.log('encontrei -');
		// 	console.log($(this));
		// 	console.log($(this).children('p'));
		// 	$(this).children('p').text('+');
		// }else if($(this).text() == '+'){
		// console.log('encontrei +');
		// 	console.log($(this));
		// 	console.log($(this).children('p'));
		// 	$(this).children('p').text('-');
		// }

		if(classNow.search('_menos') != -1){
			$(this).removeClass('_menos').addClass('_mais');
		}else if(classNow.search('_mais') != -1){
			$(this).removeClass('_mais').addClass('_menos');
		}
		//CSS
	});
	///// TOOGLE (show / hide) ////////////////////
	$('[data-toggle]').click(function(){
		var target 			= $(this).attr('data-toggle-id');
		var effect 			= $(this).attr('data-toggle-effect');
		var wordInitial 	= $(this).html();
		var wordFinished	= $(this).attr('data-toggle-word');
		var widthElement	= $(this).width();
		
		if (!effect){
			$('#'+ target).stop().slideToggle('fast');
		} else {
			eval("$('#'+ target).stop()."+ effect +"('fast');");
		}
		
		//trocando a palavra inial para a final
		if (wordFinished != '') {
			$(this).attr('data-toggle-word', wordInitial);
			$(this).html(wordFinished);
			$(this).width(widthElement);
		}
		
		
	});
	
	$('[data-show-hide]').click(function(){
		//console.log('MOTHERFUCKER');
		var elements_show = $(this).attr('data-show-elements');
		var elements_hide = $(this).attr('data-hide-elements');
		
		var array_show = '';
		var array_hide = '';
		
		if (elements_hide) {
			array_hide = elements_hide.split(' ');
				
			array_hide.forEach(function(entry) {
			    $(entry).slideUp('fast');
			    //$(entry).hide();
			});
		}
		
		if (elements_show) {
			console.log('MOTHERFUCKER');
			console.log(array_show);
			array_show = elements_show.split(' ');
			array_show.forEach(function(entry) {
			    $(entry).slideDown('fast');
			    //$(entry).show();
			});			
		}
	});
	
	
	
	///////// SORTABLE (drag and drop list) ///////////////////////
	$('[data-sortable]').attr('style', 'cursor:ns-resize;');
	$('[data-sortable]').sortable({
		update: function( event, ui ) {
			
			var array_registros = '';				
			var posicao = 0;
			$('[data-sortable-update-id]').each(function(index, element) {
				posicao++;
				
				
				//var id_registro = $(element).attr('id').replace('registro_', '');
				var id_registro = $(element).attr('data-sortable-update-id');
				array_registros += (id_registro) +'|'+ (posicao) +';';
				
				$(element).find('[data-sortable-return-position]').html(posicao);
			});
			
			var registros_posicoes = array_registros.substr(0, array_registros.length-1);
			//alert(registros_posicoes);
			
			var update = $(this).attr('data-sortable-update');
			if (update){
				//eval(''+ update +'();');
				eval(''+ update +';');
			}
			
		}
	});
	$('[data-sortable]').disableSelection();
	
	
	
	
	
	///////// BAR (bar left) ///////////////////////
	$('[data-bar]').each(function(index, element){
		var distancia = $(element).find('span').width()+5;
		$(element).attr('style', 'background:url(assets/img/barra.png) no-repeat; background-position-y: bottom; background-position-x: '+ ( distancia ) +'px; margin-bottom: 12px;');
	});
	
	///////// AJUSTE DO TINYMCE ///////////////////////
	/*
	* MOTIVO: com o formulário totalmente preenchido, a validação do form apresentava 
	* como inválido pela validação, pq o TinyMCE não tinha criado o campo de textarea ainda.
	*/
	var vezes = 0;
	$('form[data-abide]').on('invalid', function () {
		vezes = vezes+1;
		
		var invalid_fields = $(this).find('[data-invalid]');
		console.log(invalid_fields);
		//alert(invalid_fields);
		
		if (vezes == 2) {
			vezes = 0;

		} else {
			window.setTimeout(function(){
				$('form[data-abide]').submit();
			}, 100);
		}
		
		
	})
	.on('valid', function () {
		console.log('valid!');
		//return false;
		//$('form[data-abide]').submit();
	});
	
	
});


function todos(elemento) {
	//alert($(elemento).attr('name')
	if ($(elemento).prop('checked')) {
		$('#checkboxes input[type="checkbox"]').prop('checked', true);
	} else {
		$('#checkboxes input[type="checkbox"]').prop('checked', false);
	}
}