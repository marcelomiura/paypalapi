var storeApp = angular.module('storePayPal', ['ngRoute']);

storeApp.config(function($routeProvider, $httpProvider) {

	$httpProvider.defaults.useXDomain = true;
	$httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
	delete $httpProvider.defaults.headers.common['X-Requested-With'];

	$routeProvider.
		when('/home', {controller: homeController, templateUrl: 'home.html'}).
		when('/produto/:name', {controller: produtoController, templateUrl: 'produto.php'}).
		when('/plans/:name', {controller: plansController, templateUrl: 'plans.php'}).
		when('/information', {controller: informationController, templateUrl: 'information.html'}).
		when('/finaliza', {controller: finalizaController, templateUrl: 'finaliza.php'}).
		when('/createprofile', {controller: profileController, templateUrl: 'createprofile.php'}).
		when('/congratulations', {controller: congratulationsController, templateUrl: 'congratulations.php'}).
		otherwise({redirectTo: '/home'});
});

// variaveis globais
var g_produto = {};
var g_user = {};
var amt = 0;

function homeController ($scope, $http, $location) {
	"use strict";

	var ng = $scope;

	// products
	$http.get("json/produtos.json").success(function(data){

		ng.products = data;

	}).error(function(data){

		alert("Error...");
		console.log(data);
	});

	// signature
	$http.get("json/assinaturas.json").success(function(data){

		ng.signatures = data;

	}).error(function(data){

		alert("Error...");
		console.log(data);
	});

	ng.setProduct = function(product){
		g_produto = product;
	};

}

function produtoController ($scope) {
	"use strict";

	var ng = $scope;

	ng.value = 1;
	ng.product = g_produto;

	ng.setValue = function(){
		amt = ng.value;
	};

}

function plansController ($scope) {
	"use strict";

	var ng = $scope;

	ng.value = 1;
	ng.plan = g_produto;

}

function finalizaController ($scope) {
	"use strict";

	var ng = $scope;

	ng.product = g_produto;
	ng.user = g_user;
	ng.value = amt;

}

function congratulationsController ($scope) {
	"use strict";

	var ng = $scope;

	ng.transID = getURLParameters('transID', window.location.href);

	ng.verificaTransacao = function(){
		console.log(ng.transID)

		if (ng.transID != ""){
			return true;
		}else{
			return false;
		}
	};
}

function profileController ($scope) {
	"use strict";

	var ng = $scope;
}

function informationController ($scope) {
	"use strict";

	var ng = $scope;
	ng.user = {
		name    	 : '',
		adress   	 : '',
		neighborhood : '',
		city  		 : '',
		state  		 : '',
		cep     	 : '',
		email 		 : '',
		phone 		 : ''
	};

	ng.next = function () {
		g_user = ng.user;
	};

	ng.clear = function () {
		ng.user = {
			name    	 : '',
			adress   	 : '',
			neighborhood : '',
			city  		 : '',
			state  		 : '',
			cep     	 : '',
			email 		 : '',
			phone 		 : ''
		};
	};

}

function getURLParameters( param, url ) {
    param = param.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+param+"=([^&#]*)";
    var regex = new RegExp( regexS );
    //se url não for informada, assume a url corrente da página
    if (typeof url == "undefined")
        var results = regex.exec( window.location.href );
    else
        var results = regex.exec( url );

    if( results == null ){
        return "";
    }
    else {
        return results[1];
    }
}