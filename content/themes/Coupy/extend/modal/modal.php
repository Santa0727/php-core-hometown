<?php

if( $_SERVER['REQUEST_METHOD'] == 'GET' && !this_is_user_section() ) {

    if( isset( $_GET['cid'] ) ) {
        require_once 'coupon.php';
    }

}