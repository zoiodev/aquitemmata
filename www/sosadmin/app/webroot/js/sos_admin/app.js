var app = angular.module('app',[]);

app.controller('homeController', function ($scope) {
	$scope.titlePage = 'Home';
});
app.controller('contatoController', function ($scope) {
	$scope.titlePage = 'Contato';
});

app.controller('comoFuncionaController', function ($scope) {
	$scope.titlePage = 'Como Funciona';
});

app.controller('termoDeUsoController', function ($scope) {
	$scope.titlePage = 'Termo de Uso';
});

app.controller('sobreController', function ($scope) {
	$scope.titlePage = 'Sobre';
});
