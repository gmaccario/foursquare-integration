<?php

namespace FSI\Controller\Classes;

use FSI\General\Classes\Common;

if(!interface_exists('FSI\Controllers\Classes\iFrontend'))
{
    interface iFrontend
    {
        public function default_template() : ?string;
        public function echo_foo() : void;
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
		 * default_template
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * 
		 * Placxe a return if the function is a shortcode function: https://codex.wordpress.org/Shortcode_API
		 * 
		 * The return value of a shortcode handler function is inserted into the post content output in place of the shortcode macro. 
		 * Remember to use return and not echo - anything that is echoed will be output to the browser, but it won't appear 
		 * in the correct place on the page.
		 * 
		 * @return ?string
		 * 
		 */
		public function default_template() : ?string
		{
			/* @note Use "return" if this is the result of a shortcode call */
		    return $this->common->renderView($this, 'default_template', $this->params);
		}
		
		/**
		 * echo_foo
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * 
		 * @return void 
		 *
		 */
		public function echo_foo() : void 
		{
			wp_send_json( array( 'results' => array( 'success' => 'Congratulations! It\'s working!' ) ));
			
			wp_die();
		}
	}
}