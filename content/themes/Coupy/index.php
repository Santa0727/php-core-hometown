<?php echo do_action( 'index_before_search' );
couponscms_search_form();
echo do_action( 'index_after_search' ); ?>

<?php if( ( $bwft = do_action( 'before_widgets_featured_top' ) ) || ( ( $awft = do_action( 'after_widgets_featured_top' ) ) ) ) { ?>
<div class="row">
    <div class="col-md-12">
        <?php echo $bwft;
        // no widgets :(
        echo $awft; ?>
    </div>
</div>
<?php } ?>

<?php echo couponscms_home_items(); ?>

<?php if( ( $bwfb = do_action( 'before_widgets_featured_bottom' ) ) || ( ( $awfb = do_action( 'after_widgets_featured_bottom' ) ) ) ) { ?>
<div class="row">
    <div class="col-md-12 bottom-widgets">
        <?php echo $bwfb;
        // no widgets :(
        echo $awfb; ?>
    </div>
</div>
<?php } ?>

<script>
    $('.link-logo').click(function() {
        var link = $(this).attr('data-link');
        window.location.href = link;
    });
</script>