
var app = angular.module("myApp", [
    "ngRoute",
    "ngSanitize"
]);

// load configuration from files
app.constant('config', window.config);

// ROUTING ===============================================
app.config(function ($routeProvider, $locationProvider) { 
    
    $routeProvider 

        .when('/', { 
            controller: 'HomeController', 
            templateUrl: 'js/components/home/index.html' 
        })     
        .when('/products', { 
            controller: 'ProductsController', 
            templateUrl: 'js/components/products/index.html' 
        })   
        .otherwise({ 
            redirectTo: '/' 
        }); 

    // remove hashbang
    $locationProvider.html5Mode(true);
});

// CORS fix
app.config(['$httpProvider', function($httpProvider) {
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
    }
]);

app.run(function($rootScope, $sce, $http, $location, $routeParams, $anchorScroll) {

    // fix for displaying html from model field
    $rootScope.trustAsHtml = function(string) {
        return $sce.trustAsHtml(string);
    };

    // on loading ...
    $rootScope.loading = false; 

    $rootScope.$on('$routeChangeStart', function (event, next, prev) {

        // set body class "page-slug"
        var slug = 'home';
        if (next.originalPath && next.originalPath.substring(1)) {
            slug = next.originalPath.substring(1);
        }
        $("body")
        .removeClass(function (index, className) {
            return (className.match (/(^|\s)page-\S+/g) || []).join(' ');
        })
        .addClass("page-"+slug);

        $rootScope.loading = true;
    });
    
    $rootScope.$on('$routeChangeSuccess', function() {
        $rootScope.loading = false;

        $location.hash($routeParams.scrollTo);
        $anchorScroll();  
    });


    $(function(){

        // open menu
        $('.burger-menu').click(function(){
            $('body > nav').toggleClass('open');
        });
        $('body > nav').click(function(){
            $(this).removeClass('open');
        });

        // smooth scroll to sections
/*        $('a[href*="#"]').on('click',function (e) {

            e.preventDefault();

            var target = this.hash;
            var $target = $(target);

            if (!$target.length) {
                window.location = this.href;
                return;
            }

            $('html, body').stop().animate({
                'scrollTop': $target.offset().top
            }, 900, 'swing', function () {
                window.location.hash = target;
            });
        });*/

    });


    // languages
    $rootScope.locale = localStorage.locale ? localStorage.locale : 'es';
    $rootScope.setLocale = function(locale)
    {
        localStorage.locale = locale;
        location.reload();
    }



    // load pages content
    $rootScope.pagesData = [];
    
    $rootScope.loadPagesData = function()
    {
        $http({
            method  : 'GET',
            url     : config.api.urls.getPages + '/' + $rootScope.locale + '/pages'
        })
        .then(function(response) {
            $rootScope.pagesData = response.data;
        });
    }
    $rootScope.loadPagesData();

});



    



