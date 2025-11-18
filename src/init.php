<?php
/**
 * Bootstrap code for the WPMoo starter plugin.
 *
 * @package WPMooStarter
 * @since 0.1.0
 * @version 0.1.0
 */

use WPMooStarter\Pages\Settings\Settings as SettingsPage;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! function_exists( 'is_admin' ) || is_admin() ) {
	SettingsPage::register();
}
