<?php
/**
 * @name BackendManager
 * @description The BackendManager is a wrapper for all backend wordpress related activites for example add the pages in the backend menu, add the backend js/css.
 *
 * @author G.Maccario <g_maccario@hotmail.com>
 */
namespace FSI\Setup\Classes;
use FSI\Controller\Classes\Controller;
if(!interface_exists('FSI\Setup\Classes\iBackendManager'))
{
    interface iBackendManager
    {
        public function getPages() : array;
        public function backendEnqueue() : void;
        public function customActionLinks(array $links) : ?array;
        public function backendMenu() : void;
        public function whenFoursquareIntegrationStart() : void;
    }
}
if( !class_exists('\FSI\Setup\Classes\BackendManager'))
{
    class BackendManager extends Manager
	{		
		/**
		 * @name __construct
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function __construct(Controller $backend)
		{
		    parent::__construct($backend);
		    
		    $this->setConfig();
		}
		
		/**
		 * @name getPages
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return array
		 */
		public function getPages() : array
		{
		    if(!isset($this->config[ 'features' ][ 'backend' ][ 'pages' ]))
		    {
                return []; 
		    } 
		    else {
		        return $this->config[ 'features' ][ 'backend' ][ 'pages' ];
		    }
		}
		
		/**
		 * @name backendEnqueue
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function backendEnqueue() : void
		{		    
			/*
			 * Add additional frontend css/js 
			 */
			$additional_js = $this->config['features']['backend']['additional_js'];
			$additional_css = $this->config['features']['backend']['additional_css'];
			
			$this->enqueueAdditionalStaticFiles($additional_js, 'js');
			$this->enqueueAdditionalStaticFiles($additional_css, 'css');
			
			/* 
			 * Add basic static files 
			 */
			wp_enqueue_style('foursquare_integration-admin-css', sprintf( '%s%s', FOURSQUARE_INTEGRATION_URL, '/assets/css/backend.css' ), array(), FOURSQUARE_INTEGRATION_BACKEND_CSS_VERSION);
			wp_enqueue_script('foursquare_integration-admin-js', sprintf( '%s%s', FOURSQUARE_INTEGRATION_URL, '/assets/js/backend.js' ), array( 'jquery' ), FOURSQUARE_INTEGRATION_BACKEND_JS_VERSION, true);
		}
		
		/**
		 * @name customActionLinks
		 *
		 * @param array $links
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?array
		 */
		public function customActionLinks(array $links) : ?array
		{
		    $pages = $this->getPages();
		    
		    if( count( $pages ) > 0 )
			{
				return array_merge($links, array( 
					sprintf( '<a href="%s">%s</a>', 
					    admin_url( 'admin.php?page=' . $this->controller->getCommon()->getConstant( $pages[0][ 'slug' ] )), 
						__( 'Settings', FOURSQUARE_INTEGRATION_L10N ) 
					)
				));
			}
			
			return null;
		}
		
		/**
		 * @name backendMenu
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function backendMenu() : void
		{
		    $pages = $this->getPages();
		    
		    if( $pages ) 
			{
				$main_page = null;
				foreach( $pages as $k => $page )
				{
					if( 0 === $k )
					{
						$main_page = $this->controller->getCommon()->getConstant( $page[ 'slug' ] );
						
						/* TRICK: https://kylebenk.com/change-title-first-submenu-page/ */
						add_menu_page(
								__( FOURSQUARE_INTEGRATION_NAME, FOURSQUARE_INTEGRATION_L10N ),
								__( FOURSQUARE_INTEGRATION_NAME, FOURSQUARE_INTEGRATION_L10N ),
								'manage_options',
						    $this->controller->getCommon()->getConstant( $page[ 'slug' ] ),
								array( $this->controller, $page[ 'attributes' ][ 'callback' ] ),
								'dashicons-admin-site'
						);
					}
					add_submenu_page(
						$main_page,
						__( $page[ 'name' ], FOURSQUARE_INTEGRATION_L10N ),
						__( $page[ 'name' ], FOURSQUARE_INTEGRATION_L10N ),
						'manage_options',
					    $this->controller->getCommon()->getConstant( $page[ 'slug' ] ),
						array( $this->controller, $page[ 'attributes' ][ 'callback' ] )
					);
				}
			}
		}
		
		/**
		 * @name whenFoursquareIntegrationStart
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function whenFoursquareIntegrationStart() : void
		{
			register_setting( FOURSQUARE_INTEGRATION_OPT_SETTINGS_FIELDS, FOURSQUARE_INTEGRATION_OPT_SETTINGS_FIELDS );
			
			/*
			WordPress Settings API
			tabs, sections, fields and settings. 
			Tabs contains sections, sections contain field(form elements) and settings are just the value attribute of the form elements. 
			http://qnimate.com/wordpress-settings-api-a-comprehensive-developers-guide/
			--
			section name
			display name
			callback to print description of section
			page to which section is attached.
			add_settings_section
			*/
			
			$active_tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
			$active_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
			
			$pages = $this->getPages();
			
			if( $pages )
			{
			    foreach( $pages as $k => $page )
				{
					if( $page[ 'slug' ] == $active_page )
					{
						$tabs = $page[ 'attributes' ][ 'tabs' ];
						
						foreach( $tabs as $t => $tab )
						{							
							if( empty( $active_tab ) || $active_tab == $tab[ 'slug' ] )
							{
								add_settings_section(
								    $this->controller->getCommon()->getConstant( $tab[ 'slug' ] ),
									$tab[ 'name' ], 
									array( $this->controller, $tab[ 'callback' ] ) , 
								    $this->controller->getCommon()->getConstant( $active_page )
								);
							}
						}
					}
				}
			}
		}
	}
}