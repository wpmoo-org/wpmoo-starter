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
		PostType::register( 'event' )
			->singular( 'Event' )
			->plural( 'Events' )
			->description( 'Manage upcoming events published by the starter plugin.' )
			->slug( 'events' )
			->public()
			->showInRest()
			->supports( array( 'title', 'editor', 'thumbnail', 'excerpt' ) )
			->menuIcon( 'dashicons-calendar-alt' )
			->taxonomy( 'genre' )
			->hasArchive()
			->register();
	}
}
