<?php
/*
Plugin Name: ImmoToolBox Connect
Plugin URI: https://www.immotoolbox.com/
Description: Displays ImmoToolBox real estate listings in your website
Version: 1.3.3
Author: ZebraSoft Monaco
Author URI: https://www.zebrasoft.mc
Text Domain:  immotoolbox-connect
Domain Path: /languages
License:     GPL3

ImmoToolBox Connect is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

ImmoToolBox Connect is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with ImmoToolBox Connect. If not, see https://www.gnu.org/licenses/gpl.html.
*/
define('ITBCONNECT_VERSION', '1.3.3');

/**
 * Plugin URL
 */
define('ITBCONNECT_URL', plugin_dir_url( __FILE__ ));
define('ITBCONNECT_PLUGIN_URL', 'https://wordpress.org/plugins/immotoolbox-connect/');

/**
 * API access point base url
 */
define('ITBCONNECT_API_BASEURL', 'https://clientapi.immotoolbox.com/api');

/**
 * WordPress option key
 */
define('ITBCONNECT_OPTION_NAME', 'itbconnect_data');
if (version_compare('7.0', phpversion()) === 1) {
    require_once __DIR__ . '/includeslegacy/vendor/autoload.php';
} elseif (version_compare('8.2', phpversion()) === -1) {
    require_once __DIR__ . '/includes8.2/vendor/autoload.php';
} elseif (version_compare('8.0', phpversion()) === -1) {
    require_once __DIR__ . '/includes8.0/vendor/autoload.php';
} else {
    require_once __DIR__ . '/includes/vendor/autoload.php';
}
require_once __DIR__.'/includes/ITBConnect.php';

register_activation_hook( __FILE__, function () { ITBConnect::activate(); });
register_deactivation_hook( __FILE__, function () { ITBConnect::deactivate(); } );

function run_itbconnect() {
    $itbconnect = new ITBConnect();
    $itbconnect->run();
}
run_itbconnect();
