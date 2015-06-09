var app = angular.module('app',["ngRoute", "ngAutocomplete", "ngSanitize"]);

app.config(['$routeProvider', function($routeProvider){
	$routeProvider.
	when('/', {
			templateUrl: 'home.html',
			controller:'homeController',
			}).
	when('/sobre', {
			controller:'sobreController',
			templateUrl: 'sobre.html'
		}).
	when('/como-funciona', {
			controller:'comoFuncionaController',
			templateUrl: 'como_funciona.html'
		}).
	when('/termos-de-uso', {
			controller:'termoDeUsoController',
			templateUrl: 'termos-de-uso.html'
		}).
	when('/mapa/:ufId/:municipioId', {
			controller:'IbgeCtrl',
			templateUrl: 'resultado.html'
		}).
	// when('/resultado', {
	// 		title: 'Resultados',
	// 		controller:'IbgeCtrl',
	// 		templateUrl: 'resultado.html'
	// 	}).
	otherwise({redirectTo:'/'});
}]);

app.run(['$rootScope', '$location', '$routeParams', function($rootScope, $location, $routeParams){
	// console.log('app.run');
	$rootScope.contato = "http://www.google.com.br";

	//>>> Titulo da Page
	$rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
		if (current.hasOwnProperty('$$route')) {
			if(current.$$route.title){
				$rootScope.title = current.$$route.title;
			}else{
				$rootScope.title = 'SOS Mata Atlântica';
			}
		}
	});
	//<<< Titulo da Page


	//>>> Verifica qual a URL
	$rootScope.isActive = function (path) {
      return $location.path() == path;
    };
	//<<< Verifica qual a URL



	//>>> Includes
	$rootScope.finishLoading = function(include) {
		if(include == 'footer'){
			footer();
		}
	}
	//<<< Includes

}]);




//>>> Home
app.controller('homeController', function($scope){
	$scope.titlePage = "Pagina da Home";
	$scope.loading = true;//<<< add loading page

	//>>> leitura json
	var path = 'json/home/home.json';
	$.post(path)
		.success(function(data){
			$scope.loading = false;//<<< remove loading page
			$scope.home = data;
			$scope.$digest();
		}).error(function(data){
			console.log('erro');
		});
	//<<< leitura json
});
//<<< Home



//>>> Sobre
app.controller('sobreController',function ($scope) {
	$scope.titlePage = 'Sobre Page';
	$scope.loading = true;//<<< add loading page

	//>>> leitura json
	var path = 'json/sobre/sobre.json';
	$.post(path)
		.success(function(data){
			$scope.loading = false;//<<< remove loading page
			$scope.sobre = data;
			$scope.$digest();
		}).error(function(data){
			console.log('erro');
		});
	//<<< leitura json
});
//<<< Sobre



//>>> Como Funciona
app.controller('comoFuncionaController',function ($scope) {
	$scope.titlePage = 'Como Funciona Page';

	//>>> leitura json
	var path = 'json/comoFunciona/comoFunciona.json';
	$.post(path)
		.success(function(data){
			$scope.loading = false;//<<< remove loading page
			$scope.comoFunciona = data;
			$scope.$digest();
		}).error(function(data){
			console.log('erro');
		});
	//<<< leitura json
});
//<<< Como Funciona



//>>> Termo de Uso
app.controller('termoDeUsoController',function ($scope) {
	$scope.titlePage = 'Termo de uso Page';

	//>>> leitura json
	var path = 'json/termoDeUso/termoDeUso.json';
	$.post(path)
		.success(function(data){
			$scope.loading = false;//<<< remove loading page
			$scope.termoDeUso = data;
			$scope.$digest();
		}).error(function(data){
			console.log('erro');
		});
	//<<< leitura json
});
//<<< Termo de Uso



//>>> Resultado
app.controller("IbgeCtrl",function ($scope, $routeParams, $window, $http) {
	$scope.complete = false;

	if ($routeParams) {
		var uf 			= $routeParams.ufId;
		var municipio 	= $routeParams.municipioId;

        console.log('uf: '+ uf);
        console.log('municipio: '+ municipio);

		// $http.get('../js/ibge/'+ uf +'.json').
		// 	success(function(data, status, headers, config) {
		// 		// this callback will be called asynchronously
		// 		// when the response is available
		// 			data.forEach(function(item) {
		//
		// 				for (mun in item) {
		// 					// console.log(tratarTexto(mun) +' === '+ tratarTexto(municipio));
		//
		// 					if (tratarTexto(mun) === tratarTexto(municipio)) {
		// 						var dados = item[mun];
		// 						// console.log('___achou = '+ tratarTexto(mun));
		//
		// 						$scope.instalado_em 	= 'Instalado em: '+ dados['instalado_em'];
		// 						$scope.area 			= 'Área: '+ dados['area'];
		// 						$scope.bioma 			= 'Bioma: '+ dados['bioma'];
		// 						$scope.populacao		= 'População: '+ dados['populacao'];
		// 						$scope.municipio		= municipio + ' - '+ uf
		//
		// 						$scope.complete = true;
		// 						break;
		// 					}
		// 				}
		//
		//
		// 			});
		//
		// 	}).
		// 	error(function(data, status, headers, config) {
		// 		// called asynchronously if an error occurs
		// 		// or server returns response with an error status.
		//
		// 	});
	}




});
//<<< Resultado

