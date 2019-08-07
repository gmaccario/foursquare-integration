<?php
/**
 * @name FrontendManager
 * @description The FrontendManager is a wrapper for all frontend wordpress related activites for example add the backend js/css and check the ajaxurl.
 *
 * @author G.Maccario <g_maccario@hotmail.com>
 */

namespace FSI\Setup\Classes;

use FSI\Controller\Classes\Controller;

if(!interface_exists('FSI\Setup\Classes\iFrontendManager'))
{
    interface iFrontendManager
    {
        public function frontendEnqueue() : void;
        public function setAjaxurl() : void;
    }
}

if(!class_exists('\FSI\Setup\Classes\FrontendManager'))
{
    class FrontendManager extends Manager
	{
		/**
		 * __construct
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function __construct(Controller $frontend)
		{
		    parent::__construct($frontend);
		    
		    $this->setConfig();
		}
		
		/**
		 * @name frontendEnqueue
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function frontendEnqueue() : void
		{
			wp_enqueue_style( 'foursquare_integration-frontend-css', sprintf( '%s%s', FOURSQUARE_INTEGRATION_URL, '/assets/css/frontend.css' ), array(), FOURSQUARE_INTEGRATION_FRONTEND_CSS_VERSION );
			wp_enqueue_script( 'foursquare_integration-frontend-js', sprintf( '%s%s', FOURSQUARE_INTEGRATION_URL, '/assets/js/frontend.js' ), array( 'jquery' ), FOURSQUARE_INTEGRATION_FRONTEND_JS_VERSION, true );
			
			/*
			 * Add additional frontend css/js
			 */
			$additional_js = $this->config['features']['frontend']['additional_js'];
			$additional_css = $this->config['features']['frontend']['additional_css'];
			
			$this->enqueueAdditionalStaticFiles($additional_js, 'js');
			$this->enqueueAdditionalStaticFiles($additional_css, 'css');
		}
		
		/**
		 * @name setAjaxurl
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setAjaxurl() : void
		{
			?>
			<script>
				var ajaxurl = "";
				try{ ajaxurl = my_ajax_object.ajax_url; }
				catch( e ) { ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>"; }
			</script>
			<?php 
		}
	}
}