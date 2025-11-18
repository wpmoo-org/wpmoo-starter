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

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

// Load the plugin's textdomain
add_action(
	'init',
	function () {
		load_plugin_textdomain( 'wpmoo-starter', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
);

\WPMoo\WordPress\Bootstrap::instance()->boot( __FILE__, 'wpmoo-starter' );

require __DIR__ . '/src/init.php';
