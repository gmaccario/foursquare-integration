<?php 
/**
 * @name Dispatcher
 * @description The dispatcer is in charge of taking the right decision about what side of the plugin to set up and launch (frontend or backend). 
 * 
 * @author G.Maccario <g_maccario@hotmail.com> 
 */

use FSI\General\Classes\Common;
use FSI\Controller\Classes\Backend;
use FSI\Controller\Classes\Frontend;
use FSI\Setup\Classes\FrontendManager;
use FSI\Setup\Classes\BackendManager;
use FSI\Setup\Classes\AjaxLoader;
use FSI\Setup\Classes\Loader;
use FSI\Foursquare\Classes\FoursquareWrapper;

$common = new Common();

if($common->checkDependencies())
{    
    /* In case of ajax call I need to load both Frontend and Backend to match the right method inside the right class */
    if (defined('DOING_AJAX') && DOING_AJAX)
    {
        /* Get values from POST */
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING, array('options'=>array('default'=> '')));
        $what = filter_input(INPUT_POST, 'what', FILTER_SANITIZE_STRING);
        $ll = filter_input(INPUT_POST, 'll', FILTER_SANITIZE_STRING);
        $intent = filter_input(INPUT_POST, 'intent', FILTER_SANITIZE_STRING);
        $near = filter_input(INPUT_POST, 'near', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $limit = filter_input(INPUT_POST, 'limit', FILTER_SANITIZE_NUMBER_INT);
        $id_venue = filter_input(INPUT_POST, 'id_venue', FILTER_SANITIZE_STRING);
        $radius = filter_input(INPUT_POST, 'radius', FILTER_SANITIZE_NUMBER_INT);
        $category_id = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_STRING);
        
        /* GET API KEYs FROM DATABASE */
        $client_id = get_option(FOURSQUARE_INTEGRATION_OPT_CLIENT_ID);
        $secret_key = get_option(FOURSQUARE_INTEGRATION_OPT_SECRET_KEY);
        
        /* FOURSQUARE API */
        $foursquareAPI = new FoursquareApi($client_id, $secret_key);
        
        /* FOURSQUARE WRAPPER */
        $foursquareWrapper = new FoursquareWrapper($foursquareAPI);
        $foursquareWrapper->setAction($action);
        $foursquareWrapper->setWhat($what);
        $foursquareWrapper->setLL($ll);
        $foursquareWrapper->setIntent($intent);
        $foursquareWrapper->setNear($near);
        $foursquareWrapper->setName($name);
        $foursquareWrapper->setLimit($limit);
        $foursquareWrapper->setIdVenue($id_venue);
        $foursquareWrapper->setRadius($radius);
        $foursquareWrapper->setCategoryId($category_id);
        
        /* BACKEND */
        $backend = new Backend($common);
        $frontend = new Frontend($common);
        
        $frontend->setFoursquareWrapper($foursquareWrapper);
        
        /* Both side */
        $controllers = [
            $backend, 
            $frontend
        ];
        
        /* WARNING: WordPress must register AJAX CALLS and new ROUTES before add any action or filters! */
        $ajaxLoader = new AjaxLoader();
        
        array_map(function ($controller) use($ajaxLoader){
            
            /* AJAX LOADER */
            $ajaxLoader->setController($controller);
            $ajaxLoader->registerAjaxCalls();
            
        }, $controllers);
    } 
    else {
        
        /* Request frontend or backend */
        $controller = null;
        $manager = null;
        
        if(is_admin())
        {
            /* BACKEND SIDE */
            $controller = new Backend($common);
            
            /* BACKEND MANAGER */
            $manager = new BackendManager($controller);
            
        } else {
            
            /* FRONTEND SIDE */
            $controller = new Frontend($common);
            
            /* FRONTEND MANAGER */
            $manager = new FrontendManager($controller);
        }
        
        /* HOOKS AND FILTERS HERE */
        $loader = new Loader();
        
        $loader->setController($controller);
        $loader->setControllerManager($manager);
        
        $loader->loadFeatures();
    }
}