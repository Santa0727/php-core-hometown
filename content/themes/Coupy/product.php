<?php $coupon = the_item(); ?>

<?php echo do_action( 'coupon_before_info' ); ?>

<div class="container coupon-single pt50 pb50">
    <div class="row">
        <div class="col-md-3">
            <div class="store">
                <div class="img-preview">
                    <div class="heart"><a href="#" data-ajax-call="<?php echo ajax_call_url( "save" ); ?>" data-data='<?php echo json_encode( array( 'item' => $coupon->ID, 'type' => 'coupon', 'added_message' => '<i class="fa fa-star"></i>', 'removed_message' => '<i class="fa fa-star-o"></i>' ) ); ?>'><?php echo ( is_saved( $coupon->ID, 'coupon' ) ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>' ); ?></a></div>
                    <img src="<?php echo store_avatar( $coupon->store_img ); ?>" alt="" />
                </div>
            </div>
            <ul class="links-list">
                <li><a href="<?php echo get_update( array( 'type' => 'products' ), $coupon->store_link ); ?>"><i class="fa fa-shopping-bag"></i> <?php te( 'theme_view_products', 'View Products' ); ?></a></li>
                <li><a href="<?php echo get_update( array( 'type' => 'coupons' ), $coupon->store_link ); ?>"><i class="fa fa-tags"></i> <?php te( 'theme_view_coupons', 'View Coupons' ); ?></a></li>
                <li><a href="<?php echo ( me() ? $coupon->store_reviews_link . '#add_view' : tlink( 'tpage/login' ) ); ?>"><i class="fa fa-pencil"></i> <?php te( 'theme_add_review', 'Add Review' ); ?></a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <h1><?php echo $coupon->title; ?></h1>
            <?php if( ( $rating = couponscms_rating( (int) $coupon->stars, $coupon->reviews ) ) ) {
                echo '<div class="rating"><a href="' . $coupon->store_reviews_link . '#reviews">' . $rating . '</a></div>';
            } ?>
            <hr />
            <?php echo ( !empty( $coupon->description ) ? '<span>' . $coupon->description . '</span>' : t( 'theme_no_description', 'No description.' ) ); ?>

            <ul class="description-links">
                <?php if( !empty( $coupon->price ) ) {
                $price = explode( MONEY_DECIMAL_SEPARATOR, $coupon->price );
                echo '<li class="price-list">
                <div class="price">
                <div class="current-price">
                    ' . ( isset( $price[0] ) ? '<span class="int-price">' . $price[0] . '</span>' : '' ) . '
                    ' . ( isset( $price[1] ) ? '<sup class="dec-price">' . MONEY_DECIMAL_SEPARATOR . $price[1] . '</sup>' : '' ) . '
                    <span class="currency-price">' . $coupon->currency . '</span>
                </div>
                <div class="old-price">' . ( !empty( $coupon->old_price ) ? $coupon->old_price : '' ) . '</div>
                </li>';
                } ?>
                <li><i class="fa fa-hourglass-half"></i>
                <?php if( $coupon->is_expired ) {
                echo '<span class="expired exp-date">' . t( 'theme_expired', 'Expired' ) . '</span>';
                } else if( !$coupon->is_started ) {
                    echo '<span class="starts exp-date">' . sprintf( t( 'theme_starts', 'Starts %s' ), couponscms_dateformat( $coupon->start_date ) ) . '</span>';
                } else {
                    echo '<span class="expires exp-date">' . sprintf( t( 'theme_expires', 'Expires %s' ), couponscms_dateformat( $coupon->expiration_date ) ) . '</span>';
                } ?>
                </li>
            </ul>

            <div class="modal-info mt50">
                <?php echo '<a href="' . ( !$coupon->store_is_physical || $coupon->store_sellonline ? get_target_link( 'product', $coupon->ID ) : '#' ) . '" target="_blank" class="butt' . ( $coupon->store_is_physical && !$coupon->store_sellonline ? ' button-disabled' : '' ) . '">' . ( $coupon->store_is_physical && !$coupon->store_sellonline ? t( 'theme_check_in_store', 'Check in store' ) : ( $coupon->is_expired ? sprintf( t( 'theme_shop_at', 'Check at %s' ), ts( $coupon->store_name ) ) : sprintf( t( 'theme_shop_at', 'Shop at %s' ), ts( $coupon->store_name ) ) ) ) . '</a>'; ?>
            </div>
        </div>
    </div>
</div>

<?php echo do_action( 'coupon_after_info' ); ?>

<section class="items-list bg-gray">

<?php echo '<h2>' . t( 'theme_other_products', 'Other Products' ) . '</h2>
<div class="container">';

echo do_action( 'product_before_items' );

echo '<div class="row">';
foreach( products_custom( array( 'show' => 'active', 'orderby' => 'rand', 'max' => option( 'items_per_page' ) ) ) as $item ) {
    echo couponscms_product_item( $item );
}
echo '</div>';

echo do_action( 'ads_bottom_page' );
echo do_action( 'product_after_items' );
echo '</div>'; ?>

</section>