<div class="page-intro">
    <div class="page-intro-content">
        <h1><?php te( 'theme_login_title', 'Login' ); ?></h1>
    </div>
</div>

<div class="container pt100 pb100">

<div class="row bgGray pt50 pb50">

    <div class="col-md-6 mb20-m">
        <?php echo login_form( tlink( 'user/account' ) ); ?>

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
            <h3><?php te( 'theme_forgot_password', 'Forgot your password ?' ); ?></h3>
            <?php echo sprintf( t( 'theme_password_recovery_link', '<a href="%s">Click here</a> to reset your password' ), tlink( 'tpage/password-recovery' ) ); ?>
        </div>
        <div class="nice-info">
            <h3>Don't have an account?</h3>
            <?php echo sprintf( '<a href="%s">Click here</a> to create your account', tlink( 'tpage/register' ) ); ?>
        </div>
    </div>

</div>

</div>