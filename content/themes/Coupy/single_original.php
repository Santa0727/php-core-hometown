<?php $coupon = the_item(); ?>

<?php echo do_action( 'coupon_before_info' ); ?>

<div class="container coupon-single pt50 pb50">
    <div class="row">
        <div class="col-md-3">
            <div class="store">
                <div class="img-preview">
                    <div class="heart"><a href="#" data-ajax-call="<?php echo ajax_call_url( "save" ); ?>" data-data='<?php echo json_encode( array( 'item' => $coupon->ID, 'type' => 'coupon', 'added_message' => '<i class="fa fa-star"></i>', 'removed_message' => '<i class="fa fa-star-o"></i>' ) ); ?>'><?php echo ( is_saved( $coupon->ID, 'coupon' ) ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>' ); ?></a></div>
                    <img src="<?php echo store_avatar( ( !empty( $coupon->image ) ? $coupon->image : $coupon->store_img ) ); ?>" alt="" />
                </div>
            </div>
            <ul class="links-list">
                <li><a href="<?php echo get_update( array( 'type' => 'products' ), $coupon->store_link ); ?>"><i class="fa fa-shopping-bag"></i> <?php te( 'theme_view_products', 'View Products' ); ?></a></li>
                <li><a href="<?php echo get_update( array( 'type' => 'coupons' ), $coupon->store_link ); ?>"><i class="fa fa-tags"></i> <?php te( 'theme_view_coupons', 'View Coupons' ); ?></a></li>
                <li><a href="<?php echo ( me() ? $coupon->store_reviews_link . '#add_view' : tlink( 'tpage/login' ) ); ?>"><i class="fa fa-pencil"></i> <?php te( 'theme_add_review', 'Add Review' ); ?></a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <h1><?php tse( $coupon->title ); ?></h1>
            <?php if( ( $rating = couponscms_rating( (int) $coupon->stars, $coupon->reviews ) ) ) {
                echo '<div class="rating"><a href="' . $coupon->store_reviews_link . '#reviews">' . $rating . '</a></div>';
            } ?>
            <hr />
            <?php //echo ( !empty( $coupon->description ) ? '<span>' . ts( $coupon->description ) . '</span>' : t( 'theme_no_description', 'No description.' ) ); ?>
            <?php echo ( !empty( $coupon->description ) ? '<p style="white-space: pre;">' . ts( $coupon->description ) . '</p>' : t( 'theme_no_description', 'No description.' ) ); ?>

            <?php $stats = array();
            if( $coupon->is_verified ) {
                $stats[] = '<li><i class="fa fa-check"></i> ' . sprintf( t( 'theme_verified_msg', 'Verified manually, last time on %s' ), couponscms_dateformat( $coupon->last_check ) ) . '</li>';
            }
            if( $coupon->clicks > 0 ) {
                $stats[] = '<li><i class="fa fa-bookmark"></i> <span>' . sprintf( t( 'theme_stats_used', '%s used' ), $coupon->clicks )  . '</span></li>';
            }
            if( $coupon->votes > 0 ) {
                $stats[] = '<li><i class="fa fa-thumbs-up"></i> <span>' . sprintf( t( 'theme_stats_percent_rate', '%s success rate' ), (int) $coupon->votes_percent . '%' )  . '</span></li>';
            } ?>
            <ul class="description-links">
            <?php echo implode( "\n", $stats ); ?>
            <li><i class="fa fa-hourglass-half"></i>
            <?php if( $coupon->is_expired ) {
                echo '<span class="expired exp-date">' . t( 'theme_expired', 'Expired' ) . '</span>';
            } else if( !$coupon->is_started ) {
                echo '<span class="starts exp-date">' . sprintf( t( 'theme_starts', 'Starts <strong>%s</strong>' ), couponscms_dateformat( $coupon->start_date ) ) . '</span>';
            } else {
                echo '<span class="expires exp-date">' . sprintf( t( 'theme_expires', 'Expires <strong>%s</strong>' ), couponscms_dateformat( $coupon->expiration_date ) ) . '</span>';
            } ?>
            </li>
            </ul>

            <div class="modal-info mt50">

                <?php if( $coupon->is_printable ) {
                    echo '<a href="' . get_target_link( 'coupon', $coupon->ID ) . '" class="butt">' . t( 'theme_print', 'Print It' ) . '</a>';
                } else if( $coupon->is_show_in_store ) {
                    if( ( $claimed = is_coupon_claimed( $coupon->ID ) ) ) {
                        echo '<div class="qr-code">
                        <img src="https://chart.googleapis.com/chart?cht=qr&chl=' . urlencode( tlink( 'user/account', 'action=check&code=' . $claimed->code ) ) . '&chs=180x180&choe=UTF-8&chld=L|2" alt="qr code" />
                        </div>';
                        echo '<a href="#" data-code="' . $claimed->code . '" class="butt"><span>' . t( 'theme_claimed_show_code', 'Show Code' ) . '</span></a>';
                    } else if( $coupon->claim_limit == 0 || $coupon->claim_limit > $coupon->claims ) {
                        echo '<a href="#" data-ajax-call="' . ajax_call_url( "claim" ) . '" data-data=\'' . json_encode( array( 'item' => $coupon->ID, 'claimed_message' => '<i class="fa fa-check"></i><span> ' . t( 'theme_claimed', 'Claimed !' ) ) ) . '\' data-after-ajax="coupon_claimed" data-confirmation="' . t( 'theme_claim_ask', 'Do you want to claim and use this coupon in store?' ) . '" class="butt">' . t( 'theme_claim', 'Claim' ) . '</a>';
                    }
                } else if( $coupon->is_coupon ) { ?>

                    <div class="modal-msg text-center bg-gray">
                        <?php if( couponscms_view_store_coupons( $coupon->storeID ) ) {
                            echo ( !empty( $coupon->code ) ? t( 'theme_copy_at_checkout', 'Copy the code below and paste it at checkout' ) : t( 'theme_store_sale', 'Store sale' ) );
                        } else {
                            te( 'theme_review_coupon', 'Click on the link below to review the coupon' );
                        } ?>
                        <div class="arrow-down"></div>
                    </div>

                    <div class="modal-code text-center">
                    <?php if( couponscms_view_store_coupons( $coupon->storeID ) ) {
                        echo ( !empty( $coupon->code ) ? $coupon->code . '<a href="#" data-copy-this class="modal-copy-me" data-copied="<i class=\'fa fa-check\'></i> ' . t( 'theme_copied', 'Copied' ) . '</a>"><i class="fa fa-scissors"></i> ' . t( 'theme_copy', 'Copy' ) . '</a> <input type="text" name="copy" value="' . $coupon->code . '" />' : t( 'theme_no_code_needed', 'No code needed.' ) );
                    } else {
                        echo '<a href="' . get_target_link( 'coupon', $coupon->ID, array( 'reveal_code' => true, 'backTo' => $coupon->link ) ) . '" target="_blank" data-target-on-click="' . get_target_link( 'coupon', $coupon->ID ) . '">' . t( 'theme_click_to_view_coupon', 'Click here to reveal the coupon' ) . '</a>';
                    } ?>
                    </div>

                    <a href="<?php echo get_target_link( 'coupon', $coupon->ID ); ?>" target="_blank" class="butt"><?php echo ( $coupon->is_expired ? t( 'theme_view_coupon', 'View Coupon' ) : t( 'theme_get_coupon', 'Get Coupon' ) ); ?></a>

                <?php } ?>

            </div>

            <?php if( option( 'allow_votes' ) && !( $coupon->is_expired || !$coupon->is_started ) ) { ?>

            <div class="text-center mt50">
                <h5><?php te( 'theme_rate_coupon', 'Rate this coupon' ); ?></h5>
                <ul class="modal-vote">
                    <li class="thumb-up"><a href="#" data-ajax-call="<?php echo ajax_call_url( "vote" ); ?>" data-after-ajax="ajax_voted" data-data='<?php echo json_encode( array( 'item' => $coupon->ID, 'vote' => 1, 'voted_message' => '<i class="fa fa-check"></i> ' . t( 'theme_voted_msg', 'Voted, thank you!' ), 'already_voted_message' => '<i class="fa fa-check"></i> ' . t( 'theme_voted_msg', 'Voted, thank you!' ) ) ); ?>'><i class="fa fa-thumbs-o-up"></i> <?php te( 'theme_it_works', "It Works" ); ?></a></li>
                    <li class="thumb-down"><a href="#" data-ajax-call="<?php echo ajax_call_url( "vote" ); ?>" data-after-ajax="ajax_voted" data-data='<?php echo json_encode( array( 'item' => $coupon->ID, 'vote' => 0, 'voted_message' => '<i class="fa fa-check"></i> ' . t( 'theme_voted_msg', 'Voted, thank you!' ), 'already_voted_message' => '<i class="fa fa-check"></i> ' . t( 'theme_voted_msg', 'Voted, thank you!' ) ) ); ?>'><i class="fa fa-thumbs-o-down"></i> <?php te( 'theme_it_doesnt_works', "It Doesn't Work" ); ?></a></li>
                </ul>
            </div>

            <?php } ?>

        </div>
    </div>
</div>

<?php echo do_action( 'coupon_after_info' ); ?>

<section class="items-list bg-gray">

<?php echo '<h2>' . t( 'theme_other_coupons', 'View Other Coupons' ) . '</h2>
<div class="container">';

echo do_action( 'coupon_before_items' );

echo '<div class="row">';
foreach( items_custom( array( 'show' => ',active', 'orderby' => 'rand', 'max' => option( 'items_per_page' ) ) ) as $item ) {
    echo couponscms_coupon_item( $item );
}
echo '</div>';

echo do_action( 'coupon_after_items' );
echo '</div>'; ?>

</section>