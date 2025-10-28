<?php
/**
 * Example Event post type registered with WPMoo PostType builder.
 *
 * @package WPMooStarter\PostTypes
 * @since 0.2.0
 */

// phpcs:disable WordPress.Files.FileName

namespace WPMooStarter\PostTypes;

use WPMoo\Moo;
use WPMoo\Options\Field;
use WPMoo\PostType\PostType;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Registers the "event" custom post type.
 */
class Event {
	/**
	 * Tracks whether the registration has been scheduled.
	 *
	 * @var bool
	 */
	protected static $registered = false;

	/**
	 * Register the post type using the fluent builder.
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
	 * Perform the actual post type registration.
	 *
	 * @return void
	 */
	public static function boot(): void {
		$event = PostType::create( 'event' )
			->singular( __( 'Event', 'wpmoo-starter' ) )
			->plural( __( 'Events', 'wpmoo-starter' ) )
			->description( __( 'Manage upcoming events published by the starter plugin.', 'wpmoo-starter' ) )
			->slug( 'events' )
			->public()
			->showInRest()
			->supports( array( 'title', 'editor', 'thumbnail', 'excerpt' ) )
			->menuIcon( 'dashicons-calendar-alt' )
			->taxonomy( 'genre' )
			->hasArchive();

		// Add custom columns.
		$event->columns()
			->add( 'genre', __( 'Genre', 'wpmoo-starter' ) )
			->populate( 'genre', array( self::class, 'populate_genre_column' ) )
			->add( 'event_date', __( 'Event Date', 'wpmoo-starter' ) )
			->populate( 'event_date', array( self::class, 'populate_date_column' ) )
			->sortable( 'event_date', array( 'event_date', true ) )
			->add( 'location', __( 'Location', 'wpmoo-starter' ) )
			->populate( 'location', array( self::class, 'populate_location_column' ) )
			->add( 'capacity', __( 'Capacity', 'wpmoo-starter' ) )
			->populate( 'capacity', array( self::class, 'populate_capacity_column' ) )
			->sortable( 'capacity', array( 'event_capacity', true ) )
			->hide( array( 'date' ) );

		$event->register();

		self::register_metabox();
	}

	/**
	 * Register the Event metabox using WPMoo builders.
	 *
	 * @return void
	 */
	public static function register_metabox(): void {
		$metabox = Moo::panel( 'wpmoo_event_type', __( 'Event Details', 'wpmoo-starter' ) )
			->description( __( 'Capture event metadata shown in custom columns and templates.', 'wpmoo-starter' ) )
			->postType( array( 'post', 'event' ) )
			->context( 'normal' )
			->priority( 'default' );

		Moo::section( 'event_details', __( 'Details', 'wpmoo-starter' ) )
			->metabox( $metabox )
			->description(
				__( 'Key information about the event.', 'wpmoo-starter' )
			)
			->fields(
				Field::text( 'event_type', __( 'Event Type', 'wpmoo-starter' ) )
					->description( __( 'Examples: conference, workshop, webinar.', 'wpmoo-starter' ) )
					->placeholder( __( 'Conference', 'wpmoo-starter' ) ),
				Field::text( 'event_location', __( 'Location', 'wpmoo-starter' ) )
					->placeholder( __( 'Berlin, Germany', 'wpmoo-starter' ) )
			);

		Moo::section( 'event_schedule', __( 'Schedule', 'wpmoo-starter' ) )
			->metabox( $metabox )
			->description(
				__( 'Timing and capacity details.', 'wpmoo-starter' )
			)
			->icon( 'dashicons-clock' )
			->fields(
				Field::text( 'event_date', __( 'Event Date', 'wpmoo-starter' ) )
					->description( __( 'Choose the start date for the event.', 'wpmoo-starter' ) ),
				Field::text( 'event_capacity', __( 'Capacity', 'wpmoo-starter' ) )
					->description( __( 'Total seats or registrations available.', 'wpmoo-starter' ) )
					->placeholder( __( '200', 'wpmoo-starter' ) )
			);
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
			$icon      = get_term_meta( $term->term_id, 'genre_icon', true );
			$icon_html = '';

			if ( $icon ) {
				$icon_html = sprintf(
					"<span class='dashicons %s' style='font-size: 16px; vertical-align: text-bottom;'></span> ",
					esc_attr( $icon )
				);
			}

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

		$date      = date_i18n( 'M j, Y', $timestamp );
		$time_diff = human_time_diff( $timestamp, time() );

		if ( $timestamp > time() ) {
			echo '<strong style="color: #2271b1;">' . esc_html( $date ) . '</strong><br>';
			/* translators: %s: Human readable time difference. */
			$message = sprintf( __( 'in %s', 'wpmoo-starter' ), $time_diff );
			echo '<small>' . esc_html( $message ) . '</small>';
		} else {
			echo '<span style="color: #999;">' . esc_html( $date ) . '</span><br>';
			/* translators: %s: Human readable time difference. */
			$message = sprintf( __( '%s ago', 'wpmoo-starter' ), $time_diff );
			echo '<small>' . esc_html( $message ) . '</small>';
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
		$capacity   = get_post_meta( $post_id, 'event_capacity', true );
		$registered = get_post_meta( $post_id, 'event_registered', true );

		if ( ! $capacity ) {
			echo '<span style="color: #ddd;">—</span>';
			return;
		}

		$percentage = $registered ? ( $registered / $capacity ) * 100 : 0;
		$color      = '#10b981'; // Green.

		if ( $percentage > 80 ) {
			$color = '#ef4444'; // Red.
		} elseif ( $percentage > 50 ) {
			$color = '#f59e0b'; // Orange.
		}

		echo '<div style="margin-bottom: 5px;">';
		echo '<strong>' . esc_html( number_format( $registered ) ) . '</strong> / ' . esc_html( number_format( $capacity ) );
		echo '</div>';

		// Progress bar.
        echo '<div style="background: #f0f0f1; height: 6px; border-radius: 3px; overflow: hidden;">';
        $width = (string) min( (int) $percentage, 100 );
        echo '<div style="background: ' . esc_attr( $color ) . '; width: ' . esc_attr( $width ) . '%; height: 100%;"></div>';
		echo '</div>';
		/* translators: %s: Percentage of seats filled. */
		$full_text = sprintf( __( '%s%% full', 'wpmoo-starter' ), number_format( $percentage, 1 ) );
		echo '<small style="color: #666;">' . esc_html( $full_text ) . '</small>';
	}
}
