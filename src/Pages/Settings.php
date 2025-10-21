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
 * Registers the starter plugin settings page using the fluent API.
 */
class Settings {
	/**
	 * Register the options container.
	 *
	 * @return void
	 */
	public static function register(): void {
		$container = Options::register( 'wpmoo_starter_settings' )
			->pageTitle( 'Starter Settings' )
			->menuTitle( 'WPMoo Starter' )
			->menuSlug( 'wpmoo-starter-settings' )
			->capability( 'manage_options' );

		$general = $container->section( 'general', 'General Settings', 'Configure basic plugin options' )
			->icon( 'dashicons-admin-generic' );

		$general->field( 'welcome_text', 'text' )
			->label( 'Welcome Text' )
			->description( 'Message displayed in the starter log.' )
			->default( 'Hello from WPMoo Starter Options!' )
			->args(
				array(
					'class'       => 'regular-text',
					'placeholder' => 'Enter welcome message',
				)
			);

		$general->field( 'enable_books', 'checkbox' )
			->label( 'Enable Book Creation' )
			->description( 'Toggle the starter book insertion on init.' )
			->default( 1 );

		$general->field( 'accent_color', 'color' )
			->label( 'Accent Color' )
			->description( 'Example field demonstrating the color picker.' )
			->default( '#8a00d4' );

		$integrations = $container->section( 'integrations', 'Integrations', 'Third-party service integrations' )
			->icon( 'dashicons-admin-links' );

		$integrations->field( 'api_key', 'text' )
			->label( 'API Key' )
			->description( 'Enter your API key for external services' )
			->default( '' );

		$advanced = $container->section( 'advanced', 'Advanced', 'Advanced configuration options' )
			->icon( 'dashicons-admin-tools' );

		$advanced->field( 'custom_css', 'textarea' )
			->label( 'Custom CSS' )
			->description( 'Add custom CSS code' )
			->default( '' );

		$advanced->field( 'content_blocks', 'accordion' )
			->label( 'Content Blocks' )
			->description( 'Configure optional homepage sections.' )
			->set(
				'sections',
				array(
					array(
						'title'  => 'Hero Banner',
						'open'   => true,
						'fields' => array(
							array(
								'id'      => 'hero_title',
								'type'    => 'text',
								'label'   => 'Hero Title',
								'default' => 'Welcome to WPMoo Starter',
							),
							array(
								'id'      => 'hero_enabled',
								'type'    => 'checkbox',
								'label'   => 'Display Hero Section',
								'default' => 1,
							),
						),
					),
					array(
						'title'  => 'Feature Strip',
						'fields' => array(
							array(
								'id'      => 'features_heading',
								'type'    => 'text',
								'label'   => 'Heading',
								'default' => 'Why Customers Love Us',
							),
							array(
								'id'      => 'features_note',
								'type'    => 'textarea',
								'label'   => 'Supporting Copy',
								'default' => 'Highlight two or three value propositions for your users.',
								'args'    => array( 'rows' => 3 ),
							),
						),
					),
				)
			);

		$container->register();
	}
}
