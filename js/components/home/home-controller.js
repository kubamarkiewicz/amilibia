app.controller('HomeController', function($scope, $rootScope, $http, $routeParams, config) {  

	$(function(){

        // top image parallax effect
        $(window).scroll(function() {
            $('section#top .background').css('transform', 'translateY('+ ($(window).scrollTop() / 2) + 'px)');
        }); 


        // works cover flow slider
        $('section#works .works').flipster({
        	itemContainer: '.wrap',
		    itemSelector: '.item',
		    buttons: true,
		    start: 0,
		    scrollwheel: false
        });

	})

});