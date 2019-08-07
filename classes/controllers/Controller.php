<?php

namespace FSI\Controller\Classes;

use FSI\General\Classes\Basic;
use FSI\General\Classes\Common;

if(!interface_exists('FSI\Controller\Classes\iController'))
{
    interface iController
    {
        public function getCommon() : Common;
        public function renderTemplate(iController $side, string $template = '') : ?string;
    }
}

if(!class_exists('\FSI\Controllers\Classes\Controller'))
{
    /**
     * @name Controller
     * @description Generic class for the Controller
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
    class Controller extends Basic implements iController
	{		
		protected $common;
		
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
			$this->common = $common;
		}
		
		/**
		 * @name getCommon
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return Common
		 */
		public function getCommon() : Common
		{   
		    return $this->common;
		}

		/**
		 * @name renderTemplate
		 *
		 * @param iController $side
		 * @param string $template
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * 
		 * @return ?string
		 */
		public function renderTemplate(iController $side, string $template = '') : ?string
		{
		    if($template == '')
		    {
		        throw new \Exception('Please, set a new template inside the config file and use it.');
		    } else {
		        
		        return $this->common->renderView($side, $template, $this->params);
		    }
		}
    }
}