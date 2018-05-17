
var app = angular.module("myApp", [
    "ngRoute",
    "ngSanitize",
    'pascalprecht.translate'
]);

// load configuration from files
app.constant('config', window.config);


// translations

app.config(['$translateProvider', function ($translateProvider) {

    // choose language form local storage or default
    if (!window.localStorage.locale) {
        window.localStorage.locale = config.defaultLanguage;
    }
    $translateProvider.preferredLanguage(window.localStorage.locale);

    $translateProvider.useUrlLoader(config.api.urls.translations);
    $translateProvider.useSanitizeValueStrategy(null);
    // tell angular-translate to use your custom handler
    $translateProvider.useMissingTranslationHandler('missingTranslationHandlerFactory');


}]);

// define missing Translation Handler
app.factory('missingTranslationHandlerFactory', function () {

    var missingTranslations = {
        codes : [],
        translations : [],
        types : [],
        parameters : []
    };

    return function (translationId) {

        // prevent multiple calls
        var index = missingTranslations.codes.indexOf(translationId);
        if (index != -1) {
            return missingTranslations.translations[index];
        }

        // call API: send all missing translations at once
        if (!missingTranslations.codes.length) {
            setTimeout(function(){ 
                $.post({
                    url     : config.api.urls.translations,
                    data    : {
                        codes : missingTranslations.codes,
                        types : missingTranslations.types,
                        translations : missingTranslations.translations,
                        parameters : missingTranslations.parameters
                    }
                });
            }, 1000);
        }

        // use last element from translationId as default translation
        var translation = translationId.substr(translationId.lastIndexOf(".") + 1);
        var type;
        var parameters = {};

        // find html element
        var element = $("[translate='" + translationId + "'], [translate-cloak='" + translationId + "'], [translate-attr-src='" + translationId + "']");
        if (element) {
            if (element.html()) {
                translation = element.html();
            }
            type = element.attr('translate-type');
            switch (type) {
                case 'image-mediafinder':
                    parameters.width = element.attr('translate-width');
                    parameters.height = element.attr('translate-height');
                    parameters.mode = element.attr('translate-mode');
                    translation = element.attr('src');
                    break;
            }
        }

        // add missing translation to the table         
        missingTranslations.codes.push(translationId);
        missingTranslations.translations.push(translation);
        missingTranslations.types.push(type);
        missingTranslations.parameters.push(parameters);
        
        return translation;
    };

});

// ROUTING ===============================================
app.config(function ($routeProvider, $locationProvider) { 
    
    $routeProvider 

        .when('/', { 
            controller: 'HomeController', 
            templateUrl: 'js/pages/home/index.html',
            reloadOnSearch: false 
        })     
        .when('/products', { 
            controller: 'ProductsController', 
            templateUrl: 'js/pages/products/index.html' 
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

app.run(function($rootScope, $sce, $http, $location, $anchorScroll, $translate, $window, $route, $routeParams) {


    $rootScope.homeSlug = 'home';

    $("body").removeClass('loading');

    $rootScope.$on('$routeChangeStart', function (event, next, prev) 
    {
        // set body class as "prev-page-slug"
        $("body")
        .removeClass(function (index, className) {
            return (className.match (/(^|\s)prev-page-\S+/g) || []).join(' ');
        })
        .addClass("prev-page-"+$rootScope.pageSlug);

        // find page slug
        delete $rootScope.pageSlug;
        if (typeof next.originalPath !== undefined && next.originalPath && next.originalPath.length > 1) {
            $rootScope.pageSlug = next.originalPath.substring(1);
            // substring until first slash
            if ($rootScope.pageSlug.indexOf('/') != -1) {
                $rootScope.pageSlug = $rootScope.pageSlug.substr(0, $rootScope.pageSlug.indexOf('/'));
            }
        }
        if ($rootScope.pageSlug == undefined) {
            $rootScope.pageSlug = $rootScope.homeSlug;
        }

        // set body class as "page-slug"
        $("body")
        .removeClass(function (index, className) {
            return (className.match (/(^|\s)page-\S+/g) || []).join(' ');
        })
        .addClass("page-"+$rootScope.pageSlug);

        $rootScope.setMetadata(); 
    });

    // scroll to hash element
    $rootScope.$on('$routeChangeSuccess', function() {
        $rootScope.loading = false;

        // $location.hash($routeParams.scrollTo);
        // $anchorScroll();  
    });


    // fix for displaying html from model field
    $rootScope.trustAsHtml = function(string) {
        return $sce.trustAsHtml(string);
    };

    



    $(function(){

        // open menu
        $('.burger-menu').click(function(){
            $('body > header nav').toggleClass('open');
        });
        $('body > header nav').click(function(){
            $(this).removeClass('open');
        });

    });



    // load pages data
    $rootScope.pagesData = [];
    $rootScope.loadPagesData = function()
    {
        $http({
            method  : 'GET',
            url     : config.api.urls.pages,
            params  : {
                'lang': $rootScope.lang
            }
        })
        .then(function(response) {
            $rootScope.pagesData = response.data;
            $rootScope.setMetadata();
        });
    }
    $rootScope.loadPagesData();



    // set metadata
    $rootScope.setMetadata = function()
    {
        var page = $rootScope.pagesData[$rootScope.pageSlug];

        if (page) {
            document.title = page.meta_title;
            document.querySelector('meta[name=description]').setAttribute('content', page.meta_description);
        }
    }



    // set language
    $rootScope.setLanguage = function(lang)
    {
        // save language in local storage
        $rootScope.lang = window.localStorage.locale = lang;
        // change translations language
        $translate.use(lang);
        // set HTML lang
        $('html').attr('lang', lang);
        // highlight option in menu
        $('.languages a').removeClass('selected');
        $('.languages a[data-language=' + lang + ']').addClass('selected');
    }
    $rootScope.setLanguage(window.localStorage.locale);



    // language menu
    $('.languages a').click(function(){
        $rootScope.setLanguage($(this).data('language'));
        $route.reload();
        $rootScope.setMetadata();
    });



    // switch menu class
    var windowHeight = $(window).height() - 50;
    $(window).scroll(function (event) {
        $('body.page-home > header').toggleClass('home', $(window).scrollTop() < windowHeight);
    });




    $rootScope.loadProductsData = function()
    {
        $http({
            method  : 'GET',
            url     : config.api.urls.products,
            params  : {
                'lang': $rootScope.lang
            }
        })
        .then(function(response) {
            $rootScope.productsData = response.data;
        });
    }
    




});



    



