<?php
/**
 * Example Event post type registered with WPMoo PostType builder.
 *
 * @package WPMooStarter\PostTypes
 * @since 0.2.0
 */

namespace WPMooStarter\PostTypes;

use WPMoo\PostType\PostType;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the "event" custom post type.
 */
class Event {
	/**
	 * Register the post type using the fluent builder.
	 *
	 * @return void
	 */
	public static function register(): void {
		$event = PostType::create( 'event' )
			->singular( 'Event' )
			->plural( 'Events' )
			->description( 'Manage upcoming events published by the starter plugin.' )
			->slug( 'events' )
			->public()
			->showInRest()
			->supports( array( 'title', 'editor', 'thumbnail', 'excerpt' ) )
			->menuIcon( 'dashicons-calendar-alt' )
			->taxonomy( 'genre' )
			->hasArchive();

		// Add custom columns.
		$event->columns()
			->add( 'genre', 'Genre' )
			->populate( 'genre', array( self::class, 'populate_genre_column' ) )
			->add( 'event_date', 'Event Date' )
			->populate( 'event_date', array( self::class, 'populate_date_column' ) )
			->sortable( 'event_date', array( 'event_date', true ) )
			->add( 'location', 'Location' )
			->populate( 'location', array( self::class, 'populate_location_column' ) )
			->add( 'capacity', 'Capacity' )
			->populate( 'capacity', array( self::class, 'populate_capacity_column' ) )
			->sortable( 'capacity', array( 'event_capacity', true ) )
			->hide( array( 'date' ) );

		$event->register();
	}

	/**
	 * Populate genre column.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 * @return void
	 */
	public static function populate_genre_column( $column, $post_id ): void {
		$terms = get_the_terms( $post_id, 'genre' );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			echo '<span style="color: #ddd;">—</span>';
			return;
		}

		$genre_links = array();
		foreach ( $terms as $term ) {
			$icon = get_term_meta( $term->term_id, 'genre_icon', true );
			$icon_html = $icon ? "<span class='dashicons {$icon}' style='font-size: 16px; vertical-align: text-bottom;'></span> " : '';
			$genre_links[] = sprintf(
				'<a href="%s">%s%s</a>',
				esc_url( admin_url( 'edit.php?post_type=event&genre=' . $term->slug ) ),
				$icon_html,
				esc_html( $term->name )
			);
		}

		echo implode( ', ', $genre_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Populate event date column.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 * @return void
	 */
	public static function populate_date_column( $column, $post_id ): void {
		$timestamp = get_post_meta( $post_id, 'event_date', true );

		if ( ! $timestamp ) {
			echo '<span style="color: #ddd;">—</span>';
			return;
		}

		$date = date_i18n( 'M j, Y', $timestamp );
		$time_diff = human_time_diff( $timestamp, time() );

		if ( $timestamp > time() ) {
			echo '<strong style="color: #2271b1;">' . esc_html( $date ) . '</strong><br>';
			echo '<small>in ' . esc_html( $time_diff ) . '</small>';
		} else {
			echo '<span style="color: #999;">' . esc_html( $date ) . '</span><br>';
			echo '<small>' . esc_html( $time_diff ) . ' ago</small>';
		}
	}

	/**
	 * Populate location column.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 * @return void
	 */
	public static function populate_location_column( $column, $post_id ): void {
		$location = get_post_meta( $post_id, 'event_location', true );

		if ( ! $location ) {
			echo '<span style="color: #ddd;">—</span>';
			return;
		}

		echo '<span class="dashicons dashicons-location" style="color: #2271b1; vertical-align: text-bottom;"></span> ';
		echo esc_html( $location );
	}

	/**
	 * Populate capacity column.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 * @return void
	 */
	public static function populate_capacity_column( $column, $post_id ): void {
		$capacity = get_post_meta( $post_id, 'event_capacity', true );
		$registered = get_post_meta( $post_id, 'event_registered', true );

		if ( ! $capacity ) {
			echo '<span style="color: #ddd;">—</span>';
			return;
		}

		$percentage = $registered ? ( $registered / $capacity ) * 100 : 0;
		$color = '#10b981'; // Green

		if ( $percentage > 80 ) {
			$color = '#ef4444'; // Red
		} elseif ( $percentage > 50 ) {
			$color = '#f59e0b'; // Orange
		}

		echo '<div style="margin-bottom: 5px;">';
		echo '<strong>' . esc_html( number_format( $registered ) ) . '</strong> / ' . esc_html( number_format( $capacity ) );
		echo '</div>';

		// Progress bar.
		echo '<div style="background: #f0f0f1; height: 6px; border-radius: 3px; overflow: hidden;">';
		echo '<div style="background: ' . esc_attr( $color ) . '; width: ' . esc_attr( min( $percentage, 100 ) ) . '%; height: 100%;"></div>';
		echo '</div>';
		echo '<small style="color: #666;">' . esc_html( number_format( $percentage, 1 ) ) . '% full</small>';
	}
}
