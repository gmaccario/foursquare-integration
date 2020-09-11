<?php
namespace FSI\Setup\Classes;
use FSI\Controller\Classes\Controller;
if(!interface_exists('FSI\Setup\Classes\iLoader'))
{
    interface iLoader
    {
        public function setController(Controller $controller) : void;
        public function setControllerManager(Manager $manager) : void;
        public function loadFeatures() : void;
        /* Methods you declare in Interfaces ought to be public. */
    }
}
if(!class_exists('\FSI\Setup\Classes\Loader'))
{
    /**
     * @name Loader
     * @description Generic loader
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
    class Loader implements iLoader
	{
        protected $controller;
        protected $controllerManager;
		
		/**
		 * @name __construct
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
        public function __construct(){}
		
		/**
		 * @name setController
		 *
		 * @param Controller $controller
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setController(Controller $controller) : void
		{
		    $this->controller = $controller;
		}
		
		/**
		 * @name setControllerManager
		 *
		 * @param Manager $manager
		 * @param AjaxLoader $ajaxLoader
		 * 
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setControllerManager(Manager $manager) : void
		{
		    $this->controllerManager = $manager;
		}
		
		/**
		 * @name publicInit
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function publicInit() : void
		{
		    
		}
		
		/**
		 * @name adminInit
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function adminInit() : void
		{
		    $this->controllerManager->whenFoursquareIntegrationStart();
		}
		
		/**
		 * @name loadFeatures
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function loadFeatures() : void
		{
		    if(strtolower($this->controller->getCommon()->getNameClass($this->controller)) != 'backend')
		    {
		        $this->loadFrontendFeatures();
		    }
		    else {
		        $this->loadBackendFeatures();
		    }
		}
		
		/**
		 * @name loadBackendFeatures
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		protected function loadBackendFeatures() : void
		{
		    add_action( 'admin_init', array($this, 'adminInit'));
		    
		    add_action( 'admin_menu', array($this->controllerManager, 'backendMenu'));
		    add_action( 'admin_enqueue_scripts', array($this->controllerManager, 'backendEnqueue'));
		    
		    add_filter( 'plugin_action_links_' . FOURSQUARE_INTEGRATION_BASENAME, array($this->controllerManager, 'customActionLinks' ));
		    
		    $this->automaticLoadingOfHooksFiltersAndShortcodes();
		}
		
		/**
		 * @name loadFrontendFeatures
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		protected function loadFrontendFeatures() : void
		{
		    add_action( 'init', array($this, 'publicInit' ));
		    
		    add_action( 'wp_head', array($this->controllerManager, 'setAjaxurl' ));
		    add_action( 'wp_enqueue_scripts', array($this->controllerManager, 'frontendEnqueue' ));
		    
		    $this->automaticLoadingOfHooksFiltersAndShortcodes();
		}
		
		/**
		 * @name automaticLoadingOfHooksFiltersAndShortcodes
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		protected function automaticLoadingOfHooksFiltersAndShortcodes() : void
		{
		    $common = $this->controller->getCommon();
		    $config = $common->getConfig();
		    
		    $side = strtolower($common->getNameClass($this->controller));
			
			$hooks 		= $config[ 'features' ][ $side ][ 'hooks' ];
			$filters 	= $config[ 'features' ][ $side ][ 'filters' ];
			$shortcodes = $config[ 'features' ][ $side ][ 'shortcodes' ];
			if( count( $hooks ) > 0 ) 		$this->loadingHooks( $hooks[0] );
			if( count( $filters ) > 0 ) 	$this->loadingFilters( $filters[0] );
			if( count( $shortcodes ) > 0 ) 	$this->loadingShortcodes( $shortcodes[0] );
		}
		
		/**
		 * @name loading_hooks
		 *
		 * @param array $hooks
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		protected function loadingHooks(array $hooks) : void
		{
		    foreach( $hooks as $hook => $function )
			{
			    add_action( $hook, array( $this->controller, $function ));
			}
		}
		
		/**
		 * @name loadingFilters
		 * 
		 * @param array $filters
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		protected function loadingFilters(array $filters) : void
		{
			foreach( $filters as $filter => $function )
			{
			    add_filter( $filter, array( $this->controller, $function ));
			}
		}
		
		/**
		 * @name loadingShortcodes
		 *
		 * @param array $shortcodes
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		protected function loadingShortcodes(array $shortcodes) : void
		{
			foreach( $shortcodes as $shortcode => $function )
			{
			    add_shortcode( $shortcode, array( $this->controller, $function ));
			}
		}
	}
}