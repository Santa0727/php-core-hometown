<?php

/* THERE OPTIONS */
if( !function_exists( 'theme_options' ) ) {
    function theme_options() {
        // id => options
        $options = array();
        $options['search_title']    = array( 'type' => 'text',      'title' => t( 'theme_options_search_title', 'Search Box Title' ),   'placeholder' => 'Search for big discounts in your favorite stores.' );
        $options['search_image']    = array( 'type' => 'image',     'title' => t( 'theme_options_search_image', 'Search Box Image' ),   'cat_id' => 'to', 'info' => t( 'theme_options_search_image_info', 'Background image used for search box.' ) );
        $options['hero_image']      = array( 'type' => 'image',      'title' => t( 'theme_options_inner_hero_image', 'Hero Section Image' ), 'cat_id' => 'to', 'info' => t( 'theme_options_inner_hero_image_info', 'Background image used for hero section on inner pages.' ) );
        $options['contact_tel']     = array( 'type' => 'text',      'title' => t( 'theme_options_contact_phone', 'Contact (tel)' ),     'placeholder' => '(123) 123-1234' );
        $options['contact_email']   = array( 'type' => 'text',      'title' => t( 'theme_options_contact_email', 'Contact (email)' ),   'placeholder' => 'contact@example.com' );
        $options['date_format']     = array( 'type' => 'text',      'title' => t( 'theme_options_date_format', 'Date Format' ),         'default' => 'd.m.Y', 'info' => t( 'theme_options_date_format_info', 'Default date format is: d.m.Y' ) );
        $options['map_zoom']        = array( 'type' => 'number',    'title' => t( 'theme_options_map_zoom', 'Map Zoom' ),               'default' => 16 );
        $options['map_marker_icon'] = array( 'type' => 'text',      'title' => t( 'theme_options_map_marker_icon', 'Map Marker Icon' ), 'default' => THEME_LOCATION . '/assets/img/pin.png' );
        $options['site_multilang']  = array( 'type' => 'checkbox',  'title' => t( 'theme_options_multilang', 'Multi Language' ),        'label' => t( 'theme_options_multilang_label', 'Display language switcher with flags' ) );
        $options['items_on_index']  = array( 'type' => 'text',      'title' => t( 'theme_options_index_items', 'Items On Index Page' ), 'multi' => true, 'sortable' => true, 'info' => t( 'theme_options_index_items_info', 'Display types: coupons, products or stores. Accept inline options separated with pipes, format: type|limit|where|order by. Example: coupons|15|active,printable|date' ) );
        $options['theme_colors']    = array( 'type' => 'select',    'title' => t( 'theme_options_theme_colors', 'Theme Colors' ),       'options' => array(
                                                                                                                                                            'default'   => t( 'theme_options_default_label','Default' ),
                                                                                                                                                            'green'     => t( 'theme_options_green_label',  'Green' ),
                                                                                                                                                            'claret'    => t( 'theme_options_claret_label', 'Claret' ),
                                                                                                                                                            'gray'      => t( 'theme_options_gray_label',   'Gray' ),
                                                                                                                                                            'blue'      => t( 'theme_options_blue_label',   'Blue' ),
                                                                                                                                                            'gold'      => t( 'theme_options_gold_label',   'Gold' ),
                                                                                                                                                            'dusty'     => t( 'theme_options_dusty_label',  'Dusty' ),
                                                                                                                                                            'sky'       => t( 'theme_options_sky_label',    'Sky' ),
                                                                                                                                                            'papaya'    => t( 'theme_options_papaya_label', 'Papaya' ),
                                                                                                                                                            'grape'     => t( 'theme_options_grape_label',  'Grape' ),
                                                                                                                                                            ) );
        $options['coupon_open']     = array( 'type' => 'select',    'title' => t( 'theme_options_theme_open_type', 'Open Coupons In' ), 'options' => array(
                                                                                                                                                            'popup'     => t( 'theme_options_coupon_open_popup','Pop-up' ),
                                                                                                                                                            'single'    => t( 'theme_options_coupon_open_single','Single Page' )
                                                                                                                                                            ) );
        $options['about_us_page']   = array( 'type' => 'text',      'title' => t( 'theme_options_aboutus_page_id', '"About Us" Page ID' ) );
        $options['extra_css']       = array( 'type' => 'textarea',  'title' => t( 'theme_options_extra_css', 'Extra CSS' ) );
        $options['extra_js']        = array( 'type' => 'textarea',  'title' => t( 'theme_options_extra_js', 'Extra JS' ) );

        return $options;
    }
}

/* CUSTOM CATEGORY FOR THEME OPTIONS IN GALLERY */

add( 'filter', 'gallery-categories', function( $cats ) {
    $cats['to'] = t( 'themes_options', 'Theme Options' );
    return $cats;
});