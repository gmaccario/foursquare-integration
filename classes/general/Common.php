<?php 

namespace FSI\General\Classes;

use FSI\Controller\Classes\iController;

if(!interface_exists('FSI\General\Classes\iCommon'))
{
    interface iCommon
    {
        public function getConfig() : ?array;
        public function printMyLastQuery() : array;
        public function checkDependencies() : bool;
        public function getNameClass(Basic $object) : string;
        public function renderView(iController $controller, string $view, array $params) : ?string;
        public function getConstant(string $sz_supposed_constant = '') : string;
        public function uploadFile(string $dir = '', array $f = []) : ?bool;
        public function uploadFiles(string $dir = '', array $f = []) : ?bool;
        public function getIntFromLegendPosition(string $legend_position) : int;
    }
}

if(!class_exists('\General\Classes\Common'))
{
    /**
     * @name Common
     * @description Common Controllers behaviour 
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
	class Common implements iCommon
	{		
		private $config = null;
		
		/**
		 * __construct
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function __construct()
		{
		    $this->setConfig();
		}
		
		/**
		 * setConfig
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		protected function setConfig() : void
		{
		    $path = FOURSQUARE_INTEGRATION_PATH_CONFIG . 'config.php';
		    
		    if( empty($this->config) && file_exists( $path ))
		    {
		        $this->config = include_once( $path );
		    }
		}			
		
		/**
		 * @name getConfig
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return array
		 */
		public function getConfig() : ?array
		{
		    return $this->config;
		}
		
		/**
		 * @name printMyLastQuery
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return array
		 */
		public function printMyLastQuery() : array
		{
			global $wpdb;
			
			return $wpdb->last_query;
		}
		
		/**
		 * @name checkDependencies
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return bool
		 */
		public function checkDependencies() : bool
		{
		    /*
		     * @todo get the dependencies from the config 
		     * COMMENT THIS FUNCTION: in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		     */
			$dependency = true; 

			if (!$dependency)
			{
				try {
					deactivate_plugins( FOURSQUARE_INTEGRATION_BASENAME );
				} 
				catch ( \Error $e ) {
					echo $e->getMessage();
				}

				?>
					<div class="error notice">
						<p><?php echo __( FOURSQUARE_INTEGRATION_BACKEND_DEPENDENCIES_MESSAGE, FOURSQUARE_INTEGRATION_L10N ); ?></p>
					</div>
				<?php 
			}
			
			return $dependency;
		}
		
		/**
		 * @name renderView
		 *
		 * @param iController $controller
		 * @param string $view
		 * @param array $params
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?string
		 */
		public function renderView(iController $controller, string $view, array $params) : ?string
		{			
			/* Extract attributes/values of the object to convert them into single variables */
			extract($params);
			
			switch( $this->getNameClass($controller) )
			{
				case 'Backend':
					include( FOURSQUARE_INTEGRATION_PATH_TEMPLATES . 'backend' . DIRECTORY_SEPARATOR . $view . '.php' );
					break;
				case 'Frontend':
					ob_start();
					include( FOURSQUARE_INTEGRATION_PATH_TEMPLATES . 'frontend' . DIRECTORY_SEPARATOR . $view . '.php' );
					return ob_get_clean();
					break;
				default:
					break;
			}
			
			return null;
		}
		
		/**
		 * @name getNameClass
		 *
		 * @param Basic $object
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 */
		public function getNameClass(Basic $object) : string
		{
		    $reflect = new \ReflectionClass($object);
		    
		    return $reflect->getShortName();
		}
		
		/**
		 * getConstant
		 *
		 * @param string $sz_supposed_constant
		 * 
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 */
		public function getConstant(string $sz_supposed_constant = '') : string
		{
		    if(strlen($sz_supposed_constant) == 0) return '';
		    
			return ( defined( $sz_supposed_constant ) ? constant ( $sz_supposed_constant ) : $sz_supposed_constant );
		}
		
		/**
		 * uploadFile
		 *
		 * @param string $path
		 * @param array $files
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?bool
		 */
		public function uploadFile(string $path = '', array $files = []) : ?bool
		{
		    if( !empty( $files[ 'name' ]))
			{
			    $tmpFilePath = $files['tmp_name'];
					
				if( $tmpFilePath != "" )
				{
				    $filePath = $path . $files['name'];
			
					if( !move_uploaded_file( $tmpFilePath, $filePath ))
					{
						return false;
					}
					else {
						return true;
					}
				}
			}
			return null;
		}
		
		/**
		 * uploadFiles
		 * 
		 * @param string $path
		 * @param array $files
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?bool
		 */
		public function uploadFiles(string $path = '', array $files = []) : ?bool
		{
		    if(count($files['name']) > 0)
			{
				$result = true;
				
				for($i=0; $i<count($files['name']); $i++)
				{
				    $tmpFilePath = $files['tmp_name'][$i];
			
					if( $tmpFilePath != "" )
					{
					    $filePath = $path . $files['name'][$i];
				
						if( !move_uploaded_file( $tmpFilePath, $filePath ))
						{
						    $result = false;
						}
						else {
						    $result = true;
						}
					}
				}
				
				return $result;
		    }
		    
			return null;
		}
		
		/**
		 * getIntFromLegendPosition
		 *
		 * @param string $legend_position
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return int
		 */
		public function getIntFromLegendPosition(string $legend_position = '') : int
		{
			switch($legend_position)
			{
				case FOURSQUARE_INTEGRATION_MAPS_CONTROLS_POSITION_TOP_CENTER:
					return 1;
					break;
				case FOURSQUARE_INTEGRATION_MAPS_CONTROLS_POSITION_LEFT_CENTER:
					return 2;
					break;
				default:
					return 3;
					break;
			}
		}
	}
}