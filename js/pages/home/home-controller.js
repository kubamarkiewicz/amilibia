app.controller('HomeController', function($scope, $rootScope, $http, $routeParams, config, $timeout) {  

    $('body > header').addClass('home');

	$(function(){

        // top image parallax effect
        $(window).scroll(function() {
            $('section#top').css('transform', 'translateY('+ ($(window).scrollTop() / 2) + 'px)');
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

    var myFlipster;

    $scope.onWorksRendered = function() 
    {
        $timeout(function(){

            // works cover flow slider
            myFlipster = $('section#works .works').flipster({
                itemContainer: '.wrap',
                itemSelector: '.item',
                buttons: true,
                start: 3,
                scrollwheel: false,
                loop: true,
                onItemSwitch: $scope.onFlipsterItemSwitch
            });

            $("section#works .works .item img").click(function(){
                $scope.updateModalImage($(this));
            });

            $('#worksModal .prev').click(function(){
                myFlipster.flipster('prev');
            });

            $('#worksModal .next').click(function(){
                myFlipster.flipster('next');
            });

            $('#worksModal .modal-body .gallery img').click(function(){
            });

        });
    }

    $scope.updateModalImage = function(image) {
        $('#worksModal .modal-header .title').html(image.data('title'));
        $('#worksModal .modal-body .image').css('background-image', 'url('+image.data('path')+')');
        $('#worksModal .modal-body .gallery').html($('.works img[data-title="' + image.data('title') + '"]').clone().removeAttr('data-toggle').click($scope.onGalleryImageClick));
    }

    $scope.onFlipsterItemSwitch = function(currentItem, previousItem) {
        $scope.updateModalImage($(currentItem).find('img'));
    }

    $scope.onGalleryImageClick = function(){
        var path = $(this).data('path');
        var target = $('section#works .works .item img[data-path="' + path + '"').parent().parent();
        myFlipster.flipster('jump', target);
    }



    // SUBMIT FORM
    $scope.contactSent = false;
    $scope.submit = function () 
    {
        var data = {};
        data.name        = $scope.name != undefined ? $scope.name : '';
        data.company     = $scope.company != undefined ? $scope.company : '';
        data.email       = $scope.email != undefined ? $scope.email : '';
        data.phone       = $scope.phone != undefined ? $scope.phone : '';
        data.message     = $scope.message != undefined ? $scope.message : '';
        
        $http({
            method  : 'POST',
            url     : config.api.urls.sendContact,
            data    : $.param(data),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function(response) {
            $scope.contactSent = true;
            // reset form
            $("#my-form .form-control").val("");
            $("#my-form button[type=submit]").button('reset').attr('disabled', false);
        });
         
        // block button 
        $("#my-form button[type=submit]").button('loading').attr('disabled', true);

    }


    // switch menu class
    var windowHeight = $(window).height() - 50;
    $(window).scroll(function (event) {
        $('body.page-home > header').toggleClass('home', $(window).scrollTop() < windowHeight);
    });


});