//>>> Mapa
app.controller('mapaController',function ($scope) {
// app.controller('resultadoController', 'uf', 'municipio',function ($scope, $uf, $municipio) {
	console.log(uf);
	console.log(municipio);
	$scope.titlePage = 'mapa Page';
});
//<<< Mapa






/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
//>>> AutoComplete
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
app.controller("AutocompleteCtrl",function ($scope, $window, $location) {
	$scope.result = '';
	$scope.details = '';
	$scope.options = options = {
		types: '(regions)',
		country: 'br'
	}

	$scope.$watch('result', function() {
		if ($scope.result != '') {

		}
	});

	$scope.$watch('details', function() {
		if ($scope.details != '') {
			if ($scope.details) {

				var place = $scope.details;
				var address_components = place.address_components;


				var municipio 	= '';
				var uf			= '';
				var estado		= '';

				address_components.forEach(function(item) {
					if (item.types[0] == "locality") {
						municipio = item.short_name;
					}
					if (item.types[0] == "administrative_area_level_1") {
						uf 		= item.short_name;
						estado	= item.long_name;
					}
					if (item.types[0] == "administrative_area_level_2") {
						municipio = item.short_name;
					}
				});

				/// VALIDACAO
				// municipio = validacao(municipio);
				//////////////////////////////////////

				// console.log('UF: '+ uf +' - Municipio: '+ municipio);
				// console.log('-------------------------------------------');



				if (!municipio) {
					zerarBusca();
					if (estado == ''){
						alert('Escreva o nome do município onde mora.');

					} else {
						alert('Escolha um município em '+ estado);

					}

				} else {
					var url_json = $window.location.origin + $window.location.pathname+'ibge/'+uf+'.json';
					// var url_projeto = $window.location.origin + $window.location.pathname.replace('index.html', '');
					// console.log(uf);
				}

				$location.path('/mapa/'+uf+'/'+municipio);
				console.log(uf);
				console.log(municipio);
					// //>>> leitura json
					// $.post(url_json)
					// 	.success(function(data){
					// 		$scope.loading = false;//<<< remove loading page
					// 		$scope.mapa = data;
					// 		console.log(data);
					// 		$('.descobrir').click(function() {
					// 			console.log('click');
					// 			$location.path('/resultado');
					// 		});
					// 		$scope.$digest();
					// 	}).error(function(data){
					// 		console.log('erro');
					// 	});
					// //<<< leitura json








			}
		}
	});



});



app.controller("IbgeCtrl",function ($scope, $routeParams, $window, $http) {
	$scope.complete = false;

	console.log($routeParams);
	if ($routeParams) {
		var uf 			= $routeParams.ufId;
		var municipio 	= $routeParams.municipioId;




        // console.log('uf: '+ uf);
        // console.log('municipio: '+ municipio);

		$http.get('ibge/'+ uf +'.json').
			success(function(data, status, headers, config) {
				console.log(data);
				// this callback will be called asynchronously
				// when the response is available
					data.forEach(function(item) {
						for (mun in item) {
							// console.log(tratarTexto(mun) +' === '+ tratarTexto(municipio));

							if (tratarTexto(mun) === tratarTexto(municipio)) {
								var dados = item[mun];
								// console.log('___achou = '+ tratarTexto(mun));

								$scope.instalado_em 	= 'Instalado em: '+ dados['instalado_em'];
								$scope.area 			= 'Área: '+ dados['area'];
								$scope.bioma 			= 'Bioma: '+ dados['bioma'];
								$scope.populacao		= 'População: '+ dados['populacao'];
								$scope.municipio		= municipio + ' - '+ uf

								$scope.complete = true;
								break;
							}
						}


					});

			}).
			error(function(data, status, headers, config) {
				// called asynchronously if an error occurs
				// or server returns response with an error status.

			});
	}




});

function validacao(municipio_encontrado) {
	var retorno = municipio_encontrado;

	if (municipio_encontrado.indexOf('Km') > -1 ) {
		retorno = '';
	}

	return retorno
}

function zerarBusca() {
	$(document).ready(function(){
		$('input#Autocomplete').val('');
	});
}
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
//<<< AutoComplete
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////



function footer(){
	$(window).bind("load resize", function () {

	    //**** FOOTER _____________________|||
	    var footer = $(".footer");
	    var pos = footer.position();
	    var height = $(window).height();
	    height = height - pos.top;
	    height = height - footer.height();
	    if (height > 0) {
	        height = height-40;
	        footer.fadeIn('fast');
	        footer.css({
	            'margin-top': height + 'px'
	        });
	    }


	    //**** AUTO COMPLETE GOOGLE _____________________|||
	    ajusteDivAutoCompleteGoogle()
	});

}
