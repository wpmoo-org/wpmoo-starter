<?php
/**
 * Plugin Name: WPMoo Starter
 * Plugin URI: https://wpmoo.org
 * Description: Starter plugin showcasing WPMoo Framework capabilities.
 * Version: 0.1.0
 * Author: You
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wpmoo-starter
 * Domain Path: /languages
 *
 * @package WPMooStarter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Begins the plugin loading process for the WPMoo Starter.
 *
 * This file is the primary entry point for the starter plugin that demonstrates
 * how to use the WPMoo framework to build WordPress components.
 */
require_once __DIR__ . '/src/init.php';
