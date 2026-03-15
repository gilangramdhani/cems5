<?php
define('PHP_BOLT_KEY', 'krakatauposcoenergy');
$contents = file_get_contents( 'klhksusulan.php' );
$re = '/\<\?php/m';
preg_match($re, $contents, $matches ); 
if(!empty($matches[0]) ){
    $contents = preg_replace( $re, '', $contents );
    ##!!!##';
}
$encrypt = bolt_encrypt($contents, PHP_BOLT_KEY);
echo $encrypt;