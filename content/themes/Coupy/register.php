<div class="page-intro">
    <div class="page-intro-content">
        <h1><?php te( 'theme_register_title', 'Register' ); ?></h1>
    </div>
</div>

<div class="container pt100 pb100">

<div class="row bgGray pt50 pb50">

    <div class="col-md-6 mb20-m">
        <?php echo register_form( tlink( 'user/account' ) ); ?>

        <?php if( ( $facebook_login = facebook_login() ) || google_login() ) { ?>

            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="nicehr"></div>
                    <?php if( $facebook_login ) { ?>
                      <a href="<?php echo tlink( 'plugin/facebook_login' ); ?>" class="butt icon-border"><?php te( 'theme_login_with_facebook', 'Login with Facebook' ); ?></a>
                    <?php } if( google_login() ) { ?>
                      <a href="<?php echo tlink( 'plugin/google_login' ); ?>" class="butt icon-border"><?php te( 'theme_login_with_google', 'Login with Google+' ); ?></a>
                    <?php } ?>
                </div>
            </div>

        <?php } ?>
    </div>

    <div class="col-md-6">
        <div class="nice-info">
            <h3><?php te( 'theme_already_have_account', 'Already have an account ?' ); ?></h3>
            <?php echo sprintf( t( 'theme_login_link', '<a href="%s">Click here</a> to login' ), tlink( 'tpage/login' ) ); ?>
        </div>
    </div>

</div>

</div>