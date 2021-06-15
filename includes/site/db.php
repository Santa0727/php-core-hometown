<?php
 
if( class_exists( 'mysqli' ) )
$db = @new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );