# WordPress Skeleton Plugin v.2.0
This is a WordPress Plugin Skeleton.

This skeleton is intended as a starter kit for WordPress Developers and Specialists in order to create their own features on top of  WordPress.

Why a Skeleton? As Developers I worked for a company for two years in their Wordpress team and every time I start working on a new plugin I was forced to create a new folder, new files, a new structure that was pretty similar to the previous ones and so on. I really don't like repeat unnecessary and manual tasks. Errors are just around the corner. I early decided to start to create my own Skeleton since when I tried third part Skeleton plugins but they almost never match my requirements and at the end I spent lot of time to modify the Skeleton and not working on my logic. 

So, my starting points were: 
* a configuration file
* a mechanism that read the config and create everything I need without modify the code everytime
* static resources already in places at the creation of the plugin
* you can write your business logic only inside two controller classes: Fronted and Backend
* add your templates view and add your JS + CSS + HTML codes
* an autolader system that allows to auto load every class I need
* and so on...

Different version of this skeleton are using on several production websites, you can find a list on my personal website (@todo).

## Things to do before start - Mandatory
- Change the folder name;
- Change the name of the main file with the same name of the folder (now wp-skeleton-plugin.php);
- Search and replace placeholder strings. Find and replace in in files (match case):
	- FOURSQUARE_INTEGRATION => constants, i.e. MY_GALACTIC_PLUGIN
	- FSI => namespace, i.e. MYNEWNAMESPACE
	- foursquare_integration => function name, i.e. your_plugin_slug
	- FoursquareIntegration => method name, i.e. YourPluginSlug
	- Foursquare Integration => string, i.e. Your plugin name
- Launch composer dump-autoload to install the dependencies

**Have fun (and money!) adding your new features!**

## Example 1
Add an Ajax call to the frontend:
- Create a page in your WordPress installation
- Insert shortcode [default_template_shortcode] inside you new page
- Add this snippet into /assets/js/frontend.js:
~~~~javascript
var data = {
	'action': 'echo_foo',
	'whatever': 1234
};
jQuery.post(ajaxurl, data, function(response) {
	console.log('Got this from the server: ', response);
});
~~~~
- Refresh the page: check into your console (F12)!

You can do the same on backend side: 
- insert your shortcodes in config file  (features->backend->shoortcodes)
- create your method that returns a json result inside Backend class
- add an ajax call to your backend javascript
- Refresh page your backend page and check into your console (F12)!

** Explanation:
The default config starts with preconfigured shortcode and ajax (default_template_shortcode and echo_foo). 
Everything is ready in the Frontend controller, then we can just consume the result with a JQuery post request and log it into the console.

## Example 2
@todo

## Composer
https://getcomposer.org/doc/01-basic-usage.md
php composer.phar install
composer require --dev phpunit/phpunit ^5.*

-> to test it: phpunit --version

## PHPUnit
https://phpunit.readthedocs.io/en/latest/installation.html
https://phpunit.de/getting-started/phpunit-6.html

How to launch a test:
phpunit --verbose <YOUR PATH>\foursquare_integration\tests\Common.test.php

## Autoload
https://getcomposer.org/doc/01-basic-usage.md#autoloading

## Tested on
- PHP 7.1.20
- Apache/2.4.25 (Debian)
- WordPress Version 5.2.2

## Change log
### 2.0
* Updated to PHP 7 and dispatcher refactoring
* [default_template] renamed in [default_template_shortcode]
### 1.8.1
* Fixed shortcode and render view
* Minor fixes
* Moved frontend/backend css/js version into constants
* Use config to generate backend pages and Settings link (on plugins list page)
* Remove constants and put them into the config (i.e. FOURSQUARE_INTEGRATION_BACKEND_MENU)
* Config loaded into the Basic class
### 1.8
* [basic_form] renamed in [default_template]
* Moved [basic_form] shortcode into the config file
* Added config file to manage hooks and filters
* Add render_view method in Common class
* Re-organized classes folder based on purpose, autoloader modified
* Added Backend and Frontend Manager classes in order to make Backend and Frontend basic classes more similar to a controller
* Added separate constants file
### 1.7
* Moved constants into specific file
* Added some HTML to the configuration backend page
* Improved frontend_enqueue and backend_enqueue
* Created new constants OPTIONS and STRINGS
* Modified Backend.class on configuration_page controller
* Added print_array in Basic.class
* Created constant FOURSQUARE_INTEGRATION_L10N for Localization

## License
GNU General Public License v3.0 https://www.gnu.org/licenses/gpl-3.0.en.html

## Author
* Author: Giuseppe Maccario
* Author URI: https://www.giuseppemaccario.com/
* Github URI: https://github.com/gmaccario/foursquare_integration