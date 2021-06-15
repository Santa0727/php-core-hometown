$( document ).ready(function() {

$( document ).on( 'click', 'body', function() {
    $( '[data-opened]' ).slideUp( 'fast' );
});

$( '.category-select > a' ).on( 'click', function( e ) {
    e.preventDefault();
    e.stopPropagation();
    var t = $(this);
    var list = t.nextAll( 'ul' );
    if( list.is(':visible') ) {
        list.slideUp( 'fast' ).removeAttr( 'data-opened' );
    } else {
        list.slideDown( 'fast' ).attr( 'data-opened', '' );
    }
});

$( '.category-select li > a' ).on( 'click', function( e ) {
    e.preventDefault();
    e.stopPropagation();
    var t = $(this);
    var val = t.data( 'attr' ),
    list = t.parents( 'ul' )
    a = list.prevAll( 'a' ).find( 'span' ),
    input = list.prevAll( 'input' );
    a.text( t.text() );
    input.val( val );
    list.slideUp( 'fast' ).removeAttr( 'data-opened' );

});

$( '.owl-carousel' ).each( function() {
    var t = $(this);
    t.owlCarousel({
        loop:( t.data( 'loop' ) != undefined ? true : false ),
        margin:0,
        padding:15,
        autoplay:( t.data( 'autoplay' ) != undefined ? true : false ),
        nav:( t.data( 'arrows' ) != undefined ? true : false ),
        dots:( t.data( 'bullets' ) != undefined ? true : false ),
        navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:false
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
});

$( '.user-sub-menu > a' ).on( 'click', function( e ) {
    e.preventDefault();
    var ul = $(this).next( 'ul' );
    var menu = $(this).parents( '.user-menu' );
    if( ul.is( ':visible' ) ) {
        ul.slideUp( 'fast' );
    } else {
        menu.find( '.user-sub-menu > ul:visible' ).slideUp();
        ul.slideDown( 'fast' );
    }
});

$( '.mmenu' ).on( 'click', function() {
    var t = $(this);
    var menu = $( '.main-nav' );
    t.toggleClass( 'open' );
    if( menu.is( ':visible' ) ) {
        menu.slideUp();
    } else {
        menu.slideDown();
    }
});

$( window ).resize(function(){
    if( $( window ).width() > 768 ) {
        var mmenu = $( '.mmenu' );
        var menu = $( '.main-nav' );
        mmenu.removeClass( 'open' );
        menu.removeAttr( 'style' );
    }
}).resize();

$( '.list-item .sub-info a.share' ).on( 'click', function( e ) {
    e.preventDefault();
    var ul = $(this).prev( 'ul' );
    if( ul.is( ':visible' ) ) {
        ul.fadeOut( 'fast' );
    } else {
        ul.fadeIn( 'fast' ).css( 'display', 'inline-block' );
    }
});

$( '.store-single .links-list a.hours' ).on( 'click', function( e ) {
    e.preventDefault();
    var ul = $(this).next( 'ul' );
    if( ul.is( ':visible' ) ) {
        ul.fadeOut( 'fast' );
    } else {
        ul.fadeIn( 'fast' );
    }
});

$( '.question > a' ).on( 'click', function( e ) {
    e.preventDefault();
    var answer = $(this).next( '.answer' );
    if( answer.is( ':visible' ) ) {
        answer.slideUp( 'fast' );
    } else {
        answer.slideDown( 'fast' );
    }
});

$('#city-button-select > a').on('click', function(e) {
    $('.my-item-box.category-buttons').fadeOut(1);
    $('.my-item-box.city-buttons').fadeIn(300);
});

$('#category-button-select > a').on('click', function(e) {
    $('.my-item-box.city-buttons').fadeOut(1);
    $('.my-item-box.category-buttons').fadeIn(300);
});

$('.homepage-search-form .search-input input').on('focus', function(e) {
    e.preventDefault();
    $( 'input[class="h-search"]' ).blur();
    $( 'body' ).addClass( 'search-popup-active' );
    $( '#search-popup' ).fadeIn( 300 );
});

$('.category-select.my-item-button > a').on('click', function(e) {
    e.preventDefault();
    window.location = $(this).attr('href');
});
$(document).ready(function() {
    $('.my-item-box').fadeOut(1);
});

$( '[data-href]' ).on( 'change', function() {
    window.location = $(this).data( 'href' );
});

$( '[data-tooltip]' ).tooltip();

$( '.search-container .search-input input[name="s"]' ).focus( function( e ) {
    var t = $( this );
    var sels = t.parents( 'form' ).find( '.sc-select:not(.my-item-box)' );
    $( this ).on( 'keypress', function() {
        sels.fadeIn( 300 );
    });
    $('.my-item-box').fadeOut( 300 );
}).blur( function( e ) {
    var t = $( this );
    if( t.val() == '' ) {
        // t.parents( 'form' ).find( '.sc-select' ).fadeOut( 300 );
    }
});

$( '[href="#search"]' ).on( 'click', function( e ) {
    e.preventDefault();
    $( 'body' ).addClass( 'search-popup-active' );
    $( '#search-popup' ).fadeIn( 300 );
});

$( 'input[class="h-search"]' ).focus( function( e ) {
    $( this ).blur();
    $( 'body' ).addClass( 'search-popup-active' );
    $( '#search-popup' ).fadeIn( 300 );
});

$( '.header-search' ).focus( function( e ) {
    $( this ).blur();
    $( 'body' ).addClass( 'search-popup-active' );
    $( '#search-popup' ).fadeIn( 300 );
});

$( '[href="#close-search-popup"]' ).on( 'click', function( e ) {
    e.preventDefault();
    $( 'body' ).removeClass( 'search-popup-active' );
    $( '#search-popup' ).fadeOut( 300 );
});

$( '[data-copy-this]' ).on( 'click', function( e ) {
    e.preventDefault();
    var t = $(this);
    t.nextAll( 'input' ).focus().select();
    document.execCommand( 'copy' );
    t.nextAll( 'input' ).blur();
    t.html( t.data( 'copied' ) );
});

$( '[data-target-on-click]' ).on( 'click', function() {
    var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    if( isSafari ) {
        $(this).removeAttr( 'target' );
    }
    window.location = $(this).data( 'target-on-click' );
});

var modal = setInterval( function(){
    $('.modal').modal( 'show' );
    clearInterval( modal );
}, 300 );

$( '.button-disabled' ).on( 'click', function(e) {
    e.preventDefault();
});

$(document).on('click', '[data-code]', function(e){
    e.preventDefault();
    var t = $(this);
    if( !t.hasClass('disabled') ) {
        t.addClass('disabled');
        t.find('span').text( t.data('code') );
        t.parents('.coupon').addClass('code-revealed');
    }
});

/* COUPONS CMS */

$( '.claim_reward_form form button' ).on( 'click', function(e) {
    var t = $(this);

    if( t.prevAll( '.extra_form' ).html() != 'undefied' && t.prevAll( '.extra_form' ).is( ':hidden' ) ) {
        e.preventDefault();
        t.prevAll( '.extra_form' ).slideDown();
    }
});

});