<?php  
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once(dirname(__FILE__) . '/database.php');  
require_once(dirname(__FILE__) . '/classes.php');

// DB properties
define ( 'DB_HOST', 'localhost' );  
define ( 'DB_USER', 'tab2' );  
define ( 'DB_PASSWORD', 'tab2013' );  
define ( 'DB_NAME', 'tab2' ); 
define ( 'HASH_ALGO', 'ripemd320');

date_default_timezone_set('Europe/Madrid');
?>
