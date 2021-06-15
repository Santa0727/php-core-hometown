<?php

$store = the_item();

$atts = array();
if( !empty( $_GET['active'] ) ) {
    $atts[] = 'active';
}

?>

<?php echo do_action( 'store_reviews_before_info' ); ?>

<div class="container store-single pt50 pb50">
    <div class="row">
        <div class="col-md-3">
            <div class="store">
                <div class="img-preview">
                    <div class="heart"><a href="#" data-ajax-call="<?php echo ajax_call_url( "save" ); ?>" data-data='<?php echo json_encode( array( 'item' => $store->ID, 'type' => 'store', 'added_message' => '<i class="fa fa-star"></i>', 'removed_message' => '<i class="fa fa-star-o"></i>' ) ); ?>'><?php echo ( is_saved( $store->ID, 'store' ) ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>' ); ?></a></div>
                    <div class="favorite"><a href="#" data-ajax-call="<?php echo ajax_call_url( "favorite" ); ?>" data-data='<?php echo json_encode( array( 'store' => $store->ID, 'added_message' => '<i class="fa fa-heart"></i>', 'removed_message' => '<i class="fa fa-heart-o"></i>' ) ); ?>'><?php echo ( is_favorite( $store->ID, 'store' ) ? '<i class="fa fa-heart"></i>' : '<i class="fa fa-heart-o"></i>' ); ?></a></div>
                    <img src="<?php echo store_avatar( ( !empty( $store->image ) ? $store->image : '' ) ); ?>" alt="" />
                </div>
            </div>
            <ul class="links-list">
                <li><a href="<?php echo get_update( array( 'type' => 'products' ), get_remove( array( 'page', 'type', 'cid', 'pid' ), $store->link ) ); ?>"><i class="fa fa-shopping-bag"></i> <?php te( 'theme_view_products', 'View Products' ); ?></a></li>
                <li><a href="<?php echo get_update( array( 'type' => 'coupons' ), get_remove( array( 'page', 'type', 'cid', 'pid' ),  $store->link ) ); ?>"><i class="fa fa-tags"></i> <?php te( 'theme_view_coupons', 'View Coupons' ); ?></a></li>
                <li><a href="<?php echo ( me() ? '#add_view' : tlink( 'tpage/login' ) ); ?>"><i class="fa fa-pencil"></i> <?php te( 'theme_add_review', 'Add Review' ); ?></a></li>
                <?php if( !empty( $store->url ) ) { ?>
                <li><a href="<?php echo get_target_link( 'store', $store->ID ); ?>"><i class="fa fa-external-link"></i> <?php te( 'theme_store_visit', 'Visit Website' ); ?></a></li>
                <?php }
                if( $store->is_physical ) {
                if( !empty( $store->hours ) ) {
                    $today = strtolower( date( 'l' ) ); ?>
                    <li><a href="#" class="hours"><i class="fa fa-clock-o"></i> <?php echo sprintf( t( 'theme_store_hours_today', 'Hours ( Today: %s )' ),  ( isset( $store->hours[$today]['opened'] ) ? $store->hours[$today]['from'] . ' - ' . $store->hours[$today]['to'] :  t( 'theme_store_closed', 'Closed' ) ) ); ?></a>
                    <?php
                        $daysofweek = days_of_week();
                        echo '<ul class="store-hours">';
                        foreach( $daysofweek as $day => $dayn ) {
                            echo '<li' . ( $day === $today ? ' class=\'htoday\'' : '' ) . '><span>' . $dayn . ':</span> <b>' . ( isset( $store->hours[$day]['opened'] ) ? $store->hours[$day]['from'] . ' - ' . $store->hours[$day]['to'] :  t( 'theme_store_closed', 'Closed' ) ) . '</b></li>';
                        }
                        echo '</ul></li>';
                    ?>
                    </li>
                <?php }
                    $locations = store_locations( $store->ID );
                    if( !empty( $locations ) ) {
                        echo '<li><i class="fa fa-map-marker"></i> <ul class="store-locations">';
                        foreach( $locations as $location ) {
                            echo '<li data-lat="' . $location->lat . '" data-lng="' . $location->lng . '" data-title="' . implode( ', ', array( $location->city, $location->state ) ) . '" data-content="' . implode( ', ', array( $location->address, $location->zip ) ) . '">
                                <a href="#" data-map-recenter="' . $location->lat . ',' . $location->lng . '">
                                    ' . implode( ', ', array( $location->address, $location->zip, $location->city, $location->state, $location->country ) ) . '
                                </a>
                            </li>';
                        }
                        echo '</ul></li>';
                    }
                } ?>
                <?php if( !empty( $store->phone_no ) ) { ?>
                <li><i class="fa fa-phone"></i> <?php echo sprintf( t( 'theme_phone_no', 'Phone Number: %s' ), $store->phone_no ); ?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-md-9">
            <h1><?php tse( $store->name ); ?></h1>
            <?php if( ( $rating = couponscms_rating( (int) $store->stars, $store->reviews ) ) ) {
                echo '<div class="rating"><a href="#reviews">' . $rating . '</a></div>';
            } ?>
            <hr />
            <?php echo ( !empty( $store->description ) ? '<span>' . ts( $store->description ) . '</span>' : t( 'theme_no_description', 'No description.' ) ); ?>

            <?php if( google_maps() && !empty( $locations ) ) {
            $map_zoom = get_theme_option( 'map_zoom' );
            $map_marker_icon = get_theme_option( 'map_marker_icon' ); ?>
            <hr />
            <div id="map_wrapper">
                <div id="map_canvas" data-zoom="<?php echo ( !empty( $map_zoom ) && is_numeric( $map_zoom ) ? (int) $map_zoom : 16 ); ?>" data-lat="<?php echo $locations[0]->lat; ?>" data-lng="<?php echo $locations[0]->lng; ?>" data-marker-icon="<?php echo ( !empty( $map_marker_icon ) ? $map_marker_icon : THEME_LOCATION . '/assets/img/pin.png' ); ?>"></div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php echo do_action( 'store_reviews_after_info' ); ?>

<section class="items-list bg-gray" id="reviews">

<?php

echo '<h2>' . t( 'reviews', 'Reviews' ) . '</h2>
<div class="container">
<div class="row">
<div class="col-md-12">';

echo do_action( 'store_reviews_before_items' );

if( ( $results = have_items() ) ) {
    foreach( items( array( 'orderby' => 'date desc' ) ) as $item ) {
        echo couponscms_review_item( $item );
    }
    echo couponscms_theme_pagination( $results );
} else {
    echo '<div class="alert">' . sprintf( t( 'theme_no_reviews_store',  '%s has no reviews yet.' ), ts( $store->name ) ) . '</div>';
}

echo do_action( 'store_reviews_after_items' ); ?>

</div>
</div>
</div>
</section>

<?php if( me() ) { ?>

<section class="items-list" id="add_view">

<h2><?php te( 'theme_add_review', 'Add Review' ); ?></h2>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo write_review_form(); ?>
        </div>
    </div>
</div>

</section>

<?php } ?>