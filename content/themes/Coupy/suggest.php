<div class="page-intro">
    <div class="page-intro-content">
        <h1><?php te( 'theme_submit_coupons', 'Submit Coupons' ); ?></h1>
    </div>
</div>

<div class="container">

<div class="row pt50 pb50">

    <div class="col-md-8 bgGray col-md-offset-2 pt50 pb50 mb50">
        <ul class="submit_coupons_steps">
            <?php if( me() ) { ?>
            <li class="checked"><span><i class="fa fa-check"></i></span> <?php te( 'theme_login_step_suggest', 'Sign In' ); ?></li>
            <?php } else { ?>
            <li><span><i class="fa fa-close"></i></span> <a href="<?php echo tlink( 'tpage/login' ); ?>"><?php te( 'theme_login_step_suggest', 'Sign In' ); ?></a></li>
            <?php }
            if( is_store_owner() ) { ?>
            <li class="checked"><span><i class="fa fa-check"></i></span> <?php te( 'theme_add_your_store', 'Add Your Store' ); ?></li>
            <li><span><i class="fa fa-plus"></i></span> <a href="<?php echo get_update( array( 'action' => 'add-coupon' ), tlink( 'user/account' ) ); ?>"><?php te( 'theme_add_coupons', 'Add Coupons' ); ?></a></li>
            <?php } else {
            if( me() ) { ?>
            <li><span><i class="fa fa-close"></i></span> <a href="<?php echo get_update( array( 'action' => 'add-store' ), tlink( 'user/account' ) ); ?>"><?php te( 'theme_add_your_store', 'Add Your Store' ); ?></a></li>
            <?php } else { ?>
            <li><span><i class="fa fa-close"></i></span> <?php te( 'theme_add_your_store', 'Add Your Store' ); ?></li>
            <?php } ?>
            <li><span><i class="fa fa-close"></i></span> <?php te( 'theme_add_coupons', 'Add Coupons' ); ?></li>
            <?php } ?>
        </ul>
    </div>

    <div class="col-md-8 col-md-offset-2 mb30" id="suggest">
        <h2><?php te( 'theme_or_suggest_store', 'Or suggest a store' ); ?></h2>
    </div>

    <div class="col-md-8 bgGray col-md-offset-2 pt50 pb50">
        <?php echo suggest_store_form( array('intent' => ( me() ? 1 : 2 ) ) ); ?>
    </div>

</div>

</div>