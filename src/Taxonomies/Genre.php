<?php
/**
 * Example Genre taxonomy registered with WPMoo builder.
 *
 * @package WPMooStarter\Taxonomies
 * @since 0.2.0
 */

namespace WPMooStarter\Taxonomies;

use WPMoo\Taxonomy\Taxonomy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the "genre" taxonomy and maps it to events.
 */
class Genre {
	/**
	 * Register the taxonomy.
	 *
	 * @return void
	 */
	public static function register(): void {
		Taxonomy::register( 'genre' )
			->singular( 'Genre' )
			->plural( 'Genres' )
			->description( 'Group events by genre or category.' )
			->hierarchical( false )
			->public()
			->showInRest()
			->rewrite( array( 'slug' => 'event-genre' ) )
			->attachTo( array( 'event' ) )
			->register();
	}
}
