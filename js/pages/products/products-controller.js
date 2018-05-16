app.controller('ProductsController', function($scope, $rootScope, $http, $routeParams, config, $timeout, $location, $anchorScroll) { 

    $('body > header').removeClass('home');

    $scope.productsData = null;
    
    $scope.loadProductsData = function()
    {
        $http({
            method  : 'GET',
            url     : config.api.urls.products,
            params  : {
                'lang': $rootScope.lang
            }
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

            $('section#productos .products article .gallery').slick({
                arrows: false,
                infinite: true,
                speed: 700,
                autoplay: true,
                slidesToShow: 1,
                adaptiveHeight: true,
                pauseOnHover: false
            });
            
        });
    }

});