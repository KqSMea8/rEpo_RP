<?php
header("location: http://www.eznetcrm.com/blog");
exit;


if(substr_count($_SERVER['HTTP_HOST'],"www.")!=1){
	$url_red =  'http://www.eznetcrm.com/erp/eznetcrm/blog/';
	Header( "HTTP/1.1 301 Moved Permanently" );
	header("Location: ".$url_red);
	exit;
}

/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
