<?php

/* DEFINE CONSTANTS */
define( 'THEME_LOCATION', theme_location() );
define( 'COUPONSCMS_CORE_LOCATION', theme_location2() . '/core' );

/* REQUIRED PARTS AND FUNCTIONS */
require_once 'core/theme_options.php';
require_once 'core/shortcodes.php';
require_once 'core/functions.php';
require_once 'extend/store.php';
require_once 'extend/product.php';
require_once 'extend/coupon.php';
require_once 'extend/review.php';
require_once 'extend/reward.php';
require_once 'extend/plans.php';
require_once 'extend/pagination.php';
require_once 'extend/menu.php';

/* ADD THEME STYLES */
add( 'styles', THEME_LOCATION . '/assets/css/bootstrap.min.css',    array( 'media' => 'all', 'rel' => 'stylesheet' ) );
add( 'styles', THEME_LOCATION . '/assets/css/font-awesome.min.css', array( 'media' => 'all', 'rel' => 'stylesheet' ) );
add( 'styles', THEME_LOCATION . '/style.css',                       array( 'media' => 'all', 'rel' => 'stylesheet' ) );
add( 'styles', THEME_LOCATION . '/assets/css/couponscms.css',       array( 'media' => 'all', 'rel' => 'stylesheet' ) );
add( 'styles', THEME_LOCATION . '/assets/css/framework.css',        array( 'media' => 'all', 'rel' => 'stylesheet' ) );
add( 'styles', THEME_LOCATION . '/assets/css/owl.carousel.min.css', array( 'media' => 'all', 'rel' => 'stylesheet' ) );
add( 'styles', THEME_LOCATION . '/assets/css/responsive.css',       array( 'media' => 'all', 'rel' => 'stylesheet' ) );

switch( get_theme_option( 'theme_colors' ) ) {
    case 'green':   add( 'styles', THEME_LOCATION . '/assets/css/colors/greenStyle.css',    array( 'media' => 'all', 'rel' => 'stylesheet' ) ); break;
    case 'claret':  add( 'styles', THEME_LOCATION . '/assets/css/colors/claretStyle.css',   array( 'media' => 'all', 'rel' => 'stylesheet' ) ); break;
    case 'gray':    add( 'styles', THEME_LOCATION . '/assets/css/colors/grayStyle.css',     array( 'media' => 'all', 'rel' => 'stylesheet' ) ); break;
    case 'blue':    add( 'styles', THEME_LOCATION . '/assets/css/colors/blueStyle.css',     array( 'media' => 'all', 'rel' => 'stylesheet' ) ); break;
    case 'gold':    add( 'styles', THEME_LOCATION . '/assets/css/colors/goldStyle.css',     array( 'media' => 'all', 'rel' => 'stylesheet' ) ); break;
    case 'dusty':   add( 'styles', THEME_LOCATION . '/assets/css/colors/dustyStyle.css',    array( 'media' => 'all', 'rel' => 'stylesheet' ) ); break;
    case 'sky':     add( 'styles', THEME_LOCATION . '/assets/css/colors/skyStyle.css',      array( 'media' => 'all', 'rel' => 'stylesheet' ) ); break;
    case 'papaya':  add( 'styles', THEME_LOCATION . '/assets/css/colors/papayaStyle.css',   array( 'media' => 'all', 'rel' => 'stylesheet' ) ); break;
    case 'grape':   add( 'styles', THEME_LOCATION . '/assets/css/colors/grapeStyle.css',    array( 'media' => 'all', 'rel' => 'stylesheet' ) ); break;
}

add( 'styles', THEME_LOCATION . '/assets/css/modal.css',                                        array( 'media' => 'all', 'rel' => 'stylesheet' ) );
add( 'styles', '//fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900', array( 'rel' => 'stylesheet' ) );

