<?php
namespace FSI\Setup\Classes;
use FSI\General\Classes\Basic;
use FSI\Controller\Classes\iController;
if(!interface_exists('FSI\Setup\Classes\iManager'))
{
    interface iManager
    {
        public function setConfig() : void;
    }
}
if(!class_exists('\FSI\Setup\Classes\Controller'))
{
    /**
     * @name Manager
     * @description Generic class for the Controller
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
    class Manager extends Basic implements iManager
    {
        protected $config;
        protected $controller;
        
        /**
         * @name __construct
         *
         * @author G.Maccario <g_maccario@hotmail.com>
         * @return
         */
        public function __construct(iController $controller)
        {
            parent::__construct();
            
            $this->controller = $controller;
        }
        
        /**
         * @name setConfig
         *
         * @author G.Maccario <g_maccario@hotmail.com>
         * @return void
         */
        public function setConfig() : void
        {
            $this->config = $this->controller->getCommon()->getConfig();
        }
        
        /**
         * @name enqueueAdditionalStaticFiles
         * 
         * @param array $additionals
         * @param string $enqueueType
         *
         * @author G.Maccario <g_maccario@hotmail.com>
         * @return void
         */
        protected function enqueueAdditionalStaticFiles(array $additionals, string $enqueueType) : void
        {
            array_map(function($additional) use($enqueueType){
                $basename = explode('/', $additional);
                
                if($enqueueType == 'js')
                {                    
                    wp_enqueue_script( 
                        'foursquare_integration-frontend-js-' . $basename[count($basename) - 1], 
                        $additional, 
                        array( 
                            'jquery'
                        ), 
                        null, 
                        true 
                    );
                }
                else {
                    wp_enqueue_style( 
                        'foursquare_integration-admin-frontend-css-' . $basename[count($basename) - 1], 
                        $additional
                    );
                }
                
            }, $additionals);
        }
    }
}