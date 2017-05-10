app.controller('ProductsController', function($scope, $rootScope, $http, $routeParams, config) { 

    $scope.productsData = [];
    
    $scope.loadProductsData = function()
    {
        $http({
            method  : 'GET',
            url     : config.api.urls.getProductsData
        })
        .then(function(response) {
            $scope.productsData = response.data;
        });
    }
    // $scope.loadProductsData();

});