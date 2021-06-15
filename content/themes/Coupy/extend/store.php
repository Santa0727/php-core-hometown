<?php

function couponscms_store_item( $item = object, $column_width = 3, $owner_view = false ) {

    $item->is_owner_view = $owner_view;

    $markup = do_action( 'before_store_outside', $item );

    $markup .= '<div class="col-md-' . $column_width . ' col-sm-6" id="store-' . $item->ID . '">';

    $markup .= do_action( 'before_store_inside', $item );

    $markup .= '<div class="store">';

    $markup .= '<div class="img-preview">';

    if( !$owner_view ) {
        $markup .='<div class="heart"><a href="#" data-ajax-call="' . ajax_call_url( "save" ) . '" data-data=\'' . json_encode( array( 'item' => $item->ID, 'type' => 'store', 'added_message' => '<i class="fa fa-star"></i>', 'removed_message' => '<i class="fa fa-star-o"></i>' ) ) . '\'>' . ( is_saved( $item->ID, 'store' ) ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>' ) . '</a></div>';
        $markup .='<div class="favorite"><a href="#" data-ajax-call="' . ajax_call_url( "favorite" ) . '" data-data=\'' . json_encode( array( 'store' => $item->ID, 'added_message' => '<i class="fa fa-heart"></i>', 'removed_message' => '<i class="fa fa-heart-o"></i>' ) ) . '\'>' . ( is_favorite( $item->ID, 'store' ) ? '<i class="fa fa-heart"></i>' : '<i class="fa fa-heart-o"></i>' ) . '</a></div>';
    }

    $markup .= '<img src="' . store_avatar( $item->image ) . '" alt="" />';

    $markup .= '</div>';

    $markup .= '<div class="info">';
    $markup .= '<h5 title="' . ts( $item->name ) . '"><a href="' . $item->link . '">' . ts( $item->name ) . '</a></h5>';
    $markup .= '</div>';

    if( $owner_view ) {
        $markup .= '<div class="link">
            <a href="' . get_update( array( 'action' => 'edit-store', 'id' => $item->ID ) ) . '" class="butt"><i class="fa fa-pencil"></i> ' . t( 'theme_edit', 'Edit' ) . '</a>
        </div>';
    } else {

    $markup .= '<div class="link">
        <a href="' . $item->link . '" class="butt">' . t( 'theme_link_view_offers', 'View Offers' ) . '</a>
    </div>';

    }

    $stats = array();

    if( $item->coupons > 0 ) {
        $stats[] = sprintf( t( 'theme_stats_coupons', '%s coupons' ), $item->coupons );
    }

    if( $item->products > 0 ) {
        $stats[] = sprintf( t( 'theme_stats_products', '%s products' ), $item->products );
    }

    $markup .= '<div class="stats">';
    if( !empty( $stats ) ) {
        $markup .= implode( ', ', $stats );
    }
    $markup .= '</div>

    </div>';

    $markup .= do_action( 'after_store_inside', $item );

    $markup .= '</div>';

    $markup .= do_action( 'after_store_outside', $item );

    return $markup;

}