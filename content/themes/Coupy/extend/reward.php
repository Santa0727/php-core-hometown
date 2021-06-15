<?php

function couponscms_reward_item( $item = object ) {

    $markup = do_action( 'before_reward_outside', $item );

    $markup .= '<div class="col-md-12">';

    $markup .= do_action( 'before_reward_inside', $item );

    $markup .= '<div class="reward">';

    $markup .= '<div class="row">';

    $markup .= '<div class="col-md-2 text-center">';
    $markup .= '<img src="' . reward_avatar( $item->image ) . '" alt="" />';
    $markup .= '</div>';

    $markup .= '<div class="col-md-10">';
    $markup .= '<h3 class="mt0">' . ts( $item->title ) . '</h3>';
    $markup .= '<div class="description">' . ts( $item->description ) . '</div>';
    $markup .= '<div class="points">' . sprintf( t( 'theme_redeem_required_points', '<b>%s</b> points required to redeem this' ), $item->points ) . '</div>';
    $markup .= create_reward_request( $item );
    $markup .= '</div>

    </div>';

    $markup .= do_action( 'after_reward_inside', $item );

    $markup .= '</div>
    </div>';

    $markup .= do_action( 'after_reward_outside', $item );

    return $markup;

}

function couponscms_reward_request_item( $item = object ) {

    $markup = do_action( 'before_reward_reqest_outside', $item );

    $markup .= '<div class="col-md-12">';

    $markup .= do_action( 'before_reward_reqest_inside', $item );

    $markup .= '<div class="reward">';

    $markup .= '<div class="row">';
    $markup .= '<div class="col-md-12">';
    $markup .= '<h3 class="mt0">' .$item->name . '</h3>';
    $markup .= '<div class="description">' . sprintf( t( 'theme_reward_request_state', 'State: %s' ), ( !$item->claimed ? t( 'theme_claim_reqest_pending', 'Pending' ) : t( 'theme_claim_reqest_completed', 'Completed' )) ) . '</div>';
    $markup .= '<div class="points">' . sprintf( t( 'theme_reward_required_points_used', '<b>%s</b> points used' ), $item->points ) . '</div>';
    $markup .= '</div>
    </div>

    </div>';

    $markup .= do_action( 'after_reward_reqest_inside', $item );

    $markup .= '</div>';

    $markup .= do_action( 'after_reward_reqest_outside', $item );

    return $markup;

}