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
use WPMoo\PostTypes\PostType;
use WPMoo\Taxonomies\Taxonomy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'is_admin' ) || is_admin() ) {
    SettingsPage::register();
    FakeDataPage::init();
}

// Create a book post type.
$events = new PostType( 'event' );

// Attach the genre taxonomy (which is created below).
$events->taxonomy( 'genre' );

// Hide the date and author columns.
$events->column()->hide( [ 'date', 'author' ] );

// Set the Events menu icon.
$events->icon( 'dashicons-book-alt' );

// Register the post type to WordPress.
$events->register();

// Create a genre taxonomy.
$genres = new Taxonomy( 'genre' );

// Set options for the taxonomy.
$genres->options( [
    'hierarchical' => false,
] );

// Register the taxonomy to WordPress.
$genres->register();