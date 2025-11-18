<?php
/**
 * Sample Settings Page for WPMooStarter using WPMoo Framework.
 *
 * This demonstrates the usage of the new WPMoo architecture for creating
 * a settings page with tabs and fields.
 *
 * @package WPMooStarter\Pages\Settings
 * @since 0.1.0
 * @link https://wpmoo.org   WPMoo – WordPress Micro Object-Oriented Framework.
 * @link https://github.com/wpmoo/wpmoo   GitHub Repository.
 * @license https://spdx.org/licenses/GPL-2.0-or-later.html   GPL-2.0-or-later
 */

namespace WPMooStarter\Pages\Settings;

use WPMoo\Moo;
use WPMoo\Field\Field;

if ( ! defined( 'ABSPATH' ) ) {
	wp_die( 'Direct access not allowed.' );
}

/**
 * Registers the sample settings page with tabs and fields.
 */
class Settings {
	/**
	 * Hook into WordPress actions to register the settings page.
	 *
	 * @return void
	 */
	public static function register(): void {
		// Hook the actual registration to happen after translations are loaded
		add_action( 'init', [ __CLASS__, 'register_page' ] );
	}

	/**
	 * Register the starter settings page with tabs and fields.
	 *
	 * @return void
	 */
	public static function register_page(): void {
		// Create a settings page
		Moo::page( 'wpmoo_starter_settings', __( 'Starter Settings', 'wpmoo-starter' ) )
			->capability( 'manage_options' )
			->description( __( 'Configure WPMoo Starter plugin settings', 'wpmoo-starter' ) )
			->menu_slug( 'wpmoo-starter-settings' )
			->menu_position( 20 )
			->menu_icon( 'dashicons-admin-generic' );

		// Create tabs for the settings page
		Moo::tabs( 'wpmoo_starter_main_tabs' )
			->parent( 'wpmoo_starter_settings' )  // Link to the settings page
			->items(
				[
					[
						'id' => 'general',
						'title' => __( 'General Settings', 'wpmoo-starter' ),
						'content' => [
							Field::input( 'site_title' )
								->label( __( 'Site Title', 'wpmoo-starter' ) )
								->placeholder( __( 'Enter your site title', 'wpmoo-starter' ) ),
							Field::textarea( 'site_description' )
								->label( __( 'Site Description', 'wpmoo-starter' ) )
								->placeholder( __( 'Enter site description', 'wpmoo-starter' ) ),
							Field::toggle( 'enable_cache' )
								->label( __( 'Enable Caching', 'wpmoo-starter' ) ),
						],
					],
					[
						'id' => 'advanced',
						'title' => __( 'Advanced Settings', 'wpmoo-starter' ),
						'content' => [
							Field::input( 'cache_duration' )
								->label( __( 'Cache Duration (seconds)', 'wpmoo-starter' ) )
								->placeholder( __( 'Enter cache duration', 'wpmoo-starter' ) ),
							Field::toggle( 'enable_debug' )
								->label( __( 'Enable Debug Mode', 'wpmoo-starter' ) ),
						],
					],
				]
			);
	}
}
