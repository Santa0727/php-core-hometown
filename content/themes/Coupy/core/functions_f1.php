<?php

/* THEME USE PRODUCTS */
function couponscms_has_products() {
    return true;
}

/* THEME USE LOCAL STORES */
function couponscms_has_local_stores() {
    return true;
}

/* STARS RATING */
function couponscms_rating( $stars = 0, $votes = 0 ) {
    if( empty( $stars ) ) {
        return false;
    }
    return '<div class="rating-star"' . ( !empty( $votes ) ? ' data-tooltip title="' . sprintf( t( 'theme_rating_store', '%s stars rating from %s votes' ), $stars, $votes ) : '' ) . '">' .
    str_repeat( '<i class="fa fa-star"></i>', $stars ) .
    ( $stars < 5 ? str_repeat( '<i class="fa fa-star-o"></i>', ( 5 - $stars ) ) : '' ) . ( !empty( $votes ) ? ' (' . $votes . ')' : '' ) .
    '</div>';
}


/* DATE FORMAT */
function couponscms_dateformat( $date = '', $convert_to_unix = true ) {
    if( $convert_to_unix ) {
        $date = strtotime( $date );
    }

    $format = 'd.m.Y';

    if( ( $to_format = get_theme_option( 'date_format' ) ) && !empty( $to_format ) ) {
        $format = $to_format;
    }

    return date( $format, $date );
}

/* DISCOUNT IN PERCENTS */
function couponscms_discount( $old_price, $sale ) {
    if( empty( $old_price ) || empty( $sale ) ) {
        return false;
    }
    return (int) ( 100 - ( $sale / $old_price ) * 100 );
}

/* THEME LANGUAGES */
function couponscms_site_languages() {
    if( (boolean) option( 'allow_select_lang' ) && ( get_theme_option( 'site_multilang' ) ) ) {
        $markup = '';
        $markup .= '<ul class="inline-ul-list site-languages">';
        foreach( site_languages() as $id => $lang ) {
            $markup .= '<li data-tooltip title="' . esc_html( $lang['name'] ) . '" data-placement="bottom"><a href="' . get_update( array( 'set_language' => $id ), get_remove( array( 'cid', 'pid' ) ) ) . '"><img src="' . esc_html( $lang['image'] ) . '" alt="" /></a></li>';
        }
        $markup .= '</ul>';

        return $markup;
    }
    return false;
}

/* VIEW CODE FOR A STORE */
function couponscms_view_store_coupons( $store_id = 0 ) {
    if( isset( $_SESSION['couponscms_rc'] ) && in_array( $store_id, $_SESSION['couponscms_rc'] ) ) {
        return true;
    }
    return false;
}

/* SEARCH FORM MARKUP */
function couponscms_search_form( $extra_class = '' ) {
    echo '<div class="search-container' . ( !empty( $extra_class ) ? ' ' . $extra_class : '' ) . '">
        <div class="container">
            <div class="row sc-title">
                <div class="col-md-7">';
                    $search_title = get_theme_option( 'search_title' );
                    echo '<h2>' . ( !empty( $search_title ) ? $search_title : t( 'theme_search_title', 'Search for big <span>discounts</span> in your favorite stores.' ) ) . '</h2>
                </div>
            </div>
            <div class="row sc-form">
                <form action="' . site_url() . '" autocomplete="off" method="GET">
                    <div class="col-md-7">
                        <div class="search-input">
                            <i class="fa fa-search"></i>
                            <input type="text" name="s" placeholder="' . t( 'theme_type_and_search', 'Type and press enter' ) . '" />
                        </div>
                    </div>
                    <div class="col-md-2 sc-select dnone">
                        <div class="category-select">
                        <a href="#"><span>' . t( 'coupons', 'Coupons' ) . '</span> <i class="fa fa-angle-down"></i></a>
                        <input type="hidden" name="type" value="coupons" />
                            <ul>
                                <li><a href="#" data-attr="coupons">' . t( 'coupons', 'Coupons' ) . '</a></li>';
                                if( couponscms_has_products() ) {
                                    echo '<li><a href="#" data-attr="products">' . t( 'products', 'Products' ) . '</a></li>';
                                }
                                echo '<li><a href="#" data-attr="stores">' . t( 'stores', 'Stores' ) . '</a></li>';
                                if( couponscms_has_local_stores() ) {
                                    echo '<li><a href="#" data-attr="locations">' . t( 'theme_stores_by_location', 'Stores By Location' ) . '</a></li>';
                                }
                            echo '</ul>
                        </div>
                    </div>
                    <div class="col-md-3 sc-select dnone">
                        <div class="category-select">
                        <a href="#"><span>' . t( 'theme_any_category', 'Any Category' ) . '</span> <i class="fa fa-angle-down"></i></a>
                        <input type="hidden" name="category" value="" />
                            <ul>';
                            foreach( all_grouped_categories() as $category ) {
                                echo '<li><a href="' . $category['info']->link . '" data-attr="' . $category['info']->ID . '">' . $category['info']->name . '</a></li>';
                                if( isset( $category['subcats'] ) ) {
                                    foreach( $category['subcats'] as $subcategory ) {
                                        echo '<li><a href="' . $subcategory->link . '" data-attr="' . $subcategory->ID . '">- ' . $subcategory->name . '</a></li>';
                                    }
                                }
                            }
                            echo '</ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>';
}

/* INDEX ITEMS */
function couponscms_home_items() {
    $items_on_home = value_with_filter( 'index_items', get_theme_option( 'items_on_index' ) );

    $all_items = items_custom( array( 'show' => 'all', 'orderby' => 'date', 'max' => 10 ) );
    $section_count = 0;
    $markup = '';
    $is_exist = false;
    
    $markup .= '<section class="items-list"><div class="container"><h2>Popular Stores</h2><div class="row">';
    foreach($all_items as $row) {
        if(!$row->is_popular) continue;
        $is_exist = true;
        $markup .= couponscms_coupon_item( $row );
    }
    $markup .= '</div></div></section>';

    if($is_exist) $section_count++;

    $is_exist = false;
    $markup .= '<section class="items-list bg-gray"><div class="container"><h2>Newest Coupons</h2><div class="row">';
    function cmp($first, $second) {
        return ($first->date > $first->date) ? -1 : 1;
    }
    usort($all_items, "cmp");

    foreach($all_items as $row) {
        $is_exist = true;
        $markup .= couponscms_coupon_item( $row );
    }
    $markup .= '</div></div></section>';

    $markup .= '<section class="items-list"><div class="container"><h2>Best Deals &amp; Coupons</h2><div class="row">';
    foreach($all_items as $row) {
        if(!$row->is_exclusive) continue;
        $is_exist = true;
        $markup .= couponscms_coupon_item( $row );
    }
    $markup .= '</div></div></section>';

    return $markup;
}