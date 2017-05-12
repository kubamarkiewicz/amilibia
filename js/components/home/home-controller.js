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


    // SUBMIT FORM
    $scope.contactSent = false;
    $scope.submit = function () 
    {
        var formData = new FormData($scope.data);

        formData.append('name', $scope.name != undefined ? $scope.name : '');
        formData.append('company', $scope.company != undefined ? $scope.company : '');
        formData.append('email', $scope.email != undefined ? $scope.email : '');
        formData.append('phone', $scope.phone != undefined ? $scope.phone : '');
        formData.append('message', $scope.message != undefined ? $scope.message : '');
        
        $http({
            method  : 'POST',
            url     : config.api.urls.sendContact,
            data    : formData
        })
        .then(function(response) {
            $scope.contactSent = true;
            $("#my-form button[type=submit]").button('reset').attr('disabled', false);
        });
         
        // block button 
        $("#my-form button[type=submit]").button('loading').attr('disabled', true);

    }

});