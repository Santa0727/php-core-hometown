<?php

function couponscms_plans_item( $item = object ) {

    $markup = do_action( 'before_plans_outside', $item );

    $markup .= '<div class="col-md-12">';

    $markup .= do_action( 'before_plans_inside', $item );

    $markup .= '<div class="reward">';

    $markup .= '<div class="row">';

    $markup .= '<div class="col-md-2 text-center">';
    $markup .= '<img src="' . payment_plan_avatar( $item->image ) . '" alt="" />';
    $markup .= '</div>';

    $markup .= '<div class="col-md-10">';
    $markup .= '<h3 class="mt0">' .$item->name . '</h3>';
    $markup .= '<div class="description mb10">' . $item->description . '</div>';
    $markup .= '<div class="points mb10">' . sprintf( t( 'theme_payment_plan_price', 'Price: <b>%s</b>' ), $item->price_format ) . '</div>';
    $markup .= '<a href="' . tlink( 'pay', 'plan=' . $item->ID ) . '" class="butt">' . sprintf( t( 'theme_payment_plan_button', 'Buy %s credits' ), $item->credits ) . '</a>';
    $markup .= '</div>

    </div>';

    $markup .= do_action( 'after_plans_inside', $item );

    $markup .= '</div>
    </div>';

    $markup .= do_action( 'after_plans_outside', $item );

    return $markup;

}