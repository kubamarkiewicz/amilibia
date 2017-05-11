app.controller('HomeController', function($scope, $rootScope, $http, $routeParams, config, $timeout) {  

	$(function(){

        // top image parallax effect
        $(window).scroll(function() {
            $('section#top .background').css('transform', 'translateY('+ ($(window).scrollTop() / 2) + 'px)');
        }); 

	});

    
    $scope.productsData = [];
    
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


    $scope.worksData = null;
    
    $scope.loadWorksData = function()
    {
        $http({
            method  : 'GET',
            url     : config.api.urls.getWorks
        })
        .then(function(response) {
            $scope.worksData = response.data;
        });
    }
    $scope.loadWorksData();

    $scope.onWorksRendered = function() 
    {
        $timeout(function(){
            // works cover flow slider
            $('section#works .works').flipster({
                itemContainer: '.wrap',
                itemSelector: '.item',
                buttons: true,
                start: 0,
                scrollwheel: false
            });
        });
    }

});