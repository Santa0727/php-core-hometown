<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php echo add_head(); ?>
</head>

<body<?php echo ( ( $body_classes = body_classes() ) ? ' class="' . $body_classes . '"' : ''); ?>>

<?php require_once 'extend/modal/modal.php'; ?>

<div id="search-popup">
    <div class="search-popup-content">
        <div class="search-popup-main">
            <?php my_search_form( 'fixed-popup' ); ?>
            <div class="search-popup-links">
                <a class="close-search-popup" href="#close-search-popup"><i class="fa fa-close"></i></a>
            </div>
        </div>
    </div>
</div>

<?php if( is_maintenance_mode() ) { ?>
<div class="alert mb0"><?php te( 'theme_maintenance_mode', 'Maintenance mode is ON. This website is not visible by visitors.' ); ?></div>
<?php } ?>

<?php $tel = get_theme_option( 'contact_tel' );
$email = get_theme_option( 'contact_email' ); ?>

<div class="menu-top-links">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul class="inline-ul-list text-center-m">
                    <?php if( !empty( $tel ) ) echo '<li><i class="fa fa-phone"></i> ' . esc_html( $tel ) . '</li>';
                    if( !empty( $email ) ) echo '<li><i class="fa fa-envelope"></i> ' . esc_html( $email ) . '</li>'; ?>
                </ul>
            </div>
            <div class="col-md-6 dnone-m text-right">
                <div class="h-links">
                <?php if( ( $me = me() ) ) { ?>
                    <a href="<?php echo tlink( 'user/account' ); ?>"><i class="fa fa-user-o"></i><span><?php echo $me->Name; ?></span></a>
                <?php } else { ?>
                        <a href="<?php echo tlink( 'tpage/login' ); ?>"><i class="fa fa-unlock"></i><span><?php te( 'theme_login_button', 'Sign In' ); ?></span></a>
                        <a href="<?php echo tlink( 'tpage/register' ); ?>"><i class="fa fa-user-plus"></i><span><?php te( 'theme_register_button', 'Register' ); ?></span></a>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="menu-middle-links">
    <div class="container">
        <div class="row row-table">
            <div class="col-md-8 col-table text-center-m">
                <a href="<?php echo tlink( 'index' ); ?>">
                    <img src="<?php echo site_logo( THEME_LOCATION . '/assets/img/logo.png' ); ?>" alt="" />
                </a>
            </div>
            <div class="col-md-4 col-table text-right text-center-m dnone-m">
                <input type="text" placeholder="<?php echo t( 'theme_search_for_coupons', 'Search for coupons ...' ); ?>" class="h-search" />
            </div>
        </div>
    </div>
</div>

<?php

    // global $add_menu;
    // $custom_menu = \query\main::get_option( 'links_menu_' . $menu->id );
    // echo "<br>-------<br>";
    // echo json_encode(@unserialize( $custom_menu ));
    // echo "<br>---------<br>";
?>

<div class="main-nav-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="mobile-nav dnone dblock-m">
                        <div class="mmenu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="mobile-nav-links dnone">
                        <?php if( ( $me = me() ) ) { ?>
                            <a href="<?php echo tlink( 'user/account' ); ?>" class="button"><img src="<?php echo user_avatar( $me->Avatar ); ?>" alt="" /></a>
                        <?php } else { ?>
                            <a href="<?php echo tlink( 'tpage/login' ); ?>" class="button"><i class="fa fa-unlock"></i></a>
                            <a href="<?php echo tlink( 'tpage/register' ); ?>" class="button"><i class="fa fa-user-plus"></i></a>
                        <?php } ?>
                        </div>
                    </div>
                    <ul class="main-nav dnone-m">
                        <?php echo couponscms_menu( 'main' ); ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
