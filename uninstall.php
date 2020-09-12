<?php
/* die when the file is called directly */
if ( !defined( 'WP_UNINSTALL_PLUGIN' )) 
{
    die;
}

include('include/constants.php');

delete_option( FOURSQUARE_INTEGRATION_OPT_CLIENT_ID );
delete_option( FOURSQUARE_INTEGRATION_OPT_SECRET_KEY );