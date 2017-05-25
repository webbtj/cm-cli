<?php

function do_translations(&$smarty){
    $translations = array(
        'All'                           => _x('All',                            'Theme', 'CFNU'),
        'Back'                          => _x('Back',                           'Theme', 'CFNU'),
        'Copyright'                     => _x('Copyright',                      'Theme', 'CFNU'),
        'Download_Low_Res'              => _x('Download Low-Res',               'Theme', 'CFNU'),
        'Download_Hi_Res'               => _x('Download Hi-Res',                'Theme', 'CFNU'),
        'Filter_by_Month'               => _x('Filter by Month',                'Theme', 'CFNU'),
        'Filter_by_Tag'                 => _x('Filter by Tag',                  'Theme', 'CFNU'),
        'Filter_by_Year'                => _x('Filter by Year',                 'Theme', 'CFNU'),
        'Go_to_the_CFNU_Landing_Page'   => _x('Go to the CFNU Landing Page',    'Theme', 'CFNU'),
        'Load_More_Posts'               => _x('Load More Posts',                'Theme', 'CFNU'),
        'logo_horizontal_white_png'     => _x('logo_horizontal_white.png',      'Theme', 'CFNU'),
        'logo_horizontal_png'           => _x('logo_horizontal.png',            'Theme', 'CFNU'),
        'More'                          => _x('More',                           'Theme', 'CFNU'),
        'Read_More'                     => _x('Read More',                      'Theme', 'CFNU'),
        'Search'                        => _x('Search',                         'Theme', 'CFNU'),
        'The_CFNU_Logo'                 => _x('The CFNU Logo',                  'Theme', 'CFNU'),
        'Tweets_by'                     => _x('Tweets by',                      'Theme', 'CFNU'),
        'View_All'                      => _x('View All',                       'Theme', 'CFNU'),
    );

    $smarty->assign('t', $translations);
}

function translate_date($date){
    $date = str_ireplace('January', __('January', 'CFNU'), $date);
    $date = str_ireplace('February', __('February', 'CFNU'), $date);
    $date = str_ireplace('March', __('March', 'CFNU'), $date);
    $date = str_ireplace('April', __('April', 'CFNU'), $date);
    $date = str_ireplace('May', __('May', 'CFNU'), $date);
    $date = str_ireplace('June', __('June', 'CFNU'), $date);
    $date = str_ireplace('July', __('July', 'CFNU'), $date);
    $date = str_ireplace('August', __('August', 'CFNU'), $date);
    $date = str_ireplace('September', __('September', 'CFNU'), $date);
    $date = str_ireplace('October', __('October', 'CFNU'), $date);
    $date = str_ireplace('November', __('November', 'CFNU'), $date);
    $date = str_ireplace('December', __('December', 'CFNU'), $date);

    $date = str_ireplace('Sunday', __('Sunday', 'CFNU'), $date);
    $date = str_ireplace('Monday', __('Monday', 'CFNU'), $date);
    $date = str_ireplace('Tuesday', __('Tuesday', 'CFNU'), $date);
    $date = str_ireplace('Wednesday', __('Wednesday', 'CFNU'), $date);
    $date = str_ireplace('Thursday', __('Thursday', 'CFNU'), $date);
    $date = str_ireplace('Friday', __('Friday', 'CFNU'), $date);
    $date = str_ireplace('Saturday', __('Saturday', 'CFNU'), $date);

    return $date;
}
