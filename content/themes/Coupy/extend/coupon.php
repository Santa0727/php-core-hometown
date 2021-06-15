<?php

function couponscms_coupon_item( $item = object, $column_width = 3, $owner_view = false ) {

    $item->is_owner_view = $owner_view;

    $markup = do_action( 'before_coupon_outside', $item );

    $markup .= '<div class="col-md-' . $column_width . ' col-sm-6" id="coupon-' . $item->ID . '">';

    $markup .= do_action( 'before_coupon_inside', $item );

    $markup .= '<div class="coupon">';

    $markup .= '<div class="img-preview">';

    if( !( $owner_view || $item->is_expired ) ) {
        $markup .='<div class="heart"><a href="#" data-ajax-call="' . ajax_call_url( "save" ) . '" data-data=\'' . json_encode( array( 'item' => $item->ID, 'type' => 'coupon', 'added_message' => '<i class="fa fa-star"></i>', 'removed_message' => '<i class="fa fa-star-o"></i>' ) ) . '\'>' . ( is_saved( $item->ID, 'coupon' ) ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>' ) . '</a></div>';
    }

    $markup .= '<img class="link-logo" src="' . store_avatar( ( !empty( $item->image ) ? $item->image : $item->store_img ) ) . '" data-link="'.$item->store_link.'" alt="" />';

    if( !empty( $item->extra['tiny_name'] ) || !empty( $item->cashback ) ) {
        $markup .= '<div class="text-preview">' . ( !empty( $item->extra['tiny_name'] ) ? esc_html( $item->extra['tiny_name'] ) : sprintf( t( 'theme_cashback', '%s P. Cashback' ), $item->cashback ) ) . '</div>';
    }

    $markup .= '</div>';

    $markup .= '<div class="info">';

    $markup .= '<h5 title="' . ts( $item->title ) . '">';
    if( $item->is_verified ) {
        $markup .= '<i class="fa fa-check" data-tooltip title="' . sprintf( t( 'theme_verified_msg', 'Verified manually, last time on %s' ), couponscms_dateformat( $item->last_check ) ) . '"></i>';
    }
    $markup .= '<a href="' . $item->link . '">' . ts( $item->title ) . '</a></h5>

    <div class="store-link">' . t( 'theme_sold_by', 'By' ) . ' <a href="' . $item->store_link . '">' . ts( $item->store_name ) . '</a>';
    if( ( $rating = couponscms_rating( (int) $item->stars, $item->reviews ) ) ) {
        $markup .= '<a href="' . $item->store_reviews_link . '#reviews">' . $rating . '</a>';
    }
    $markup .= '</div>';

    $markup .= '</div>';

    if( $owner_view ) {
        $markup .= '<div class="link">
            <a href="' . get_update( array( 'action' => 'edit-coupon', 'id' => $item->ID ) ) . '" class="butt"><i class="fa fa-pencil"></i> ' . t( 'theme_edit', 'Edit' ) . '</a>
        </div>';
    } else {

    $markup .= '<div class="link">';

    if( $item->is_printable ) {         
        $markup .= '<a href="' . (me() ? get_target_link( 'coupon', $item->ID ) : tlink( 'tpage/login' )) . '" target="'.(me() ? "_blank" : "_self").'" class="butt">' . t( 'theme_print', 'Print It' ) . '</a>';
    } else if( $item->is_show_in_store ) {
        if( ( $claimed = is_coupon_claimed( $item->ID ) ) ) {
            $markup .= '<div class="qr-code">
            <img src="https://chart.googleapis.com/chart?cht=qr&chl=' . urlencode( tlink( 'user/account', 'action=check&code=' . $claimed->code ) ) . '&chs=140x140&choe=UTF-8&chld=L|2" alt="qr code" />
            </div>';
            // $markup .= '<a href="#" data-code="' . $claimed->code . '" class="butt"><span>' . t( 'theme_claimed_show_code', 'Show Code' ) . '</span></a>';
            $markup .= '<a href="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => get_update( array( 'cid' => $item->ID ) ) ) ) . '" class="butt target="_blank" data-target-on-click="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => $item->link ) ) . '"><span>' . t( 'theme_claimed_show_code', 'Show Code' ) . '</span></a>';
        } else if( $item->claim_limit == 0 || $item->claim_limit > $item->claims ) {
            // $markup .= '<a href="#" data-ajax-call="' . ajax_call_url( "claim" ) . '" data-data=\'' . json_encode( array( 'item' => $item->ID, 'claimed_message' => '<i class="fa fa-check"></i><span> ' . t( 'theme_claimed', 'Claimed !' ) ) ) . '\' data-after-ajax="coupon_claimed" data-confirmation="' . t( 'theme_claim_ask', 'Do you want to claim and use this coupon in store?' ) . '" class="butt">' . t( 'theme_claim', 'Claim' ) . '</a>';
            $markup .= '<a href="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => get_update( array( 'cid' => $item->ID ) ) ) ) . '" class="butt" target="_blank" data-target-on-click="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => $item->link ) ) . '">' . t( 'theme_claim', 'Claim' ) . '</a>';
        }
    } else if( $item->is_coupon ) {
        if( couponscms_view_store_coupons( $item->storeID ) ) {
            $markup .= '<div class="code"><i class="fa fa-scissors"></i>' . $item->code . '<a href="#" data-copy-this class="modal-copy-me" data-copied="<i class=\'fa fa-check\'></i>"><i class="fa fa-scissors" title="' . t( 'theme_copy', 'Copy' ) . '" data-placement="top"></i></a> <input type="text" name="copy" value="' . $item->code . '" /></div>';
        } else {
            if( get_theme_option( 'coupon_open' ) == 'single' ) {
                $markup .= '<a href="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => $item->link ) ) . '" target="_blank" class="butt" data-target-on-click="' . get_target_link( 'coupon', $item->ID ) . '">' . ( $item->is_expired ? t( 'theme_view_coupon', 'View Coupon' ) : t( 'theme_get_coupon', 'Get Coupon' ) ) . '</a>';
            } else {
                $markup .= '<a href="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => get_update( array( 'cid' => $item->ID ) ) ) ) . '" class="butt" target="_blank" data-target-on-click="' . get_target_link( 'coupon', $item->ID ) . '">' . ( $item->is_expired ? t( 'theme_view_coupon', 'View Coupon' ) : t( 'theme_get_coupon', 'Get Coupon' ) ) . '</a>';
            }
        }
    } else {
        // if( get_theme_option( 'coupon_open' ) == 'single' ) {
        //     $markup .= '<a href="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => $item->link ) ) . '" target="_blank" class="butt" data-target-on-click="' . get_target_link( 'coupon', $item->ID ) . '">' . t( 'theme_get_deal', 'Activate' ) . '</a>';
        // } else {
        //     $markup .= '<a href="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => get_update( array( 'cid' => $item->ID ) ) ) ) . '" class="butt" target="_blank" data-target-on-click="' . get_target_link( 'coupon', $item->ID ) . '">' . t( 'theme_get_deal', 'Activate' ) . '</a>';
        // }
        if( get_theme_option( 'coupon_open' ) == 'single' ) {
            $markup .= '<a href="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => $item->link ) ) . '" target="_blank" class="butt" data-target-on-click="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => $item->link ) ) . '">' . t( 'theme_get_deal', 'Activate' ) . '</a>';
        } else {
            $markup .= '<a href="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => get_update( array( 'cid' => $item->ID ) ) ) ) . '" class="butt" target="_blank" data-target-on-click="' . get_target_link( 'coupon', $item->ID, array( 'reveal_code' => true, 'backTo' => $item->link ) ) . '">' . t( 'theme_get_deal', 'Activate' ) . '</a>';
        }
    }

    $markup .= '</div>';

    }

    $stats = array();

    if( $item->clicks > 0 ) {
        $stats[] = sprintf( t( 'theme_stats_used', '%s used' ), $item->clicks );
    }

    if( $item->votes > 0 ) {
        $stats[] = sprintf( t( 'theme_stats_percent_rate', '%s success rate' ), (int) $item->votes_percent . '%' );
    }

    $markup .= '<div class="stats">';
    if( !empty( $stats ) ) {
        $markup .= implode( ', ', $stats );
    }
    $markup .= '</div>';

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

    $markup .= do_action( 'after_coupon_inside', $item );

    $markup .= '</div>';

    $markup .= do_action( 'after_coupon_outside', $item );

    return $markup;

}

