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
		Moo::make( 'page', 'wpmoo_starter_settings', 'Starter Settings' )
			->menuTitle( 'WPMoo Starter' )
			->menuSlug( 'wpmoo-starter-settings' )
			->capability( 'manage_options' );

		Text::register();
		Textarea::register();
		Color::register();
		Accordion::register();
	}
}
