<?php
/**
 * Plugin Name: WPMoo Starter
 * Description: Starter plugin showcasing WPMoo Framework capabilities.
 * Version: 0.1.0
 * Author: You
 * Text Domain: wpmoo-starter
 */

use WPMoo\Core\App;

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

App::instance()->boot( __FILE__, 'wpmoo-starter' );

require __DIR__ . '/src/init.php';
