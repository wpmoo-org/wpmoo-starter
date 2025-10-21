<?php
/**
 * Main settings container for the starter plugin.
 *
 * @package WPMooStarter\Pages\Settings
 */

namespace WPMooStarter\Pages\Settings;

use WPMoo\Options\Options;
use WPMooStarter\Pages\Settings\Sections\Accordion;
use WPMooStarter\Pages\Settings\Sections\Color;
use WPMooStarter\Pages\Settings\Sections\Text;
use WPMooStarter\Pages\Settings\Sections\Textarea;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the options container and example sections.
 */
class Settings {
	/**
	 * Register the starter settings container and example sections.
	 *
	 * @return void
	 */
	public static function register(): void {
		$container = Options::register( 'wpmoo_starter_settings' )
			->pageTitle( 'Starter Settings' )
			->menuTitle( 'WPMoo Starter' )
			->menuSlug( 'wpmoo-starter-settings' )
			->capability( 'manage_options' );

		Text::register( $container );
		Textarea::register( $container );
		Color::register( $container );
		Accordion::register( $container );

		$container->register();
	}
}
