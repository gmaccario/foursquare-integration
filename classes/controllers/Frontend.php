<?php

namespace FSI\Controller\Classes;

use FSI\General\Classes\Common;
use FSI\Foursquare\Classes\FoursquareWrapper;

if(!interface_exists('FSI\Controllers\Classes\iFrontend'))
{
    interface iFrontend
    {
        /* GENERAL SET */
        public function setFoursquareWrapper(FoursquareWrapper $foursquareWrapper) : void;
        
        /* TEMPLATING */
        public function foursquare_integration() : ?string;
        
        /* APIs */
        public function foursquare_results() : void;
    }
}

if(!class_exists('\FSI\Controllers\Classes\Frontend'))
{
    /**
     * @name Frontend
     * @description Generic class for the Frontend controller
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
    class Frontend extends Controller implements iFrontend
	{
        protected $foursquareWrapper;
        
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
		 * @name setFoursquareWrapper
		 *
		 * @param Common $common
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function setFoursquareWrapper(FoursquareWrapper $foursquareWrapper) : void
		{
		    $this->foursquareWrapper = $foursquareWrapper;
		}
		
		/**
		 * foursquare_integration
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * 
		 * Place a return if the function is a shortcode function: https://codex.wordpress.org/Shortcode_API
		 * 
		 * The return value of a shortcode handler function is inserted into the post content output in place of the shortcode macro. 
		 * Remember to use return and not echo - anything that is echoed will be output to the browser, but it won't appear 
		 * in the correct place on the page.
		 * 
		 * @return ?string
		 * 
		 */
		public function foursquare_integration() : ?string
		{
			/* @note Use "return" if this is the result of a shortcode call */
		    return $this->common->renderView($this, 'foursquare_integration', $this->params);
		}
		
		/**
		 * foursquare_results
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 *
		 * @return void
		 *
		 */
		public function foursquare_results() : void
		{
		    echo $this->foursquareWrapper->executePost();
		    
		    wp_die();
		}
	}
}