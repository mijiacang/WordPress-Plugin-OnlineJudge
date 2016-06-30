<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/UVaOJ/WordPress-Plugin-OnlineJudge
 * @since             0.0.1
 * @package           OnlineJudge
 *
 * @wordpress-plugin
 * Plugin Name:       OnlineJudge
 * Plugin URI:        https://github.com/UVaOJ/WordPress-Plugin-OnlineJudge
 * Description:       Creation of Online Judge social platforms for WordPress, BuddyPress and bbPress.
 * Version:           0.0.2
 * Author:            UVa Online Judge
 * Author URI:        https://uva.onlinejudge.org/
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       OnlineJudge
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-onlinejudge-activator.php
 */
function activate_OnlineJudge() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-onlinejudge-activator.php';
	OnlineJudge_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-onlinejudge-deactivator.php
 */
function deactivate_OnlineJudge() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-onlinejudge-deactivator.php';
	OnlineJudge_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_OnlineJudge' );
register_deactivation_hook( __FILE__, 'deactivate_OnlineJudge' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-onlinejudge.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_OnlineJudge() {

	$plugin = new OnlineJudge();
	$plugin->run();

}
run_OnlineJudge();
