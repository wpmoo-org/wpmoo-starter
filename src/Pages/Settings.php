<?php
/**
 * Admin settings page registration.
 *
 * @package WPMooStarter\Pages
 * @since 0.2.0
 */

namespace WPMooStarter\Pages;

use WPMoo\Options\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the starter plugin settings page.
 */
class Settings {
	/**
	 * Register the Options API configuration.
	 *
	 * @return void
	 */
	public static function register(): void {
		Options::register(
			array(
				'page_title' => 'Starter Settings',
				'menu_title' => 'WPMoo Starter',
				'menu_slug'  => 'wpmoo-starter-settings',
				'option_key' => 'wpmoo_starter_settings',
				'sections'   => array(
					array(
						'title'  => 'General',
						'fields' => array(
							array(
								'id'          => 'welcome_text',
								'type'        => 'text',
								'label'       => 'Welcome Text',
								'description' => 'Message displayed in the starter log.',
								'default'     => 'Hello from WPMoo Starter Options!',
								'args'        => array(
									'class'       => 'regular-text',
									'placeholder' => 'Enter welcome message',
								),
							),
							array(
								'id'          => 'enable_books',
								'type'        => 'checkbox',
								'label'       => 'Enable Book Creation',
								'description' => 'Toggle the starter book insertion on init.',
								'default'     => 1,
							),
							array(
								'id'          => 'accent_color',
								'type'        => 'color',
								'label'       => 'Accent Color',
								'description' => 'Example field demonstrating the color picker.',
								'default'     => '#8a00d4',
							),
						),
					),
				),
			)
		);
	}
}
