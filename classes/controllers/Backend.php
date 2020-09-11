<?php

namespace FSI\Controller\Classes;

use FSI\General\Classes\Common;

if(!interface_exists('FSI\Controllers\Classes\iBackend'))
{
    interface iBackend
    {
        public function configuration() : void;
    }
}

if(!class_exists('\FSI\Controllers\Classes\Backend'))
{
    /**
     * @name Backend
     * @description Generic class for the Frontend Backend
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
    class Backend extends Controller implements iBackend
	{		
	    /**
		 * @name __construct
		 *
		 * @param Common $common
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
	    public function __construct(Common $common)
	    {
	        parent::__construct($common);
	    }
		
		/**
		 * @name configuration
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function configuration() : void
		{
			/*
			 * GET VALUES FROM POST
			 * *********************************************
			 */
			$this->params['action'] = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );
			
			/*
			 * UPDATE OPTIONS
			 * *********************************************
			 */
			if ( $this->params['action'] != 'update')
			{
			    /*
			     * GET FRESH VALUES FROM DB
			     * *********************************************
			     */
			    $this->params['value_client_id'] = get_option( FOURSQUARE_INTEGRATION_OPT_CLIENT_ID );
			    $this->params['value_secret_key'] = get_option( FOURSQUARE_INTEGRATION_OPT_SECRET_KEY );
			    
			} else {
				
				/*
				 * GET VALUES FROM POST
				 * *********************************************
				 */
				$this->params['value_client_id'] = filter_input( INPUT_POST, FOURSQUARE_INTEGRATION_OPT_CLIENT_ID, FILTER_SANITIZE_STRING );
				$this->params['value_secret_key'] = filter_input( INPUT_POST, FOURSQUARE_INTEGRATION_OPT_SECRET_KEY, FILTER_SANITIZE_STRING );
				
				/*
				 * UPDATE NEW VALUES
				 * *********************************************
				 */
				update_option( FOURSQUARE_INTEGRATION_OPT_CLIENT_ID, $this->params['value_client_id'] );
				update_option( FOURSQUARE_INTEGRATION_OPT_SECRET_KEY, $this->params['value_secret_key'] );
			}
			
			$this->params['available_shortcodes'] = $this->common->getConfig()['features']['frontend']['shortcodes'];
			
			/*
			 * INCLUDE FORM
			 */
			$this->renderTemplate($this, 'configuration');
		}
	}
}