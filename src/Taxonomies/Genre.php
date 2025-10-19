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
		$taxonomy = Taxonomy::register( 'genre' )
			->singular( 'Genre' )
			->plural( 'Genres' )
			->description( 'Group events by genre or category.' )
			->hierarchical( false )
			->public()
			->showInRest()
			->rewrite( array( 'slug' => 'event-genre' ) )
			->attachTo( array( 'event' ) );

		// Add custom columns to genre taxonomy admin.
		$taxonomy->columns()
			->add( 'event_count', 'Events' )
			->populate( 'event_count', array( self::class, 'populate_event_count' ) )
			->sortable( 'event_count', array( 'event_count', true ) )
			->add( 'featured', 'Featured' )
			->populate( 'featured', array( self::class, 'populate_featured' ) )
			->sortable( 'featured', 'featured_genre' );

		$taxonomy->register();
	}

	/**
	 * Populate event count column.
	 *
	 * @param string $content  Column content.
	 * @param string $column   Column name.
	 * @param int    $term_id  Term ID.
	 * @return string
	 */
	public static function populate_event_count( $content, $column, $term_id ) {
		$count = wp_count_posts( 'event' ); // You could make this more precise.
		$term  = get_term( $term_id, 'genre' );
		
		// Get actual count for this genre.
		$query = new \WP_Query(
			array(
				'post_type'      => 'event',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'tax_query'      => array(
					array(
						'taxonomy' => 'genre',
						'terms'    => $term_id,
					),
				),
			)
		);

		$count = $query->found_posts;
		wp_reset_postdata();

		return '<strong>' . $count . '</strong> event' . ( $count !== 1 ? 's' : '' );
	}

	/**
	 * Populate featured column.
	 *
	 * @param string $content  Column content.
	 * @param string $column   Column name.
	 * @param int    $term_id  Term ID.
	 * @return string
	 */
	public static function populate_featured( $content, $column, $term_id ) {
		$featured = get_term_meta( $term_id, 'featured_genre', true );
		
		if ( $featured ) {
			return '<span style="color: #46b450;">★ Featured</span>';
		}
		
		return '<span style="color: #ddd;">—</span>';
	}
}
