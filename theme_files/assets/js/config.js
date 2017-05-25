requirejs.config({
    baseUrl: '/mockup',
    paths: {
        'Typekit': 'https://use.typekit.net/zsr5cvx',
        'jquery': 'assets/vendor/jquery.min',
        'jquery-easing': '//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min',
        'modernizr': 'assets/vendor/modernizr',
        'matchMedia': 'assets/vendor/matchMedia',
        'slick': 'assets/vendor/slick',
        'app': 'assets/js/app'
    },
    shim: {
        'jquery-easing': ['jquery'],
        'matchMedia': ['jquery'],
        'slick': ['jquery'],
        'app': ['jquery', 'jquery-easing', 'matchMedia', 'slick']
    }
});

define(
    [
        'jquery',
        'jquery-easing',
        'modernizr',
        'matchMedia',
        'slick',
        'app'
    ], function($){

});
