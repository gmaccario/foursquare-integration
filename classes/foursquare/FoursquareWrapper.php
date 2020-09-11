<?php
/**
 * FoursquareWrapper
 * 
 * 
 * @package VueSquare
 * @author Giuseppe Maccario <g_maccario@hotmail.com>
 * @version 1.0.1
 * @license GPLv3 <http://www.gnu.org/licenses/gpl.txt>
 */

namespace FSI\Foursquare\Classes;

if(!interface_exists('iFoursquareWrapper'))
{
    interface iFoursquareWrapper
    {
        public function setAction(string $action) : void;
        public function setWhat(?string $action) : void;
        public function setLL(?string $ll) : void;
        public function setIntent(?string $intent) : void;
        public function setName(?string $name) : void;
        public function setLimit(?int $limit) : void;
        public function setNear(?string $near) : void;
        public function setRadius(?int $radius) : void;
        public function setIdVenue(?string $id_venue) : void;
        public function setCategoryId(?string $category_id) : void;
        
        public function getAction() : string;
        public function getWhat() : ?string;
        public function getLL() : ?string;
        public function getIntent() : ?string;
        public function getName() : ?string;
        public function getLimit() : ?int;
        public function getNear() : ?string ;
        public function getRadius() : ?int;
        public function getIdVenue() : ?string ;
        public function getCategoryId() : ?string;
        
        public function executePost() : ?string;
    }
}

if(!class_exists('FoursquareWrapper'))
{
    /**
     * @name FoursquareWrapper
     * @description Foursquare Wrapper that use the FoursquareAPI object as dependency injection 
     * and returns the response of the Foursquare service. 
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
	class FoursquareWrapper implements iFoursquareWrapper{
		
		protected $foursquare;
		protected $post;
		protected $action;
		protected $what; 
		protected $ll;
		protected $intent;
		protected $name;
		protected $near;
		protected $radius;
		protected $id_venue;
		protected $categoryId;
		
		protected $endpoint = '';
		protected $params = [];
		
		/**
		 * @name __construct
		 *
		 * @param \FoursquareApi $foursquare
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function __construct(\FoursquareApi $foursquare)
		{
		    $this->foursquare = $foursquare;
		}
		
		/**
		 * @name setAction
		 * 
		 * @param string $action
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setAction(string $action) : void
		{ 
		    $this->action = $action; 
		}
		
		/**
		 * @name setWhat
		 *
		 * @param string $what
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setWhat(?string $what) : void
		{
		    $this->what = $what;
		}
		
		
		/**
		 * @name setLL
		 *
		 * @param ?string $ll
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setLL(?string $ll) : void 
		{ 
		    $this->ll = $ll; 
		}
		
		/**
		 * @name setIntent
		 *
		 * @param ?string $intent
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setIntent(?string $intent) : void 
		{ 
		    $this->intent = $intent; 
		}
		
		/**
		 * @name setName
		 *
		 * @param ?string $intent
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setName(?string $name) : void
		{
		    $this->name = $name;
		}
		
		/**
		 * @name setLimit
		 *
		 * @param ?int $limit
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setLimit(?int $limit) : void
		{
		    $this->limit = $limit;
		}
		
		/**
		 * @name setNear
		 *
		 * @param ?string $near
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setNear(?string $near) : void 
		{ 
		    $this->near = $near; 
		}
		
		/**
		 * @name setRadius
		 *
		 * @param int $radius
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setRadius(?int $radius) : void
		{
		    $this->radius = $radius; 
		}
		
		/**
		 * @name setIdVenue
		 *
		 * @param ?string $id_venue
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setIdVenue(?string $id_venue) : void 
		{ 
		    $this->id_venue = $id_venue; 
		}
		
		/**
		 * @name setCategoryId
		 *
		 * @param ?string $category_id
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function setCategoryId(?string $category_id) : void
		{
		    $this->categoryId = $category_id; 
		}
		
		/**
		 * @name getAction
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 */
		public function getAction() : string
		{ 
		    return $this->action; 
		}
		
		/**
		 * @name getWhat
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 */
		public function getWhat() : ?string
		{
		    return $this->what;
		}
		
		/**
		 * @name getLL
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?string
		 */
		public function getLL() : ?string 
		{ 
		    return $this->ll; 
		}
		
		/**
		 * @name getIntent
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?string
		 */
		public function getIntent() : ?string
		{ 
		    return $this->intent; 
		}
		
		/**
		 * @name getName
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?string
		 */
		public function getName() : ?string
		{
		    return $this->name;
		}
		
		/**
		 * @name getLimit
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?int
		 */
		public function getLimit() : ?int
		{
		    return $this->limit;
		}
		
		/**
		 * @name getNear
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?string
		 */
		public function getNear() : ?string 
		{ 
		    return $this->near; 
		}
		
		/**
		 * @name getRadius
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?int
		 */
		public function getRadius() : ?int
		{
		    return $this->radius; 
		}
		
		/**
		 * @name getIdVenue
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?string
		 */
		public function getIdVenue() : ?string 
		{ 
		    return $this->id_venue; 
		}
		
		/**
		 * @name getCategoryId
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?string
		 */
		public function getCategoryId() : ?string
		{
		    return $this->categoryId;
		}
		
		
		/**
		 * @name executePost
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return ?string
		 */
		public function executePost() : ?string
		{
		    $this->preparePost();

		    if($this->endpoint != '' && count($this->params) > 0)
			{
			    $response = $this->foursquare->GetPublic($this->endpoint, $this->params);
			    
			    header('Content-Type: application/json');
			    
			    /* Treat any input from external resource as unsafe */
			    return strip_tags($response);
			}
			
			return null;
		}
		
		/**
		 * @name preparePost
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		protected function preparePost() : void
		{
		    switch($this->what)
		    {
		        case 'get_categories':
		            $this->endpoint = 'venues/categories';
		            $this->params['ll'] = $this->ll;
		            $this->params['intent'] = $this->intent;
		            break;
		        case 'where_am_i':
		            $this->endpoint = 'venues/search';
		            $this->params['ll'] = $this->ll;
		            $this->params['limit'] = $this->limit;
		            $this->params['intent'] = $this->intent;
		            break;
		        case 'get_venues_per_coords':
		            $this->endpoint = 'venues/search';
		            $this->params['ll'] = $this->ll;
		            $this->params['radius'] = $this->radius;
		            $this->params['intent'] = $this->intent;
		            break;
		        case 'get_venues_by_category':
		            $this->endpoint = 'venues/search';
		            $this->params['ll'] = $this->ll;
		            $this->params['radius'] = $this->radius;
		            $this->params['categoryId'] = $this->categoryId;
		            $this->params['intent'] = $this->intent;
		            break;
		        case 'search_near_to':
		            $this->endpoint = 'venues/search';
		            $this->params['near'] = $this->near;
		            $this->params['radius'] = $this->radius;
		            $this->params['intent'] = $this->intent;
		            break;
		        case 'get_venue_details':
		            $this->endpoint = sprintf('venues/%s', $this->id_venue);
		            $this->params['intent'] = $this->intent;
		            break;
		        case 'get_photos_per_venue':
		            $this->endpoint = sprintf('venues/%s/photos', $this->id_venue);
		            $this->params['intent'] = $this->intent;
		            $this->params['group'] = 'venue';
		            break;
		        case 'suggestion':
		            /* @todo https://developer.foursquare.com/docs/api/venues/suggestcompletion */
		            //$response = $this->foursquare->GetPublic( 'venues/suggestcompletion', array( 'group' => 'venue' ) );
		            break;
		        default:
		            break;
		    }
		}
	}
}