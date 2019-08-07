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
			    $this->params['value_debug'] = get_option( FOURSQUARE_INTEGRATION_OPT_DEBUG );
			    
			} else {
				
				/*
				 * GET VALUES FROM POST
				 * *********************************************
				 */
				$this->params['value_debug'] = filter_input( INPUT_POST, FOURSQUARE_INTEGRATION_OPT_DEBUG, FILTER_SANITIZE_NUMBER_INT );
				
				/*
				 * UPDATE NEW VALUES
				 * *********************************************
				 */
				update_option( FOURSQUARE_INTEGRATION_OPT_DEBUG, $this->params['value_debug'] );
			}
			
			/*
			 * INCLUDE FORM
			 */
			$this->renderTemplate($this, 'configuration');
		}
	}
}