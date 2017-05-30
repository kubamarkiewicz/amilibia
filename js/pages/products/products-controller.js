app.controller('ProductsController', function($scope, $rootScope, $http, $routeParams, config, $timeout, $location, $anchorScroll) { 

    $scope.productsData = null;
    
    $scope.loadProductsData = function()
    {
        $http({
            method  : 'GET',
            url     : config.api.urls.getProducts + '/' + $rootScope.locale + '/products'
        })
        .then(function(response) {
            $scope.productsData = response.data;
        });
    }
    $scope.loadProductsData();

    $scope.onProductsRendered = function() 
    {
        $timeout(function(){
            $location.hash($routeParams.scrollTo);
            $anchorScroll();  
        });
    }

});