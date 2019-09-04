<?php
/**
 * Plugin Name: Crocoblock Marketing Kit Installer
 * Plugin URI:  https://crocoblock.com/
 * Description: Crocoblock Marketing Kit Installer
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * Text Domain: croco-marketing-kit-installer
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

add_action( 'plugins_loaded', 'croco_mki_init' );

/**
 * Initializes plugin on plugins_loaded hook
 *
 * @return void
 */
function croco_mki_init() {

	define( 'CROCO_MKI_VERSION', '1.0.0' );

	define( 'CROCO_MKI__FILE__', __FILE__ );
	define( 'CROCO_MKI_PLUGIN_BASE', plugin_basename( CROCO_MKI__FILE__ ) );
	define( 'CROCO_MKI_PATH', plugin_dir_path( CROCO_MKI__FILE__ ) );
	define( 'CROCO_MKI_URL', plugins_url( '/', CROCO_MKI__FILE__ ) );

	require CROCO_MKI_PATH . 'includes/plugin.php';

}

/**
 * Returns Plugin class instance
 *
 * @return Croco_MKI\Plugin
 */
function croco_mki() {
	return Croco_MKI\Plugin::instance();
}

register_activation_hook( __FILE__, 'croco_mki_activation' );

/**
 * Callback for plugin activation hook
 *
 * @return void
 */
function croco_mki_activation() {
	set_transient( 'croco_mki_redirect', true, MINUTE_IN_SECONDS );
}
