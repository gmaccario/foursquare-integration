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
				['default_template_shortcode'=> 'default_template']
			],
			'ajax'=> [ 'echo_foo' ],
			'routes'=> [],
		    'additional_js' => [],
		    'additional_css' => []
		]
	],
	'comments'=> 'Pages will create new pages for your backend and tabs will create tabs inside backend pages. | Frontend shortcodes: [shortcode => frontend method]'
];