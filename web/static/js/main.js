require.config({
    baseUrl : '/static/js',
    //nodeIdCompat: true,
    shim : {
        underscore : {
            exports : '_'
        },
        bootstrap : {
            deps : [ 'jquery'],
            exports: 'Bootstrap'
        },
        moment : {
            exports: 'moment'
        },
        bootstrap_datepicker : {
            deps: ['moment']
        }
    },
    paths: {
        // vendor js files for requireJS
        'jquery'	            : '../node_modules/jquery/dist/jquery',
        'bootstrap'             : '../node_modules/bootstrap/dist/js/bootstrap.bundle',
        'slick'				    : '../node_modules/slick-carousel/slick/slick',
        'moment'                : '../node_modules/moment/min/moment-with-locales',
        'js_cookie'             : '../node_modules/js-cookie/src/js.cookie',

        // our libs
        'cms_uikit'				: 'libs/cms_uikit',
        'cms_flip'		     	: 'libs/cms_flip',
        'cms_authentication'	: 'libs/cms_authentication',
        'cms_member'	        : 'libs/cms_member',
        'cms_ranking'	        : 'libs/cms_ranking',
        'cms_tournament_wrapper': 'libs/cms_tournament_wrapper',
        'cms_tournament'        : 'libs/cms_tournament',
        'cms_frontpage'         : 'libs/cms_frontpage',
        'cms_cookieagreement'   : 'libs/cms_cookieagreement',
        'cms_news'              : 'libs/cms_news',
        'cms_tracking_manager'  : 'libs/cms_tracking_manager',
        'cms_proclub_about'     : 'libs/cms_proclub_about',
        'cms_proclub_standings' : 'libs/cms_proclub_standings',
        'cms_proclub_join'      : 'libs/cms_proclub_join',
        'cms_proclub_login'     : 'libs/cms_proclub_login',
        'cms_proclub_slider'    : 'libs/cms_proclub_slider',
        'cms_proclub_players'   : 'libs/cms_proclub_players',
        'cms_proclub_rules'     : 'libs/cms_proclub_rules',
        'cms_datetimepicker'    : 'libs/cms_datetimepicker',

        //services
        'cms_assetservice'      : 'services/cms_assetservice',
        'cms_dialogservice'     : 'services/cms_dialogservice',
        'cms_useragentservice'  : 'services/cms_useragentservice',
        'cms_amamediaservice'   : 'services/cms_amamediaservice',
        'cms_linkservice'       : 'services/cms_linkservice',

        'cms_imagelib'	        : 'libs/cms_imagelib',

        'ngl'	: 'ngl'
    }
});

