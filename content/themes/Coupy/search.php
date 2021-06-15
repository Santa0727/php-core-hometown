<?php

$atts = array();
if( !empty( $_GET['active'] ) ) {
    $atts['active'] = true;
}

$search_in_category = false;

if( !empty( $_GET['category'] ) ) {
    if( category_exists( $_GET['category'] ) ) {
        list( $search_in_category, $category_info ) = array( true, category_info( $_GET['category'] ) );
        $atts['category'] = $_GET['category'];
    }
}
if ( !empty( $_GET['city']) ) {
    $atts = ['city' => $_GET['city']];
}

have_items( $atts );

$type = searched_type();

?>

<div class="page-intro">
    <div class="page-intro-content">
        <h1><?php if( $search_in_category ) {
                echo sprintf( t( 'theme_results_for_in', 'Results for "%s" in %s' ), searched(), $category_info->name );
            } else {
                echo sprintf( t( 'theme_results_for', 'Results for "%s"' ), searched() );
            } ?></h1>
        <?php $types = array();
        $types['coupons'] = array( 'label' => t( 'coupons', 'Coupons' ), 'url' => get_update( array( 'type' => 'coupons' ), get_remove( array( 'page', 'type', 'cid', 'pid' ) ) ) );
        if( couponscms_has_products() ) {
            $types['products'] = array( 'label' => t( 'products', 'Products' ), 'url' => get_update( array( 'type' => 'products' ), get_remove( array( 'page', 'type', 'cid', 'pid' ) ) ) );
        }
        $types['stores'] = array( 'label' => t( 'stores', 'Stores' ), 'url' => get_update( array( 'type' => 'stores' ), get_remove( array( 'page', 'type', 'cid', 'pid' ) ) ) );
        if( couponscms_has_local_stores() ) {
            $types['locations'] = array( 'label' => t( 'theme_stores_by_location', 'Stores By Location' ), 'url' => get_update( array( 'type' => 'locations' ), get_remove( array( 'page', 'type', 'cid', 'pid' ) ) ) );
        } ?>
        <ul class="button-set">
            <?php foreach( $types as $type_id => $type_nav ) {
                echo '<li' . ( $type_id == $type ? ' class="selected"' : '' ) . '><a href="' . $type_nav['url'] . '">' . $type_nav['label'] . '</a></li>';
            } ?>
        </ul>
    </div>
</div>

<div class="bg-gray">
    <div class="container pt25 pb25">
        <div class="row search-results-row">
            <div class="col-sm-6 text-center-m">
                <?php echo sprintf( t( 'theme_results_found', '%s results found' ), results() ); ?>
            </div>
            <?php if( results() && ( $type != 'stores' && $type != 'locations' ) ) { ?>
            <div class="col-sm-6 text-right text-center-m">
                <input type="checkbox" name="active" id="active" class="checkbox" data-href="<?php echo ( !empty( $_GET['active'] ) ? get_remove( array( 'page', 'active' ) ) : get_update( array( 'active' => 1 ), get_remove( array( 'page', 'cid', 'pid' ) ) ) ); ?>"<?php echo ( !empty( $_GET['active'] ) ? ' checked' : '' ); ?>> <label for="active"><?php te( 'theme_show_active_only', 'Active only' ); ?></label>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="container pt50 pb50">
<?php if( $type === 'products' ) {

    if( results() ) {

        echo '<div class="row">';
        foreach( items( ( $atts + array( 'orderby' => 'date desc' ) ) ) as $item ) {
            echo couponscms_product_item( $item );
        }
        echo '</div>';

        echo couponscms_theme_pagination( navigation() );

    } else {

        echo '<div class="alert">' . t( 'theme_no_products_found',  'No products found.' ) . '</div>';

        echo '<div class="row">';
        foreach( products_custom( array( 'show' => ',active', 'orderby' => 'rand', 'max' => option( 'items_per_page' ) ) ) as $item ) {
            echo couponscms_product_item( $item );
        }
        echo '</div>';

    }

} else if( $type === 'locations' ) {

    if( results() ) {

        echo '<div class="row">';
        foreach( items( array( 'orderby' => 'date desc' ) ) as $item ) {
            echo couponscms_store_item( $item );
        }
        echo '</div>';

        echo couponscms_theme_pagination( navigation() );

    } else {

        echo '<div class="alert">' . t( 'theme_no_stores_found',  'No stores found.' ) . '</div>';

        echo '<div class="row">';
        foreach( stores_custom( array( 'show' => ',active', 'orderby' => 'rand', 'max' => option( 'items_per_page' ) ) ) as $item ) {
            echo couponscms_store_item( $item );
        }
        echo '</div>';

    }

} else if( $type === 'city' ) {
    if( results() ) {
        echo '<div class="row">';
        foreach( items( array( 'orderby' => 'date desc', 'city' => $atts['city'] ) ) as $item ) {
            echo couponscms_store_item( $item );
        }
        echo '</div>';

        echo couponscms_theme_pagination( navigation() );

    } else {

        echo '<div class="alert">' . t( 'theme_no_stores_found',  'No stores found.' ) . '</div>';

        echo '<div class="row">';
        foreach( stores_custom( array( 'show' => ',active', 'orderby' => 'rand', 'max' => option( 'items_per_page' ) ) ) as $item ) {
            echo couponscms_store_item( $item );
        }
        echo '</div>';

    }

} else if( $type === 'stores' ) {

    if( results() ) {

        echo '<div class="row">';
        foreach( items( array( 'orderby' => 'date desc' ) ) as $item ) {
            echo couponscms_store_item( $item );
        }
        echo '</div>';

        echo couponscms_theme_pagination( navigation() );

    } else {

        echo '<div class="alert">' . t( 'theme_no_stores_found',  'No stores found.' ) . '</div>';

        echo '<div class="row">';
        foreach( stores_custom( array( 'show' => ',active', 'orderby' => 'rand', 'max' => option( 'items_per_page' ) ) ) as $item ) {
            echo couponscms_store_item( $item );
        }
        echo '</div>';

    }

} else {

    if( results() ) {

        echo '<div class="row">';
        foreach( items( ( $atts + array( 'orderby' => 'date desc' ) ) ) as $item ) {
            echo couponscms_coupon_item( $item );
        }
        echo '</div>';

        echo couponscms_theme_pagination( navigation() );

    } else {

        echo '<div class="alert">' . t( 'theme_no_coupons_found',  'No coupons found.' ) . '</div>';

        echo '<div class="row">';
        foreach( items_custom( array( 'show' => ',active', 'orderby' => 'rand', 'max' => option( 'items_per_page' ) ) ) as $item ) {
            echo couponscms_coupon_item( $item );
        }
        echo '</div>';

    }

} ?>

</div>