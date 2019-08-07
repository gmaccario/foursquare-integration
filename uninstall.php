<?php
/* die when the file is called directly */
if ( !defined( 'WP_UNINSTALL_PLUGIN' )) 
{
    die;
}

delete_option( FOURSQUARE_INTEGRATION_OPT_DEBUG );