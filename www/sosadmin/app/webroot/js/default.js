//var carousel_index = 0;
var carousel_pos = 0;
$(function (){

	//Index Hide/Show
	$('#conteudoG #escolha_conteudo_generico').change(function(){
		if($('#conteudoG #escolha_conteudo_generico option:selected').attr('value') != ''){
			window.location = $('#conteudoG #escolha_conteudo_generico option:selected').attr('rel');
		// 	$('.open_div').hide(180);
		// }else{
		// 	$('.open_div').hide(60);
		// 	$('.open_div').show(180).find('.title').find('h4').text($('#conteudoG #escolha_conteudo_generico option:selected').text());
		}
	})

	//IMGS CONTEUDOS
	$('.images_galeria.conteudos .img_close').click(function(){
		//var decisao = confirm("Tem certeza que deseja deletar a imagem \""+$(this).attr('src').split('/')[$(this).attr('src').split('/').length-1]+"\"?");
		var decisao = confirm("Tem certeza que deseja deletar a imagem?");
		if (decisao){
			var id = $(this).parent().parent().attr('id');
			//console.log((webroot) + "admin/conteudos/galeria/delete/"+ id);
			$.post( (webroot) + "admin/conteudos/galeria/delete/"+ id, function(data){
				console.log(data);
				//if(data){
					//$(this).parent().remove();
				//}else{
				//	alert('Não foi possível deletar a imagem!');
				//}
			});
			$(this).parent().parent().remove();
			
		} else {
			alert('Imagem não deletada.');
		}
	});
	//IMGS MANIFESTACOES
	$('.images_galeria.manifestacoes .img_close').click(function(){
		//var decisao = confirm("Tem certeza que deseja deletar a imagem \""+$(this).attr('src').split('/')[$(this).attr('src').split('/').length-1]+"\"?");
		var decisao = confirm("Tem certeza que deseja deletar a imagem?");
		if (decisao){
			var id = $(this).parent().parent().attr('id');
			//console.log((webroot) + "admin/mapas/galeria/delete/"+ id);
			$.post( (webroot) + "admin/mapas/galeria/delete/"+ id, function(data){
				
				console.log(data);
				//if(data){
					//$(this).parent().remove();
				//}else{
				//	alert('Não foi possível deletar a imagem!');
				//}
			});
			$(this).parent().parent().remove();
			
		} else {
			alert('Imagem não deletada.');
		}
	});

	//Conteudo Generico
	$('form #categorias').change(function(){
		$('.view .categoria p').text($('form #categorias option:selected').text());
	});

	$('form #news_titulo').on('input',function(){
		$('.view .title p').text($('form #news_titulo').val());
	});
	$('.view .title p').text($('form #news_titulo').val());

	//Mapa Manifestacoes
		//Control para "aplicativo" (espelhamento de inputs com img)
	$('form #local_manifestacao').on('input',function(){
		$('.viewM .local p').text($('form #local_manifestacao').val());
	});
		$('.viewM .local p').text($('form #local_manifestacao').val());
	$('form #geral_horario').on('input',function(){
		$('.viewM .horario p').text($('form #geral_horario').val());
	});
		$('.viewM .horario p').text($('form #geral_horario').val());
	$('form #geral_pessoas').on('input',function(){
		$('.viewM .pessoas p').text($('form #geral_pessoas').val());
	});
		$('.viewM .pessoas p').text($('form #geral_pessoas').val());
	$('form #local_partida').on('input',function(){
		$('.viewM .partida p').text($('form #local_partida').val());
	});
		$('.viewM .partida p').text($('form #local_partida').val());
	$('form #local_chegada').on('input',function(){
		$('.viewM .chegada p').text($('form #local_chegada').val());
	});
		$('.viewM .chegada p').text($('form #local_chegada').val());
	$('form #geral_fonte').on('input',function(){
		if($('form #geral_fonte').val() != ''){
			$('.viewM .fonte').css('display','block').unbind().click(function(){
				alert($("form #geral_fonte").val());
			});
		}
	});
	$('form #local_estate').change(function() {
		var id = $(this).val();

		document.getElementById('local_city').disabled=false;
		//var data = ['Sao paulo','Campinas','Santos','Atibaia'];
		$.post( (webroot) + "admin/mapas-manifestacoes/cidades/"+ (id), function(data){
			if(data){
				//console.log(data);
				/*
				var options = '';
				for (var i = 0; i < data.length; i++) {
					options += '<option value="'+data[i]+'"">'+data[i]+'</option>';
				};
				*/
				
				$('form #local_city').html(data).css('background', 'white');
			}
		});
	});

	//IMAGE CAROUSEL
	$('.carousel_next').click(function(){
		//if(carousel_index >= $('.carousel > ul li').length) return;
		moveCarousel('left');
	});

	$('.carousel_last').click(function(){
		//if(carousel_index <= 4) return;
		moveCarousel('right');
	});

	//console.log($('.carousel li').height());
	$('.carousel').css('height', $('.carousel li').height() * 2);

	// for (var i = 0; i < $('.carousel > ul li').length; i++) {
	// 	if(i >= 4){
	// 		$('.carousel > ul li').eq(i).css('display', 'none');
	// 	}
	// };
	//carousel_index = 5;
});


function moveCarousel(direction){
	//console.log('moveCarousel( '+direction+' );');
	if(direction == 'left'){
		//$('.carousel > ul li').eq(carousel_index).css('display', 'inline-block');
		TweenMax.fromTo($('.carousel ul'), .5, {css:{x: carousel_pos}}, {css:{x: -$('.carousel > ul li').width()},onComplete: onFinishMoveLeft});
		carousel_pos -= $('.carousel > ul li').width();
	}else if(direction == 'right'){
		//$('.carousel > ul li').eq(carousel_index - 5).css('display', 'inline-block');
		TweenMax.fromTo($('.carousel ul'), .5, {css:{x: 0}}, {css:{x: $('.carousel > ul li').width()},onComplete: onFinishMoveRight});
		carousel_pos += $('.carousel > ul li').width();
	}else{

	}
}

function onFinishMoveLeft(){
	//$('.carousel > ul li').eq(carousel_index - 5).css('display', 'none');
	//TweenMax.fromTo($('.carousel ul'), 0.0001, {css:{x: 0}}, {css:{x: 0}});
	//carousel_index++;
}

function onFinishMoveRight(){
	//$('.carousel > ul li').eq(carousel_index).css('display', 'none');
	//TweenMax.fromTo($('.carousel ul'), 0.0001, {css:{x: 0}}, {css:{x: 0}});
	//carousel_index--;
}

function callOnTinyMCE(){
	$('.mce-edit-area iframe').contents().keyup(uploadToIphoneView);
	$('#mce_14, #mce_14 button').click(uploadToIphoneView);
}

function uploadToIphoneView(){
	var body = $('.mce-edit-area iframe').contents().find('body').html();
	$('.view .text').html(body);
	$('.viewM .text').html(body);
}