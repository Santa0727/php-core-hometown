<?php

function couponscms_product_item( $item = object, $column_width = 3, $owner_view = false ) {

    $item->is_owner_view = $owner_view;

    $markup = do_action( 'before_product_outside', $item );

    $markup .= '<div class="col-md-' . $column_width . ' col-sm-6" id="product-' . $item->ID . '">';

    $markup .= do_action( 'before_product_inside', $item );

    $markup .= '<div class="product">';

    $markup .= '<div class="img-preview" style="background-image:url(\'' . product_avatar( ( !empty( $item->image ) ? $item->image : '' ) ) . '\');">';

    if( !( $owner_view || $item->is_expired ) ) {
        $markup .= '<div class="heart"><a href="#" data-ajax-call="' . ajax_call_url( "save" ) . '" data-data=\'' . json_encode( array( 'item' => $item->ID, 'type' => 'product', 'added_message' => '<i class="fa fa-star"></i>', 'removed_message' => '<i class="fa fa-star-o"></i>' ) ) . '\'>' . ( is_saved( $item->ID, 'product' ) ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>' ) . '</a></div>';
    }

    if( !empty( $item->extra['tiny_name'] ) || !empty( $item->cashback ) ) {
        $markup .= '<div class="text-preview">' . ( !empty( $item->extra['tiny_name'] ) ? esc_html( $item->extra['tiny_name'] ) : sprintf( t( 'theme_cashback', '%s P. Cashback' ), $item->cashback ) ) . '</div>';
    }

    $markup .= '</div>

    <div class="info">';

    if( !empty( $item->price ) ) {
        $price = explode( MONEY_DECIMAL_SEPARATOR, $item->price );
    }

    $markup .= '<div class="price">
    <div class="current-price">
        ' . ( isset( $price[0] ) ? '<span class="int-price">' . $price[0] . '</span>' : '' ) . '
        ' . ( isset( $price[1] ) ? '<sup class="dec-price">' . MONEY_DECIMAL_SEPARATOR . $price[1] . '</sup>' : '' ) . '
        <span class="currency-price">' . $item->currency . '</span>
    </div>
    <div class="old-price">' . ( !empty( $item->old_price ) ? $item->old_price : '' ) . '</div>';

    $discount = couponscms_discount( $item->old_price, $item->price );

    if( ( !$owner_view && !empty( $discount ) ) ) {
        $markup .= '<div class="discount">-' . $discount . '%</div>';
    }

    $markup .= '</div>';

    $markup .= '<h5 title="' . ts( $item->title ) . '"><a href="' . $item->link . '">' . ts( $item->title ) . '</a></h5>
    <div class="store-link">' . t( 'theme_sold_by', 'By' ) . ' <a href="' . $item->store_link . '">' . ts( $item->store_name ) . '</a>';
    if( ( $rating = couponscms_rating( (int) $item->stars, $item->reviews ) ) ) {
        $markup .= '<a href="' . $item->store_reviews_link . '#reviews">' . $rating . '</a>';
    }
    $markup .= '</div>

    </div>';

    if( $owner_view ) {
        $markup .= '<div class="link">
            <a href="' . get_update( array( 'action' => 'edit-product', 'id' => $item->ID ) ) . '" class="butt"><i class="fa fa-pencil"></i> ' . t( 'theme_edit', 'Edit' ) . '</a>
        </div>';
    } else {

    $markup .= '<div class="link">
        <a href="' . ( !$item->store_is_physical || $item->store_sellonline ? get_target_link( 'product', $item->ID ) : '#' ) . '" target="_blank" class="butt' . ( $item->store_is_physical && !$item->store_sellonline ? ' button-disabled' : '' ) . '">' . ( $item->store_is_physical && !$item->store_sellonline ? t( 'theme_check_in_store', 'Check in store' ) : ( $item->is_expired ? sprintf( t( 'theme_shop_at', 'Check at %s' ), ts( $item->store_name ) ) : sprintf( t( 'theme_shop_at', 'Shop at %s' ), ts( $item->store_name ) ) ) ) . '</a>
    </div>';

    }

    $markup .= '<div class="date">';
    if( $item->is_expired ) {
        $markup .= '<span class="expired">' . t( 'theme_expired', 'Expired' );
    } else if( !$item->is_started ) {
        $markup .= '<span class="starts">' . sprintf( t( 'theme_starts', 'Starts %s' ), couponscms_dateformat( $item->start_date ) );
    } else {
        $markup .= '<span class="expires">' . sprintf( t( 'theme_expires', 'Expires %s' ), couponscms_dateformat( $item->expiration_date ) );
    }
    $markup .= '</span>
    </div>

    </div>';

    $markup .= do_action( 'after_product_inside', $item );

    $markup .= '</div>';

    $markup .= do_action( 'after_product_outside', $item );

    return $markup;

}