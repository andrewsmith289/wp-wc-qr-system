<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https:///
 * @since             1.0.0
 * @package           Bcbs_Qr
 *
 * @wordpress-plugin
 * Plugin Name:       bcbs-qr
 * Plugin URI:        https:///
 * Version:           1.0.0
 * Author:            -------
 * Author URI:        https://

 * Text Domain:       bcbs-qr
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bcbs-qr-activator.php
 */
function activate_bcbs_qr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bcbs-qr-activator.php';
	Bcbs_Qr_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bcbs-qr-deactivator.php
 */
function deactivate_bcbs_qr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bcbs-qr-deactivator.php';
	Bcbs_Qr_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bcbs_qr' );
register_deactivation_hook( __FILE__, 'deactivate_bcbs_qr' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bcbs-qr.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bcbs_qr() {

	$plugin = new Bcbs_Qr();
	$plugin->run();

}
run_bcbs_qr();