/* ADD THEME SCRIPTS */
add( 'scripts', '//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js' );
add( 'scripts', THEME_LOCATION . '/assets/js/functions.js' );
add( 'scripts', THEME_LOCATION . '/assets/js/ajax.js' );
add( 'scripts', THEME_LOCATION . '/assets/js/bootstrap.min.js' );
add( 'scripts', THEME_LOCATION . '/assets/js/owl.carousel.min.js' );

/* USE OR DON'T USE REWARDS */
function theme_has_rewards() {
    return true;
}

/* LANGUAGES LOCATION */
function theme_languages_location() {
    return 'languages';
}

/* ADD THEME MENU */
add( 'menu', 'main', 'theme_menu' );

/* BUILD SITE'S MENU */
function theme_menu() {
    $links = array();

    $links['home'] = array( 'type' => 'home', 'name' => t( 'theme_nav_home', 'Home' ) );

    $links['categories'] = array( 'name' => t( 'theme_nav_categories', 'Categories' ), 'url' => '#' );

    foreach( \query\main::group_categories( array( 'max' => 0 ) ) as $cat_id => $cat ) {
        $links['categories']['links']['category_' . $cat_id] = array( 'type' => 'category', 'name' => $cat['info']->name, 'url' => $cat['info']->link, 'identifier' => ( !empty( $cat['info']->url_title ) ? $cat['info']->url_title : $cat['info']->ID ) );
        if( isset( $cat['subcats'] ) ) {
            foreach( $cat['subcats'] as $subcat_id => $subcat ) {
                $links['categories']['links']['category_' . $cat_id]['links']['category_' . $subcat_id] = array( 'type' => 'category', 'name' => $subcat->name, 'url' => $subcat->link, 'identifier' => ( !empty( $subcat->url_title ) ? $subcat->url_title : $subcat->ID ) );
            }
        }
    }

    $links['stores'] = array( 'name' => t( 'theme_nav_stores', 'Stores' ), 'url' => tlink( 'stores' ) );
    $links['stores']['links'][] = array( 'name' => t( 'theme_all_stores', 'All Stores' ), 'url' => tlink( 'stores' ) );
    $links['stores']['links'][] = array( 'name' => t( 'theme_top_stores', 'Top Stores' ), 'url' => tlink( 'stores', 'type=top' ) );
    $links['stores']['links'][] = array( 'name' => t( 'theme_most_voted', 'Most Voted' ), 'url' => tlink( 'stores', 'type=most-voted' ) );
    $links['stores']['links'][] = array( 'name' => t( 'theme_popular', 'Popular' ), 'url' => tlink( 'stores', 'type=popular' ) );

    $links['coupons'] = array( 'name' => t( 'theme_nav_coupons', 'Coupons' ), 'url' => '#' );
    $links['coupons']['links'][] = array( 'name' => t( 'theme_coupons_recently_added', 'Recently Added' ), 'url' => tlink( 'tpage/coupons', 'type=recent' ) );
    $links['coupons']['links'][] = array( 'name' => t( 'theme_coupons_expiring_soon', 'Expiring Soon' ), 'url' => tlink( 'tpage/coupons', 'type=expiring' ) );
    $links['coupons']['links'][] = array( 'name' => t( 'theme_coupons_printable', 'Printable' ), 'url' => tlink( 'tpage/coupons', 'type=printable' ) );
    $links['coupons']['links'][] = array( 'name' => t( 'theme_coupons_codes', 'Coupon Codes' ), 'url' => tlink( 'tpage/coupons', 'type=codes' ) );
    $links['coupons']['links'][] = array( 'name' => t( 'theme_coupons_exclusive', 'Exclusive' ), 'url' => tlink( 'tpage/coupons', 'type=exclusive' ) );
    $links['coupons']['links'][] = array( 'name' => t( 'theme_coupons_popular', 'Popular' ), 'url' => tlink( 'tpage/coupons', 'type=popular' ) );
    $links['coupons']['links'][] = array( 'name' => t( 'theme_coupons_verified', 'Verified' ), 'url' => tlink( 'tpage/coupons', 'type=verified' ) );

    if( couponscms_has_products() ) {
        $links['products'] = array( 'name' => t( 'theme_nav_products', 'Products' ), 'url' => '#' );
        $links['products']['links'][] = array( 'name' => t( 'theme_products_recently_added', 'Recently Added' ), 'url' => tlink( 'tpage/products', 'type=recent' ) );
        $links['products']['links'][] = array( 'name' => t( 'theme_products_expiring_soon', 'Expiring Soon' ), 'url' => tlink( 'tpage/products', 'type=expiring' ) );
        $links['products']['links'][] = array( 'name' => t( 'theme_products_popular', 'Popular' ), 'url' => tlink( 'tpage/products', 'type=popular' ) );
    }

    $links[] = array( 'type' => 'custom', 'name' => t( 'theme_nav_submit_coupons', 'Submit Coupons' ), 'url' => tlink( 'tpage/suggest' ), 'class' => 'menu-li-right' );

    return $links;
}

