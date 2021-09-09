<?php
/**
 * Plugin Name:       CMS Developer Test Yiannis Christodoulou
 * Plugin URI:        https://www.yiannistaos.com
 * Description:       A CMS Developer Test for agentur-loop.com by Yiannis Christodoulou
 * Version:           1.0.0
 * Author:            Yiannis Christodoulou
 * Author URI:        https://www.yiannistaos.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mytest
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

require_once (plugin_dir_path( __FILE__ ) . 'show-data-shortcode.php');
require_once (plugin_dir_path( __FILE__ ) . 'export-data-json.php');
require_once (plugin_dir_path( __FILE__ ) . 'custom-post-type.php');
require_once (plugin_dir_path( __FILE__ ) . 'custom-fields.php');
require_once (plugin_dir_path( __FILE__ ) . 'wp-cli.php');