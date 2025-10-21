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
	Event::register();
	Genre::register();
}



// Run after WPMoo init.
add_action(
	'wpmoo_init',
	function () {
		$books_enabled = (bool) Options::value(
			'wpmoo_starter_settings',
			'books_toggle',
			Options::value( 'wpmoo_starter_settings', 'enable_books', 1 )
		);
		if ( $books_enabled ) {
			$book = new Book(
				array(
					'title'  => 'Starter Book',
					'author' => 'Ahmet',
				)
			);
			$book->save();
		}

		$query = Query::table( 'wp_posts' )
			->where( 'post_status', 'publish' )
			->limit( 3 )
			->get();

		foreach ( $query as $post ) {
			error_log( 'Post: ' . $post->post_title ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		}
	}
);
