<?php
/**
 * Bootstrap code for the WPMoo starter plugin.
 *
 * @package WPMooStarter
 * @since 0.1.0
 * @version 0.2.0
 */

use WPMoo\Database\Query;
use WPMoo\Metabox\Metabox;
use WPMoo\Options\Options;
use WPMooStarter\Models\Book;
use WPMooStarter\Pages\Settings;
use WPMooStarter\PostTypes\Event;
use WPMooStarter\Taxonomies\Genre;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'is_admin' ) || is_admin() ) {
	Settings::register();

	Metabox::register(
		array(
			'id'       => 'wpmoo_starter_metabox',
			'title'    => 'Starter Details',
			'screens'  => array( 'post' ),
			'context'  => 'side',
			'priority' => 'default',
			'fields'   => array(
				array(
					'id'          => 'wpmoo_starter_subtitle',
					'type'        => 'text',
					'label'       => 'Subtitle',
					'description' => 'Optional short subtitle for the post.',
					'default'     => '',
				),
				array(
					'id'          => 'wpmoo_starter_notes',
					'type'        => 'textarea',
					'label'       => 'Internal Notes',
					'description' => 'Private notes stored as post meta.',
					'default'     => '',
					'args'        => array(
						'rows' => 4,
					),
				),
				array(
					'id'          => 'wpmoo_starter_featured',
					'type'        => 'checkbox',
					'label'       => 'Mark as Featured',
					'description' => 'Example checkbox stored with the post.',
					'default'     => 0,
				),
			),
		)
	);
}

Event::register();
Genre::register();

// Run after WPMoo init.
add_action(
	'wpmoo_init',
	function () {
		$welcome = Options::value( 'wpmoo_starter_settings', 'welcome_text', 'Hello from WPMoo Starter Options!' );
		error_log( '🐮 WPMoo Starter Plugin initialized: ' . $welcome ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- Sample output for demonstration purposes.

		// Example query usage.
		$posts = Query::table( 'wp_posts' )->where( 'post_status', 'publish' )->limit( 3 )->get();

		foreach ( $posts as $post ) {
			error_log( 'Post: ' . $post->post_title ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- Sample output for demonstration purposes.
		}

		$books_enabled = (bool) Options::value( 'wpmoo_starter_settings', 'enable_books', 1 );

		// Example model usage.
		if ( $books_enabled ) {
			$book = new Book(
				array(
					'title'  => 'Starter Book',
					'author' => 'Ahmet',
				)
			);
			$book->save();
		}
	}
);

add_action(
	'wpmoo_activate',
	function () {
		global $wpdb;

		$table   = $wpdb->prefix . 'wpmoo_books';
		$charset = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS `$table` (
			`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`title` varchar(255) NOT NULL,
			`author` varchar(255) NOT NULL,
			`created_at` datetime DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) $charset;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}
);
