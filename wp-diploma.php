<?php
/*
Plugin Name: WP Diploma
Plugin URI: #
Description: Generated a pdf format of downloadable diploma/certificate for user
Version: 1.0
Author: Designing Hut
Author URI: 
Text Domain: wp-diploma
Domain Path: /languages
*/


define('WP_DIPLOMA_PATH', dirname(__FILE__));
$plugin = plugin_basename(__FILE__);
define('WP_DIPLOMA_URL', plugin_dir_url($plugin));
require(WP_DIPLOMA_PATH.'/inc/wp-diploma-main.php');
require(WP_DIPLOMA_PATH.'/inc/wp-diploma-ajax.php');
// require(WP_DIPLOMA_PATH.'/templates/certificate.php');
// require WP_DIPLOMA_PATH.'/inc/special-discount-ajax.php';


// add_action('admin_print_styles', 'search_and_replace_css' );
   
// function search_and_replace_css() {
// 	//die( print plugins_url('css/style.css', __FILE__));
//     wp_enqueue_style( 'SearchAndReplaceStylesheet', plugins_url('css/style.css', __FILE__) );
//     //wp_enqueue_style( 'SearchAndReplaceStylesheet' );
// }

function returntest(){
	echo "test";
}



?>