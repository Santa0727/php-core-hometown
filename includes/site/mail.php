<?php

namespace site;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/** */

class mail {

    public static function send( $to, $subject, $params = array(), $vars = array() ) {

        if( empty( $params['template'] ) ) {
            if( empty( $params['message'] ) )
                return false;
            else {
                $text = $params['message'];
            }
        } else {

            $template = value_with_filter( 'email_template_' . $params['template'], ( isset( $params['path'] ) ? $params['path'] : '' ) . TMAIL_LOCATION . '/' . $params['template'] . '.html' );

            if( !file_exists( $template ) ) {
                return false;
            }

            $text = file_get_contents( $template );
            $text = str_replace( array_map( function( $k ) {
                return '$' . $k;
            }, array_keys( $vars ) ), array_values( $vars ), $text );

        }

        require_once DIR . '/' . LBDIR . '/PHPMailer/PHPMailerAutoload.php';

        $mail               = new \PHPMailer();
        $mail->CharSet      = 'UTF-8';
        $mail->setFrom( ( isset( $params['from_email'] ) ? $params['from_email'] : \query\main::get_option( 'email_answer_to' ) ), ( isset( $params['from_name'] ) ? $params['from_name'] : \query\main::get_option( 'email_from_name' ) ) );
        $mail->addReplyTo( ( isset( $params['reply_to'] ) ? $params['reply_to'] : \query\main::get_option( 'email_answer_to' ) ), ( isset( $params['reply_name'] ) ? $params['reply_name'] : '' ) );
        $mail->addAddress( $to );
        $mail->Subject      = $subject;
        $mail->Body         = $text;
        $mail->IsHTML( true );

        switch( \query\main::get_option( 'mail_method' ) ) {

        case 'SMTP':

            $mail->IsSMTP(); // tell the class to use SMTP
            $mail->SMTPAuth = true;
            $mail->Port     = 465;
            $mail->Host     = "Smtp.gmail.com";
            $mail->Username = "offers@hometownoc.com";
            $mail->Password = "uLine55!";
            $mail->SMTPAutoTLS = false;
            $mail->SMTPSecure = "ssl";
            $mail->SMTPOptions = array (
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true)
            );

        break;

        case 'sendmail':

            $mail->isSendmail();
            $mail->Sendmail = \query\main::get_option( 'sendmail_path' );

        break;

        default:

            $mail->isMail();

        break;

        }

        if( $mail->Send() ) return true;
        else return false;

    }

}