<?php
/**
 * Bootstrap code for the WPMoo starter plugin.
 *
 * @package WPMooStarter
 * @since 0.1.0
 * @version 0.2.0
 */

use WPMoo\Database\Query;
use WPMoo\Options\Options;
use WPMooStarter\Admin\FakeDataPage;
use WPMooStarter\Models\Book;
use WPMooStarter\Pages\Settings\Settings as SettingsPage;
use WPMooStarter\PostTypes\Event;
use WPMooStarter\Taxonomies\Genre;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'is_admin' ) || is_admin() ) {
    SettingsPage::register();
    FakeDataPage::init();
}

Event::register();
Genre::register();