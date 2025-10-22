<?php
/**
 * Bootstrap code for the WPMoo starter plugin.
 *
 * @package WPMooStarter
 * @since 0.1.0
 * @version 0.2.0
 */

use WPMoo\Database\Query;
use WPMoo\Moo;
use WPMoo\Options\Field;
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
	add_action( 'admin_init', 'wpmoo_starter_register_event_type_metabox' );
}

/**
 * Register Event Type metabox using WPMoo builder.
 *
 * @return void
 */
function wpmoo_starter_register_event_type_metabox(): void {
	$metabox = Moo::metabox( 'wpmoo_event_type', __( 'Event Details', 'wpmoo-starter' ) )
		->description( __( 'Capture event metadata shown in custom columns and templates.', 'wpmoo-starter' ) )
		->postType( array( 'post', 'event' ) )
		->panel()
		->context( 'normal' )
		->priority( 'default' );

	$details = $metabox->section( 'event_details', __( 'Details', 'wpmoo-starter' ) )
		->description( __( 'Key information about the event.', 'wpmoo-starter' ) );

	$details->fields(
		Field::text( 'event_type', __( 'Event Type', 'wpmoo-starter' ) )
			->description( __( 'Examples: conference, workshop, webinar.', 'wpmoo-starter' ) )
			->placeholder( __( 'Conference', 'wpmoo-starter' ) ),

		Field::text( 'event_location', __( 'Location', 'wpmoo-starter' ) )
			->placeholder( __( 'Berlin, Germany', 'wpmoo-starter' ) )
	);

	$schedule = $metabox->section( 'event_schedule', __( 'Schedule', 'wpmoo-starter' ) )
		->description( __( 'Timing and capacity details.', 'wpmoo-starter' ) )
		->icon( 'dashicons-clock' );

	$schedule->fields(
		Field::text( 'event_date', __( 'Event Date', 'wpmoo-starter' ) )
			->description( __( 'Choose the start date for the event.', 'wpmoo-starter' ) ),

		Field::text( 'event_capacity', __( 'Capacity', 'wpmoo-starter' ) )
			->description( __( 'Total seats or registrations available.', 'wpmoo-starter' ) )
			->placeholder( __( '200', 'wpmoo-starter' ) )
	);

	$metabox->registerOnInit();
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
