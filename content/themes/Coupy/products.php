<?php

$types = array();
$types['recently']      = array( 'label' => t( 'theme_products_recently_added', 'Recently Added' ),  'url' => get_remove( array( 'page', 'type', 'cid', 'pid' ) ),                                                 'orderby' => 'date desc',      'show' => 'active',         'limit' => 100 );
$types['expiring']      = array( 'label' => t( 'theme_products_expiring_soon', 'Expiring Soon' ),    'url' => get_update( array( 'type' => 'expiring' ), get_remove( array( 'page', 'type', 'cid', 'pid' ) ) ),    'orderby' => 'expiration',     'show' => 'active',         'limit' => 100 );
$types['popular']       = array( 'label' => t( 'theme_products_popular', 'Popular' ),                'url' => get_update( array( 'type' => 'popular' ), get_remove( array( 'page', 'type', 'cid', 'pid' ) ) ),     'orderby' => '',               'show' => 'active,popular', 'limit' => 100 );

$type = isset( $_GET['type'] ) && in_array( $_GET['type'], array_keys( $types ) ) ? $_GET['type'] : 'recently';

$atts = array();
$atts['show'] = $types[$type]['show'];
$atts['limit'] = $types[$type]['limit'];

$pagination = have_products_custom( $atts );

?>

<div class="page-intro">
    <div class="page-intro-content">
        <h1><?php te( 'products', 'Products' ); ?></h1>
        <ul class="button-set">
            <?php foreach( $types as $type_id => $type_nav ) {
                echo '<li' . ( $type_id == $type ? ' class="selected"' : '' ) . '><a href="' . $type_nav['url'] . '">' . $type_nav['label'] . '</a></li>';
            } ?>
        </ul>
    </div>
</div>

<div class="container pt50 pb50">

<?php if( $pagination['results'] ) {
    echo '<div class="row">';
    foreach( products_custom( ( array( 'orderby' => $types[$type]['orderby'] ) + $atts ) ) as $item ) {
        echo couponscms_product_item( $item );
    }
    echo '</div>';
    echo couponscms_theme_pagination( $pagination );

} else echo '<div class="alert">' . t( 'theme_no_products_list',  'Huh :( No products found here.' ) . '</div>'; ?>

</div>