<?php

function cm_assign_translations(&$smarty){
    $translations = array(
        'All'                           => _x('All',                            'Theme', '[[theme-title]]'),
        'Back'                          => _x('Back',                           'Theme', '[[theme-title]]'),
        'Copyright'                     => _x('Copyright',                      'Theme', '[[theme-title]]'),
        'Filter_by_Month'               => _x('Filter by Month',                'Theme', '[[theme-title]]'),
        'Filter_by_Tag'                 => _x('Filter by Tag',                  'Theme', '[[theme-title]]'),
        'Filter_by_Year'                => _x('Filter by Year',                 'Theme', '[[theme-title]]'),
        'Go_to_Landing_Page'            => _x('Go to Landing Page',             'Theme', '[[theme-title]]'),
        'Load_More_Posts'               => _x('Load More Posts',                'Theme', '[[theme-title]]'),
        'Logo_Alt'                      => _x('Site Logo',                      'Theme', '[[theme-title]]'),
        'More'                          => _x('More',                           'Theme', '[[theme-title]]'),
        'No_Results_Found'              => _x('No Results Found',               'Theme', '[[theme-title]]'),
        'Read_More'                     => _x('Read More',                      'Theme', '[[theme-title]]'),
        'Search'                        => _x('Search',                         'Theme', '[[theme-title]]'),
        'View_All'                      => _x('View All',                       'Theme', '[[theme-title]]'),
        //--Taxonomy Filter Translations

    );

    $smarty->assign('t', $translations);
}

function cm_translate_date($date){
    $date = str_ireplace('January', __('January', '[[theme-title]]'), $date);
    $date = str_ireplace('February', __('February', '[[theme-title]]'), $date);
    $date = str_ireplace('March', __('March', '[[theme-title]]'), $date);
    $date = str_ireplace('April', __('April', '[[theme-title]]'), $date);
    $date = str_ireplace('May', __('May', '[[theme-title]]'), $date);
    $date = str_ireplace('June', __('June', '[[theme-title]]'), $date);
    $date = str_ireplace('July', __('July', '[[theme-title]]'), $date);
    $date = str_ireplace('August', __('August', '[[theme-title]]'), $date);
    $date = str_ireplace('September', __('September', '[[theme-title]]'), $date);
    $date = str_ireplace('October', __('October', '[[theme-title]]'), $date);
    $date = str_ireplace('November', __('November', '[[theme-title]]'), $date);
    $date = str_ireplace('December', __('December', '[[theme-title]]'), $date);

    $date = str_ireplace('Sunday', __('Sunday', '[[theme-title]]'), $date);
    $date = str_ireplace('Monday', __('Monday', '[[theme-title]]'), $date);
    $date = str_ireplace('Tuesday', __('Tuesday', '[[theme-title]]'), $date);
    $date = str_ireplace('Wednesday', __('Wednesday', '[[theme-title]]'), $date);
    $date = str_ireplace('Thursday', __('Thursday', '[[theme-title]]'), $date);
    $date = str_ireplace('Friday', __('Friday', '[[theme-title]]'), $date);
    $date = str_ireplace('Saturday', __('Saturday', '[[theme-title]]'), $date);

    return $date;
}

function cm_assign_languages(&$smarty){
    if(function_exists('icl_get_languages')){
        $languages = icl_get_languages('skip_missing=0');
        $wp_smarty->assign('languages', $languages);
    }
}
