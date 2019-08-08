<?php
return [
    'settings' => [
		'dependencies' => [],
		'restrictions' => []
	],
	'features' => [
		'backend' => [
			'hooks' => [],
			'filters'=> [],
			'shortcodes'=> [],
			'ajax'=> [],
			'routes'=> [],
		    'additional_js' => [],
		    'additional_css' => [],
			'pages'=> [
				[
				    'name'=> 'Foursquare Integration Backend name', 
    				'slug'=> 'foursquare_integration_menu_page', 
    				'attributes'=> [
    					'callback'=> 'configuration', 
    					'tabs'=> [ 
    						[ 
    							'name' => '', 
    							'slug' => '', 
    							'callback' => '' 
    						],
    						[ 
    							'name' => '', 
    							'slug' => '', 
    							'callback' => '' 
    						]
    					]
    				]
				]
			]
		],
		'frontend' => [
			'hooks'=> [],
			'filters'=> [],
			'shortcodes'=> [
				['foursquare_integration_shortcode'=> 'foursquare_integration']
			],
			'ajax'=> [ 'foursquare_results' ],
			'routes'=> [],
		    'additional_js' => [ 'https://unpkg.com/axios/dist/axios.min.js', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js' ],
		    'additional_css' => []
		]
	],
	'comments'=> 'Pages will create new pages for your backend and tabs will create tabs inside backend pages. | Frontend shortcodes: [shortcode => frontend method]'
];