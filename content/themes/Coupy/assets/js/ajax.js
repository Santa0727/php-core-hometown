$( document ).ready(function() {

$( '[data-ajax-call]' ).on( 'click', function(e) {
    e.preventDefault();
    var t = $(this);
    var url = t.data( 'ajax-call' ),
    data = t.data( 'data' );

    if( t.data( 'confirmation' ) == undefined || confirm( t.data( 'confirmation' ) ) ) {
        $.post( url, data, function( result ) {
            if( t.data( 'after-ajax' ) != undefined ) {
                switch( t.data( 'after-ajax' ) ) {
                    case 'ajax_voted':
                        if( result.state != 'success' ) {
                            // alert( result.message );
                            window.location = login_page;
                        } else {
                            t.parents( '.modal-vote' ).html( '<li><span class="ajax-message">' + result.message + '</span></li>' );
                        }
                    break;
                    case 'coupon_claimed':
                        if( result.state == 'success' ) {
                            t.addClass( 'disabled' );
                            t.removeAttr( 'data-tooltip' );
                            t.html( result.message );
                        } else {
                            // alert( result.message );
                            window.location = login_page;
                        }
                    break;
                }
            } else {
                if( result.state != 'success' ) {
                    // alert( result.message );
                    window.location = login_page;
                } else {
                    t.html( result.message );
                }
            }
        }, "json" );
    }
});

$( '.subscribe_form_modal button' ).on( 'click', function(e) {
    e.preventDefault();
    var t = $(this);
    var cont = t.parents( '.subscribe_form_modal' );
    var email = cont.find( 'input' );
    var url = t.data( 'ajax-subscribe-url' ),
    data = { 'subscribe': { 'email': email.val() } };

    if( email.val() != '' ) {

    $.post( url, data, function( result ) {
        if( cont.find( '.ajax-subscribe-result' ).length > 0 ) {
            cont.find( '.ajax-subscribe-result' ).remove();
        }
        if( result.state != 'success' ) {
            cont.append( '<div class="row ajax-subscribe-result"><div class="col-md-12"><div class="msg-alert">' + result.message + '</div></div>' );
        } else {
            t.prop( 'disabled', true );
            email.prop( 'disabled', true );
            cont.append( '<div class="row ajax-subscribe-result"><div class="col-md-12"><div class="msg-success">' + result.message + '</div></div>' );
        }
    }, "json" );

    } else {
        email.focus();
    }

});

});