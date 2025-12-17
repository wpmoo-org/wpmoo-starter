<?php
/**
 * Initializes the WPMoo Starter plugin.
 *
 * This file handles loader registration and hooks into the core
 * to load the starter's own features. It acts as a "conductor" in the global scope.
 *
 * @package WPMooStarter
 */

// 1. Load the shared, immutable loader.
if ( ! function_exists( 'wpmoo_loader' ) ) {
    require_once dirname( __DIR__ ) . '/vendor/wpmoo/wpmoo/framework/wpmoo-loader.php';
}

// Load the WPMoo autoloader early so Core and other WPMoo classes are available.
wpmoo_loader( 'load_autoloader', dirname( __DIR__ ) . '/vendor/wpmoo/wpmoo/framework' );

// 2. Register this version of the framework with the loader.
wpmoo_loader( 'register', dirname( __DIR__ ) . '/vendor/wpmoo/wpmoo/framework/WordPress/boot.php', '0.1.0' );

// 3. Load the Local Facade for this plugin.
require_once __DIR__ . '/Moo.php';



// 4. Hook into the 'init' action to register components and load samples.
// This ensures that WordPress is fully loaded and translations are available.
add_action('init', function() {
    // 4.1. Register this plugin with the FrameworkManager for component tracking.
    \WPMoo\Core::instance()->get_container()->resolve(\WPMoo\WordPress\Managers\FrameworkManager::class)->register_plugin(
        __FILE__, // Plugin's main file path
        \WPMooStarter\Moo::detect_app_id(),  // Dynamically detected plugin slug
        '0.1.0'   // Plugin version for starter
    );

    // 4.2. Load the definition files for pages, fields, etc.
    require_once __DIR__ . '/samples/settings.php';
});
