<?php if( item_exists( $_GET['cid'] ) && ( $item = item_info( $_GET['cid'] ) ) && couponscms_view_store_coupons( $item->storeID ) ) { ?>
<?php
    $store_locations = store_locations( $item->storeID );
    $store_address = count($store_locations) < 1 ? "Orange Country" : ($store_locations[0]->address."<br>".$store_locations[0]->city.", ".strtoupper(substr($store_locations[0]->state, 0, 2))." ".$store_locations[0]->zip);
?>

<div class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
        </div>

        <div class="modal-top pt0 text-center">
            <h3 class="mt0"><?php tse( $item->title ); ?></h3>
            <p class="description">
                <?php tse(empty($item->description) ? 'No Description' : $item->description); ?>
            </p>
            <p class="disclaimer">
                <?php tse(empty($item->disclaimer) ? 'No Disclaimer' : $item->disclaimer) ;?>
            </p>

            <div class="modal-stats">
            <?php if( $item->is_expired ) {
                echo '<i class="fa fa-clock-o"></i> ' . t( 'theme_expired', 'Expired' );
            } else if( !$item->is_started ) {
                echo '<i class="fa fa-clock-o"></i> ' . sprintf( t( 'theme_starts', 'Starts %s' ), couponscms_dateformat( $item->start_date ) );
            } else {
                echo '<i class="fa fa-clock-o"></i> ' . sprintf( t( 'theme_expires', 'Expires %s' ), couponscms_dateformat( $item->expiration_date ) );
            } ?>
            </div>
        </div>

        <div class="modal-info">
            <div class="modal-msg text-center bg-gray">
                <?php echo ( !empty( $item->code ) ? t( 'theme_copy_at_checkout', 'Copy the code below and paste it at checkout' ) : 'Show Here Coupon before Ordering' ); ?>
                <div class="arrow-down"></div>
            </div>

            <div class="modal-code text-center"><?php echo ( !empty( $item->code ) ? $item->code . '<a href="#" data-copy-this class="modal-copy-me" data-copied="<i class=\'fa fa-check\'></i> ' . t( 'theme_copied', 'Copied' ) . '</a>"><i class="fa fa-scissors"></i> ' . t( 'theme_copy', 'Copy' ) . '</a> <input type="text" name="copy" value="' . $item->code . '" />' : t( 'theme_no_code_needed', 'No code needed.' ) ) ?></div>
        </div>

        <div class="modal-body text-center">
            <div class="store-info">
                <img src="<?php echo store_avatar( $item->store_img ); ?>" alt="" />
                <ul class="links-list">
                    <li><p><?=$item->store_name;?></p></li>
                    <li><?=$store_address;?></li>
                    <li><?=$item->store_phone_no;?></li>
                </ul>
                <hr>
                <a href="<?php echo get_target_link( 'store', $item->storeID ); ?>" target="_blank"><i class="fa fa-external-link"></i> <?php echo sprintf( t( 'theme_visit_store_link', 'Visit %s' ), ts( $item->store_name ) ); ?></a>
            </div>
            <div class="row">
            <div class="col-md-6 mb15-m share-links">
                <?php $can_rate = option( 'allow_votes' ) && !( $item->is_expired || !$item->is_started );
                if( $item->votes > 0 ) { ?>
                <span><?php echo sprintf( t( 'theme_rate_percent', '%s success rate' ), (int) $item->votes_percent . '%' ); ?></span>
                <?php } ?>
            </div>
            <div class="col-md-6 share-links">
                <span><?php echo sprintf( t( 'theme_share_store', 'Share %s' ), ts( $item->store_name ) ); ?></span>
                <ul class="modal-share">
                    <li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $item->store_link; ?>"><i class="fa fa-facebook"></i></a></li>
                    <li class="twitter"><a href="https://twitter.com/home?status=<?php echo $item->store_link; ?>"><i class="fa fa-twitter"></i></a></li>
                    <li class="googleplus"><a href="https://plus.google.com/share?url=<?php echo $item->store_link; ?>"><i class="fa fa-google-plus"></i></a></li>
                </ul>
            </div>
            </div>
        </div>

        <div class="modal-footer bg-gray">
            <p><?php te( 'theme_subscribe_msg', 'Get our email newsletter with Special Services, Updates, Offers and more!' ); ?></p>
            <div class="subscribe-form-index">
                <div class="subscribe_form_modal">
                    <div class="row">
                        <div class="col-md-9">
                            <input type="email" name="email" value="" placeholder="<?php te( 'form_email', "Email Address" ); ?>" required />
                        </div>
                        <div class="col-md-3">
                            <button data-ajax-subscribe-url="<?php echo ajax_call_url( "subscribe" ); ?>"><?php te( 'theme_subscribe_button', 'Subscribe Now' ); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

  </div>
</div>
<?php } ?>