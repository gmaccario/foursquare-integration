<?php
/*
Plugin Name: Foursquare Integration
Plugin URI: 
Description: Foursquare Integration Plugin
Version: 1.0
Author: Giuseppe Maccario
Author URI: https://www.giuseppemaccario.com
License: GPL2
*/

if( defined( WP_DEBUG ) && WP_DEBUG )
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/* GENERAL CONSTANTS */
define( 'FOURSQUARE_INTEGRATION_VERSION', '1.0' );
define( 'FOURSQUARE_INTEGRATION_NAME', 'Foursquare Integration' );

/* BASIC CONSTANTS - MANDATORY HERE CAUSE __FILE__ */
define( 'FOURSQUARE_INTEGRATION_MAIN_FILE', __FILE__ );
define( 'FOURSQUARE_INTEGRATION_URL', plugins_url( '', __FILE__ ));
define( 'FOURSQUARE_INTEGRATION_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'FOURSQUARE_INTEGRATION_PATH', __DIR__ . DIRECTORY_SEPARATOR );

function foursquare_integration_init()
{
	/* DEFINE CONSTANTS	*/
	require_once FOURSQUARE_INTEGRATION_DIR_PATH . 'include' . DIRECTORY_SEPARATOR . 'constants.php';
	
	/* PSR-4: Autoloader - PHP-FIG */
	require FOURSQUARE_INTEGRATION_DIR_PATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
	
	/* DISPATCHER */
	require_once FOURSQUARE_INTEGRATION_DIR_PATH . 'include' . DIRECTORY_SEPARATOR . 'dispatcher.php';
}

/*
 * GO!
 */
foursquare_integration_init();