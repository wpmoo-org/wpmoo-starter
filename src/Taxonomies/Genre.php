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
	return;
}

/**
 * Registers the "genre" taxonomy and maps it to events.
 */
class Genre {
	/**
	 * Whether the taxonomy registration has been scheduled.
	 *
	 * @var bool
	 */
	protected static $registered = false;

	/**
	 * Register the taxonomy.
	 *
	 * @return void
	 */
	public static function register(): void {
		if ( self::$registered ) {
			return;
		}

		self::$registered = true;

		if ( did_action( 'init' ) ) {
			self::boot();
			return;
		}

		add_action( 'init', array( __CLASS__, 'boot' ) );
	}

	/**
	 * Perform the actual taxonomy registration.
	 *
	 * @return void
	 */
	public static function boot(): void {
		$taxonomy = Taxonomy::create( 'genre' )
			->singular( __( 'Genre', 'wpmoo-starter' ) )
			->plural( __( 'Genres', 'wpmoo-starter' ) )
			->description( __( 'Group events by genre or category.', 'wpmoo-starter' ) )
			->hierarchical( false )
			->public()
			->showInRest()
			->rewrite( array( 'slug' => 'event-genre' ) )
			->attachTo( array( 'event' ) );

		// Add custom columns to genre taxonomy admin.
		$taxonomy->columns()
			->add( 'event_count', __( 'Events', 'wpmoo-starter' ) )
			->populate( 'event_count', array( self::class, 'populate_event_count' ) )
			->sortable( 'event_count', array( 'event_count', true ) )
			->add( 'featured', __( 'Featured', 'wpmoo-starter' ) )
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
		// Fast path: use term_taxonomy count (taxonomy is attached only to 'event').
		$term  = get_term( (int) $term_id, 'genre' );
		$count = ( $term && ! is_wp_error( $term ) ) ? (int) $term->count : 0;

		$label = _n( 'event', 'events', $count, 'wpmoo-starter' );

		return '<strong>' . intval( $count ) . '</strong> ' . esc_html( $label );
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
			return '<span style="color: #46b450;">★ ' . esc_html__( 'Featured', 'wpmoo-starter' ) . '</span>';
		}

		return '<span style="color: #ddd;">—</span>';
	}
}
