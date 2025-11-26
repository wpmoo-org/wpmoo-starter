<?php
/**
 * Plugin Name: WPMoo Starter
 * Description: Starter plugin showcasing WPMoo Framework capabilities.
 * Version: 0.1.0
 * Author: You
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wpmoo-starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Step 1: Load the Composer autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Step 2: Define WPMoo Framework constants if not already defined.
// This makes this plugin self-sufficient and explicit about framework location.
if ( ! defined( 'WPMOO_VERSION' ) ) {
	define( 'WPMOO_VERSION', '0.1.0' ); // It's good practice to align with the required version.
}
if ( ! defined( 'WPMOO_PATH' ) ) {
	define( 'WPMOO_PATH', __DIR__ . '/vendor/wpmoo/wpmoo' );
}
if ( ! defined( 'WPMOO_URL' ) ) {
	define( 'WPMOO_URL', plugin_dir_url( __FILE__ ) . 'vendor/wpmoo/wpmoo' );
}

// Step 3: Load the WPMoo Framework's guard file.
// This prevents double-loading if another plugin/theme includes it.
if ( file_exists( WPMOO_PATH . '/init.php' ) ) {
	require_once WPMOO_PATH . '/init.php';
}

// Step 4: Boot the WPMoo framework in the context of this plugin.
if ( class_exists( 'WPMoo\\WordPress\\Bootstrap' ) ) {
	\WPMoo\WordPress\Bootstrap::instance()->boot( __FILE__, 'wpmoo-starter' );
}

// Load the plugin's textdomain.
add_action(
	'init',
	function () {
		load_plugin_textdomain( 'wpmoo-starter', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
);

// Load the starter plugin's own initialization logic (e.g., defining pages, fields).
if ( file_exists( __DIR__ . '/src/init.php' ) ) {
	require __DIR__ . '/src/init.php';
}
