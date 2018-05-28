app.controller('ProductsController', function($scope, $rootScope, $http, $routeParams, config, $timeout, $location, $anchorScroll) { 

    $('body > header').removeClass('home');
    

    if (!$rootScope.productsData) {
        $rootScope.loadProductsData();
    }


    $scope.onProductsRendered = function() 
    {
        $timeout(function(){
            $location.hash($routeParams.scrollTo);
            $anchorScroll();  

            $('section#productos .products article .gallery').slick({
                arrows: false,
                infinite: true,
                autoplay: true,
                slidesToShow: 1,
                pauseOnHover: false,
                centerMode: true,
                variableWidth: true
            });
            
        });
    }

});