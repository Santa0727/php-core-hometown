<?php

$store = the_item();

$atts = array();
if( !empty( $_GET['active'] ) ) {
    $atts[] = 'active';
}

$type = searched_type();
function map_url($lat, $lng) {
    return 'https://www.google.com/maps/@'.number_format($lat, 7, ".", "").','.number_format($lng, 7, ".", "").',19z';
}

?>

<style>
@media only screen and (min-width: 600px) {
    .info-lr {
        justify-content: space-between;
        display: flex;
    }
}
    .info-lr h1, .info-lr p {
        white-space: normal !important;
        word-break: break-word;
    }
    .info-r {
        display: flex;
        align-items: center;
        flex-direction: column;
        align-content: center;
        padding: 3% 10px 3% 10px;
    }
</style>

<?php echo do_action( 'store_before_info' ); ?>

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
                <h4><?php echo $store->name;?></h4>
                <?php
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
                                <a style="color: darkcyan;" target="blank" href="'.map_url($location->lat, $location->lng).'" data-map-recenter="' . $location->lat . ',' . $location->lng . '">
                                    ' . $location->address . '
                                </a>
                            </li>';
                            echo '<li data-lat="' . $location->lat . '" data-lng="' . $location->lng . '" data-title="' . implode( ', ', array( $location->city, $location->state ) ) . '" data-content="' . implode( ', ', array( $location->address, $location->zip ) ) . '">
                                <a style="color: darkcyan;" target="blank" href="'.map_url($location->lat, $location->lng).'" data-map-recenter="' . $location->lat . ',' . $location->lng . '">
                                    ' . $location->city.', '.strtoupper(substr($location->state, 0, 2)).' '.$location->zip . '
                                </a>
                            </li>';
                        }
                        echo '</ul></li>';
                    }
                } ?>
                <?php if( !empty( $store->phone_no ) ) { ?>
                <li><i class="fa fa-phone"></i> <?php echo $store->phone_no; ?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="info-lr row">
                <div class="info-l col-md-9">
                    <h1><?php tse( $store->name ); ?></h1>
                    <?php if( ( $rating = couponscms_rating( (int) $store->stars, $store->reviews ) ) ) {
                        echo '<div class="rating"><a href="' . $store->reviews_link . '#reviews">' . $rating . '</a></div>';
                    } ?>
                    <hr />
                    <p>
                        <?php echo ( !empty( $store->description ) ? '<span>' . tse( $store->description ) . '</span>' : t( 'theme_no_description', 'No description.' ) ); ?>
                    </p>

                    <?php if( google_maps() && !empty( $locations ) ) {
                    $map_zoom = get_theme_option( 'map_zoom' );
                    $map_marker_icon = get_theme_option( 'map_marker_icon' ); ?>
                    <hr />
                    <div id="map_wrapper">
                        <div id="map_canvas" data-zoom="<?php echo ( !empty( $map_zoom ) && is_numeric( $map_zoom ) ? (int) $map_zoom : 16 ); ?>" data-lat="<?php echo $locations[0]->lat; ?>" data-lng="<?php echo $locations[0]->lng; ?>" data-marker-icon="<?php echo ( !empty( $map_marker_icon ) ? $map_marker_icon : THEME_LOCATION . '/assets/img/pin.png' ); ?>"></div>
                    </div>
                    <?php } ?>
                </div>
                <div class="info-r col-md-3">
                    <ul class="links-list">
                        <?php if( $type === 'coupons' ) { ?>       
                        <li><a href="<?php echo get_update( array( 'type' => 'products' ), get_remove( array( 'page', 'type', 'cid', 'pid' ) ) ); ?>"><i class="fa fa-shopping-bag"></i> <?php te( 'theme_view_products', 'View Products' ); ?></a></li>
                        <?php } else { ?>
                        <li><a href="<?php echo get_update( array( 'type' => 'coupons' ), get_remove( array( 'page', 'type', 'cid', 'pid' ) ) ); ?>"><i class="fa fa-tags"></i> <?php te( 'theme_view_coupons', 'View Coupons' ); ?></a></li>
                        <?php } ?>
                        <li><a href="<?php echo ( me() ? $store->reviews_link . '#add_view' : tlink( 'tpage/login' ) ); ?>"><i class="fa fa-pencil"></i> <?php te( 'theme_add_review', 'Add Review' ); ?></a></li>
                        <?php if( !empty( $store->url ) ) { ?>
                        <li><a href="<?=$store->url;?>"><i class="fa fa-external-link"></i> <?php te( 'theme_store_visit', 'Visit Website' ); ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo do_action( 'store_after_info' ); ?>

<section class="items-list bg-gray">

<?php if( $type === 'products' ) {

    echo '<h2>' . t( 'products', 'Products' ) . '</h2>
    <div class="container">';

    echo do_action( 'store_before_items' );

    if( ( $results = have_products( array( 'show' => ( !empty( $atts ) ? implode( ',', $atts ) : '' ) ) ) ) && $results['results'] ) {

        echo '<div class="row">';
        foreach( products( array( 'show' => ( !empty( $atts ) ? implode( ',', $atts ) : '' ), 'orderby' => 'date desc' ) ) as $item ) {
            echo couponscms_product_item( $item );
        }
        echo '</div>';
        echo couponscms_theme_pagination( $results );

    } else {

        echo '<div class="alert">' . sprintf( t( 'theme_no_products_store',  '%s has no products yet.' ), ts( $store->name ) ) . '</div>';

        echo '<div class="row">';
        foreach( products_custom( array( 'show' => ',active', 'orderby' => 'rand', 'max' => option( 'items_per_page' ) ) ) as $item ) {
            echo couponscms_product_item( $item );
        }
        echo '</div>';
    }

} else {

    echo '<h2>' . t( 'coupons', 'Coupons' ) . '</h2>
    <div class="container">';

    echo do_action( 'store_before_items' );

    if( ( $results = have_items( array( 'show' => ( !empty( $atts ) ? implode( ',', $atts ) : '' ) ) ) ) && $results['results'] ) {

        echo '<div class="row">';
        foreach( items( array( 'show' => ( !empty( $atts ) ? implode( ',', $atts ) : '' ), 'orderby' => 'date desc' ) ) as $item ) {
            echo couponscms_coupon_item( $item );
        }
        echo '</div>';
        echo couponscms_theme_pagination( $results );

    } else {

        echo '<div class="alert">' . sprintf( t( 'theme_no_coupons_store',  '%s has no coupons yet.' ), ts( $store->name ) ) . '</div>';

        echo '<div class="row">';
        foreach( items_custom( array( 'show' => ',active', 'orderby' => 'rand', 'max' => option( 'items_per_page' ) ) ) as $item ) {
            echo couponscms_coupon_item( $item );
        }
        echo '</div>';
    }

}

echo do_action( 'store_after_items' ); ?>

</div>
</section>
