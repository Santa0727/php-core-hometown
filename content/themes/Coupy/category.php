<?php

$category = the_item();

$atts = array();
if( !empty( $_GET['active'] ) ) {
    $atts['active'] = true;
}

have_items( $atts );

$type = searched_type();

?>

<div class="page-intro">
    <div class="page-intro-content">
        <h1><?php tse( $category->name ); ?></h1>
        <?php $types = array();
        $types['coupons'] = array( 'label' => t( 'coupons', 'Coupons' ), 'url' => get_update( array( 'type' => 'coupons' ), get_remove( array( 'page', 'type', 'cid', 'pid' ) ) ) );
        if( couponscms_has_products() ) {
            $types['products'] = array( 'label' => t( 'products', 'Products' ), 'url' => get_update( array( 'type' => 'products' ), get_remove( array( 'page', 'type', 'cid', 'pid' ) ) ) );
        }
        $types['stores'] = array( 'label' => t( 'stores', 'Stores' ), 'url' => get_update( array( 'type' => 'stores' ), get_remove( array( 'page', 'type', 'cid', 'pid' ) ) ) );
        ?>
        <ul class="button-set">
            <?php foreach( $types as $type_id => $type_nav ) {
                echo '<li' . ( $type_id == $type ? ' class="selected"' : '' ) . '><a href="' . $type_nav['url'] . '">' . $type_nav['label'] . '</a></li>';
            } ?>
        </ul>
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

        echo '<div class="alert">' . t( 'theme_no_products_category',  'No products in this category.' ) . '</div>';

        echo '<div class="row">';
        foreach( products_custom( array( 'show' => ',active', 'orderby' => 'rand', 'max' => option( 'items_per_page' ) ) ) as $item ) {
            echo couponscms_product_item( $item );
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

        echo '<div class="alert">' . t( 'theme_no_stores_category',  'No stores in this category.' ) . '</div>';

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

        echo '<div class="alert">' . t( 'theme_no_coupons_category',  'No coupons in this category.' ) . '</div>';

        echo '<div class="row">';
        foreach( items_custom( array( 'show' => ',active', 'orderby' => 'rand', 'max' => option( 'items_per_page' ) ) ) as $item ) {
            echo couponscms_coupon_item( $item );
        }
        echo '</div>';

    }

} ?>

</div>