/* PAGE EXTRA FIELDS */
$page_extra_fields = array();
$page_extra_fields['use_hero'] = array( 'type' => 'checkbox', 'title' => t( 'theme_input_hero_section', 'Use Hero Section', true ), 'label' => t( 'theme_input_hero_section_label', 'Check to display the hero section', true ) );
add( 'page-fields', array( 'position' => 3.1, 'fields' => $page_extra_fields ) );

/* COUPON EXTRA FIELDS */
$coupon_extra_fields = array();
$coupon_extra_fields['tiny_name'] = array( 'type' => 'text', 'title' => t( 'theme_coupon_input_tiny_name', 'Tiny Name', true ), 'info' => t( 'theme_coupon_input_tiny_info', 'Short description for this coupon, usually like "20 OFF"', true ) );
add( 'coupon-fields', array( 'position' => 3.2, 'fields' => $coupon_extra_fields ) );

/* PRODUCT EXTRA FIELDS */
$product_extra_fields = array();
$product_extra_fields['tiny_name'] = array( 'type' => 'text', 'title' => t( 'theme_product_input_tiny_name', 'Tiny Name', true ), 'info' => t( 'theme_product_input_tiny_info', 'Short description for this product, usually like "20 OFF"', true ) );
add( 'product-fields', array( 'position' => 3.1, 'fields' => $product_extra_fields ) );

/* APPLY OPTIONS */
if( ( $search_box_bg = get_theme_option( 'search_image' ) ) && !empty( $search_box_bg ) ) {
    if( !filter_var( $search_box_bg, FILTER_VALIDATE_URL ) ) {
        $search_box_gallery = @json_decode( $search_box_bg );
        if( $search_box_gallery ) {
            $search_box_bg = current( $search_box_gallery );
        }
    }
    add( 'inline-style', '.search-container:not(.fixed-popup)::after {background-image:url("' . $search_box_bg . '")}' );
}
if( ( $hero_section_bg = get_theme_option( 'hero_image' ) ) && !empty( $hero_section_bg ) ) {
    if( !filter_var( $hero_section_bg, FILTER_VALIDATE_URL ) ) {
        $hero_section_gallery = @json_decode( $hero_section_bg );
        if( $hero_section_gallery ) {
            $hero_section_bg = $GLOBALS['siteURL'] . current( $hero_section_gallery );
        }
    }
    add( 'inline-style', '.page-intro {background-image:url("' . $hero_section_bg . '")}' );
}

/* ADD EXTRA CSS */
add( 'in-head', add_extra_css() );

function add_extra_css() {
    if( ( $ecss = get_theme_option( 'extra_css' ) ) ) {
        return "<style>\n" . $ecss . "\n</style>";
    }
    return '';
}

/* ADD EXTRA JS */
add( 'in-head', add_extra_js() );

function add_extra_js() {
    if( ( $ejs = get_theme_option( 'extra_js' ) ) ) {
        return "<script>\n" . $ejs . "\n</script>";
    }
    return '';
}