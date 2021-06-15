<?php

function couponscms_review_item( $item = object, $owner_view = false ) {

    $item->is_owner_view = $owner_view;

    $markup = do_action( 'before_review_outside', $item );

    $markup .= '<div class="col-md-12">';

    $markup .= do_action( 'before_review_inside', $item );

    $markup .= '<div class="review">';

    $markup .= '<div class="row">';

    $markup .= '<div class="col-md-2 text-center">';
    $markup .= '<img src="' . user_avatar( $item->user_avatar ) . '" alt="" />';
    $markup .= '</div>';

    $markup .= '<div class="col-md-8">';
    $markup .= '<h4 class="mt0">' . $item->user_name . '</h4>';
    $markup .= '<div class="description">' . $item->text . '</div>';
    $markup .= '<i>' . couponscms_dateformat( $item->date ) . '</i>';
    $markup .= '</div>';

    $markup .= '<div class="col-md-2 text-right">';
    if( ( $rating = couponscms_rating( (int) $item->stars ) ) ) {
        $markup .= $rating;
    }
    $markup .= '</div>

    </div>

    </div>';

    $markup .= do_action( 'after_review_inside', $item );

    $markup .= '</div>';

    $markup .= do_action( 'after_review_outside', $item );

    return $markup;

}