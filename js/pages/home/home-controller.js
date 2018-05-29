app.controller('HomeController', function($scope, $rootScope, $http, $routeParams, config, $timeout, $anchorScroll) {  


	$(function(){

        // top image parallax effect
        $(window).scroll(function() {
            $('section#top').css('transform', 'translateY('+ ($(window).scrollTop() / 2) + 'px)');
        }); 

	});

    

    if (!$rootScope.productsData) {
        $rootScope.loadProductsData();
    }



    $scope.loadWorksData = function()
    {
        $http({
            method  : 'GET',
            url     : config.api.urls.works,
            params  : {
                'lang': $rootScope.lang
            }
        })
        .then(function(response) {
            $rootScope.worksData = response.data;
        });
    }

    if (!$rootScope.worksData) {
        $scope.loadWorksData();
    }


    var myFlipster;
    var lastTitle;

    $scope.onWorksRendered = function() 
    {
        $timeout(function(){

            // works cover flow slider
            myFlipster = $('section#works .works').flipster({
                itemContainer: '.wrap',
                itemSelector: '.item',
                buttons: true,
                start: Math.ceil($scope.worksData.length / 2) - 1,
                scrollwheel: false,
                loop: true,
                onItemSwitch: $scope.onFlipsterItemSwitch
            });

            $("section#works .works .item img").click(function(){
                $scope.updateModalImage($(this));
                lastTitle = $(this).data('title');
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

        var title = $(currentItem).find('img').data('title');
        var prevTitle = $(currentItem).prev().find('img').data('title');
        var nextTitle = $(currentItem).next().find('img').data('title');

        if (prevTitle === undefined || prevTitle != title) {
            $('#worksModal .prev').hide();
        }
        else {
            $('#worksModal .prev').show();
        }

        if (nextTitle === undefined || nextTitle != title) {
            $('#worksModal .next').hide();
        }
        else {
            $('#worksModal .next').show();
        }
    }

    $scope.onGalleryImageClick = function(){
        var path = $(this).data('path');
        var target = $('section#works .works .item img[data-path="' + path + '"').parent().parent();
        myFlipster.flipster('jump', target);
    }



    // mapa

    $scope.loadLocationsData = function()
    {
        $http({
            method  : 'GET',
            url     : config.api.urls.locations,
            params  : {
                'lang': $rootScope.lang
            }
        })
        .then(function(response) {
            $rootScope.locationsData = response.data;
        });
    }
    if (!$rootScope.locationsData) {
        $scope.loadLocationsData();
    }
    


    $scope.onLocationsRendered = function()
    {
        $('section#location .map .marker .icon').click(function(){
            var marker = $(this).parent();
            marker.toggleClass('open');
            $('section#location .map .marker').not(marker).removeClass('open');
        });
    }




    // SUBMIT FORM
    $scope.submit = function () 
    {
        $http({
            method  : 'POST',
            url     : config.api.urls.contact,
            data  : {
                "name"      : $scope.name,
                "company"   : $scope.company,
                "email"     : $scope.email,
                "phone"     : $scope.phone,
                "message"   : $scope.message
            }
        })
        .then(function(response) {
            if (response.data && response.data === true) {
                $scope.contactSent = true;
                $scope.name = $scope.company = $scope.email = $scope.phone = $scope.message = '';
            }
            $("#my-form button[type=submit]").button('reset').attr('disabled', false);
        });
         
        // block button 
        $("#my-form button[type=submit]").button('loading').attr('disabled', true);

    }


    // switch menu class
    var windowHeight = $(window).height() - 50;
    $('body.page-home > header').toggleClass('home', $(window).scrollTop() < windowHeight);

    
    // scroll to hash
    setTimeout(function(){ 
        if (!$(window).scrollTop()) {
            $anchorScroll();
        }
    },1000);


});