function couponscms_claims_item( $item = object ) {

    $markup = do_action( 'before_claims_item_outside', $item );

    $markup .= '<div class="list-item reward claims_item clearfix">';

    $markup .= do_action( 'before_claims_item_inside', $item );

    $markup .= '<div class="list-item-content claims-item-content">';
    $markup .= '<div class="middle">';
    $markup .= '<h3 class="mt0">' . ( $item->is_used ? $item->code : '***' . substr( $item->code, -3 ) ) . '</h3>';
    $markup .= '<div class="list-info">' . sprintf( t( 'theme_claims_used_state', 'Used: %s' ), ( $item->is_used ? t( 'yes', 'Yes' ) : t( 'no', 'No' ) ) ) . '</div>';
    if( $item->is_used ) {
        $markup .= '<div class="list-info">' . sprintf( t( 'theme_claims_used_date', 'Used Date: %s' ), $item->used_date ) . '</div>';
    }
    $markup .= '<div class="list-info">' . sprintf( t( 'theme_claims_claimed_date', 'Claimed Date: %s' ), $item->date ) . '</div>';
    $markup .= '</div>

    </div>';

    $markup .= do_action( 'after_reward_reqest_inside', $item );

    $markup .= '</div>';

    $markup .= do_action( 'after_reward_reqest_outside', $item );

    return $markup;

}

