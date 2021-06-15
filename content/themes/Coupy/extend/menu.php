<?php

function couponscms_menu_subnav_item( $subnav = array() ) {
    if( isset( $subnav['subnav'] ) ) {
        echo '<ul class="sub-nav">';
        foreach( $subnav['subnav'] as $link ) {
            echo '<li' . ( !empty( $link['classes'] ) ? ' class="' . implode( ' ', $link['classes'] ) . '"' : '' ) . '><a href="' . $link['url'] . '"' . ( isset( $link['open_type'] ) && in_array( $link['open_type'], array( '_self', '_blank' ) ) ? ' target="' . $link['open_type'] . '"' : '' ) . '>' . ts( $link['name'] ) . ( $link['dropdown'] ? ' <i class="fa fa-angle-right"></i>' : '' ) . '</a>';
            echo couponscms_menu_subnav_item( $link );
            echo '</li>';
        }
        echo '</ul>';
    }
}

function get_site_category_sub_menu() {
    $result = \query\main_custom::get_categories();
    foreach($result as $row) {
        $row->url = "http://htoffers.com/category/restaurants-2.html";
        $row->open_type = "_self";
        $row->type = "category";
        $row->identifier = $row->id;
        $row->selected = false;
        $row->dropdown = false;
        $row->classes = [];
    }
    return $result;
}

function couponscms_menu( $menu_id = '' ) {
    $site_menu = site_menu( $menu_id );
    foreach( $site_menu as $link ) {
        echo '<li' . ( !empty( $link['classes'] ) ? ' class="' . implode( ' ', $link['classes'] ) . '"' : '' ) . '><a href="' . $link['url'] . '"' . ( isset( $link['open_type'] ) && in_array( $link['open_type'], array( '_self', '_blank' ) ) ? ' target="' . $link['open_type'] . '"' : '' ) . '>' . ts( $link['name'] )  . ( $link['dropdown'] ? ' <i class="fa fa-angle-down"></i>' : '' ) . '</a>';
        couponscms_menu_subnav_item( $link );
        echo '</li>';
    }
}

?>