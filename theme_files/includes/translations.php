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

function cm_assign_languages(&$smarty){
    if(function_exists('icl_get_languages')){
        $languages = icl_get_languages('skip_missing=0');
        $wp_smarty->assign('languages', $languages);
    }
}
