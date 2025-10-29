<?php
/**
 * Main settings container for the starter plugin.
 *
 * @package WPMooStarter\Pages\Settings
 */

namespace WPMooStarter\Pages\Settings;

use WPMoo\Moo;
use WPMooStarter\Pages\Settings\Sections\Accordion;
use WPMooStarter\Pages\Settings\Sections\Color;
use WPMooStarter\Pages\Settings\Sections\Text;
use WPMooStarter\Pages\Settings\Sections\Textarea;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Registers the options container and example sections.
 */
class Settings {
	/**
	 * Whether the boot routine has been scheduled.
	 *
	 * @var bool
	 */
	protected static $registered = false;

	/**
	 * Register the starter settings container and example sections.
	 *
	 * @return void
	 */
	public static function register(): void {
		if ( self::$registered ) {
			return;
		}

		self::$registered = true;

		if ( function_exists( 'did_action' ) && did_action( 'init' ) ) {
			self::boot();
			return;
		}

		add_action( 'init', array( __CLASS__, 'boot' ), 20 );
	}

	/**
	 * Perform the actual registration on init (translations are ready).
	 *
	 * @return void
	 */
	public static function boot(): void {
		Moo::page( 'wpmoo_starter_settings', __( 'Starter Settings', 'wpmoo-starter' ) )
			->menuTitle( __( 'WPMoo Starter', 'wpmoo-starter' ) )
			->menuSlug( 'wpmoo-starter-settings' )
			->capability( 'manage_options' );

		Text::register();
		Textarea::register();
		Color::register();
		Accordion::register();
	}
}
