<?php

if( isset( $_GET['token'] ) && isset( $_POST['login'] ) && check_ajax_token( 'login', $_GET['token'] ) ) {

    $response = array();

    $pd = \site\utils::validate_user_data( $_POST['login'] );

    try {

        $session = \user\main::login( $pd );

        $_SESSION['session'] = $session;

        $response['state'] = 'success';
        $response['message'] = t( 'login_success', "You have successfully logged in." );
        $response['session'] = $GLOBALS['siteURL'] . 'setSession.php' . ( isset( $_POST['back'] ) ? '?back=' . esc_html( $_POST['back'] ) : '' );

    }

    catch( Exception $e ){
        $response['state'] = 'error';
        $response['message'] = $e->getMessage();
    }

    echo json_encode( $response );

    die;

}

echo json_encode( array( 'state' => 'error', 'message' => t( 'unexpected', 'Unexpected' ) ) );