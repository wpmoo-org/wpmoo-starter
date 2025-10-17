<?php
/**
 * Bootstrap code for the WPMoo starter plugin.
 *
 * @package WPMooStarter
 * @since 0.1.0
 * @version 0.1.0
 */

use WPMoo\Database\Query;
use WPMoo\Metabox\Metabox;
use WPMoo\Options\Options;
use WPMooStarter\Models\Book;

if ( ! function_exists( 'is_admin' ) || is_admin() ) {
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
