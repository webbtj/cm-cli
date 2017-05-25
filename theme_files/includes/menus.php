<?php

//http://wordpress.stackexchange.com/questions/170033/convert-output-of-nav-menu-items-into-a-tree-like-multidimensional-array
function get_nav_tree($location){
    $theme_locations = get_nav_menu_locations();
    $menu_id = $theme_locations[$location];
    $items = wp_get_nav_menu_items( $menu_id );
    return  $items ? buildTree( $items, 0 ) : null;
}

function buildTree( array &$elements, $parent = 0 ){
    $branch = array();
    foreach ( $elements as &$element )
    {
        if ( $element->menu_item_parent == $parent )
        {
            $children = buildTree( $elements, $element->ID );
            if ( $children )
                $element->children = $children;

            $branch[$element->ID] = $element;
            unset( $element );
        }
    }
    return $branch;
}

function cm_load_menus(&$wp_smarty){
    //--Load Menus
}

function cm_assign_menus(&$wp_smarty){
    //--Assign Menus
}

//--Register Menus
