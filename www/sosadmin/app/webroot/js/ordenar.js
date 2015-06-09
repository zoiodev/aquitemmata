function updatePositionDB(caminho) {
	//alert(caminho);
	var array_registros = '';
	var documentos = $('#documentos').val();
	
	var posicao = 0;
	$('[data-sortable] tr').each(function(index, element) {
		posicao++;
		
		var id_registro = $(element).attr('data-sortable-update-id');
		array_registros += (id_registro) +'|'+ (posicao) +';';
	});
	
	var registros_posicoes = array_registros.substr(0, array_registros.length-1);
	//alert(registros_posicoes);
	
	$.ajax({
		type: 'POST',
		url: caminho,
		//data: {registros: registros_posicoes, documentosTipo: documentos},
		data: {registros: registros_posicoes},
		success: function(data) {
			//alert(data);
			//console.log(data);
			
			var texto = 'Ordem alterada com sucesso!';
			$('#ordem_retorno').html('<div data-alert class="alert-box">'+ texto  +' <a href="javascript:void(0);" onClick="$(\'[data-alert]\').slideUp();" class="close">&times;</a></div>');
			
		}
	});
}