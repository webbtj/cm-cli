<?php
// Clean up the WP Admin Backend for user site_admin
add_action('admin_menu', 'cleanup_admin_menu', 9999);
function cleanup_admin_menu(){
    if(!current_user_can('administrator')){
        global $menu;
        foreach($menu as $k=>$v){
            if($v[0] == 'Appearance'){
                $menu[$k][0] = 'Menus';
                $menu[$k][2] = 'nav-menus.php';
            }
        }
        remove_menu_page( 'edit-comments.php' );
        remove_menu_page( 'tools.php' );
        // remove_menu_page( 'edit.php' );
        remove_menu_page( 'options-general.php' );
        remove_menu_page( 'edit.php?post_type=acf' );
        remove_menu_page( 'edit.php?post_type=acf-field-group' );

        remove_menu_page( 'w3tc_dashboard' );
        remove_menu_page( 'sucuriscan' );
        remove_menu_page( 'itsec' );

        remove_submenu_page('sitepress-multilingual-cms/menu/languages.php', 'wpml-translation-management/menu/main.php');
        remove_submenu_page('sitepress-multilingual-cms/menu/languages.php', 'sitepress-multilingual-cms/menu/menu-sync/menus-sync.php' );
        remove_submenu_page('sitepress-multilingual-cms/menu/languages.php', 'sitepress-multilingual-cms/menu/languages.php' );
        remove_submenu_page('sitepress-multilingual-cms/menu/languages.php', 'sitepress-multilingual-cms/menu/languages.php' );
        remove_submenu_page('sitepress-multilingual-cms/menu/languages.php', 'sitepress-multilingual-cms/menu/theme-localization.php' );
        remove_submenu_page('sitepress-multilingual-cms/menu/languages.php', 'sitepress-multilingual-cms/menu/support.php' );
        remove_submenu_page('sitepress-multilingual-cms/menu/languages.php', 'wpml-translation-management/menu/translations-queue.php' );
        remove_submenu_page('sitepress-multilingual-cms/menu/languages.php', 'wpml-package-management' );
        remove_submenu_page('sitepress-multilingual-cms/menu/languages.php', 'sitepress-multilingual-cms/menu/taxonomy-translation.php' );

        return $menu;
    }
}
// Clean up the WP Admin Bar for user site_admin
add_action('wp_before_admin_bar_render', 'modify_admin_bar', 9999);
function modify_admin_bar(){
    if(!current_user_can('administrator')){
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
        $wp_admin_bar->remove_menu('comments');
        $wp_admin_bar->remove_menu('new-post');
        $wp_admin_bar->remove_menu('new-content');
        $wp_admin_bar->remove_menu('archive');
        $wp_admin_bar->remove_menu('itsec_admin_bar_menu');
        $wp_admin_bar->remove_menu('w3tc');
        $wp_admin_bar->remove_menu('gform-forms');
    }
}

// Clean up extra roles
if (!current_user_can('administrator')) {
    add_filter('editable_roles', 'exclude_role');
    function exclude_role($roles){
        unset($roles['administrator']);
        unset($roles['editor']);
        unset($roles['contributor']);
        unset($roles['author']);
        unset($roles['subscriber']);
        return $roles;
    }
}

function clean_up_dashboard_widgets() {
    global $wp_meta_boxes;
    $activity = null;
    $forms = null;
    $analytics = null;
    if(isset($wp_meta_boxes['dashboard'])){
        foreach($wp_meta_boxes['dashboard'] as $location => $types){
            foreach($types as $type => $widgets){
                foreach($widgets as $key => $widget){
                    switch($key){
                        case 'dashboard_activity':
                            $activity = $widget;
                            break;
                        case 'rg_forms_dashboard':
                            $forms = $widget;
                            break;
                        case 'gadwp-widget':
                            $analytics = $widget;
                            break;
                    }
                }
            }
        }
        $wp_meta_boxes['dashboard'] = array(
            'normal' => array(
                'core' => array()
            ),
            'side' => array(
                'core' => array()
            ),
        );

        if($activity){
            $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] = $activity;
        }
        if($forms){
            $wp_meta_boxes['dashboard']['side']['core']['rg_forms_dashboard'] = $forms;
        }
        if($analytics){
            $wp_meta_boxes['dashboard']['side']['core']['gadwp-widget'] = $analytics;
        }
    }
}
add_action( 'wp_dashboard_setup', 'clean_up_dashboard_widgets', 9999 );

add_action('admin_head', 'disable_icl_metabox', 9999);
function disable_icl_metabox() {
    if(!current_user_can('administrator')){
        global $post;
        remove_meta_box('icl_div_config', $post->posttype, 'normal');
    }
}
