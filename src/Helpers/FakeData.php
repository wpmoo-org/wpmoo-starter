<?php
/**
 * Generate fake data for Events and Genres.
 *
 * @package WPMooStarter\Helpers
 * @since 0.2.0
 */

namespace WPMooStarter\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Fake data generator for testing.
 */
class FakeData {
	/**
	 * Genre data with icons and featured status.
	 *
	 * @var array<int, array<string, mixed>>
	 */
	private static $genres = [
		[
			'name'     => 'Music Concert',
			'slug'     => 'music-concert',
			'featured' => true,
			'icon'     => 'dashicons-format-audio',
		],
		[
			'name'     => 'Tech Conference',
			'slug'     => 'tech-conference',
			'featured' => true,
			'icon'     => 'dashicons-laptop',
		],
		[
			'name'     => 'Art Exhibition',
			'slug'     => 'art-exhibition',
			'featured' => false,
			'icon'     => 'dashicons-art',
		],
		[
			'name'     => 'Sports Event',
			'slug'     => 'sports-event',
			'featured' => false,
			'icon'     => 'dashicons-awards',
		],
		[
			'name'     => 'Food Festival',
			'slug'     => 'food-festival',
			'featured' => true,
			'icon'     => 'dashicons-food',
		],
		[
			'name'     => 'Theater',
			'slug'     => 'theater',
			'featured' => false,
			'icon'     => 'dashicons-tickets-alt',
		],
		[
			'name'     => 'Workshop',
			'slug'     => 'workshop',
			'featured' => false,
			'icon'     => 'dashicons-admin-tools',
		],
		[
			'name'     => 'Networking',
			'slug'     => 'networking',
			'featured' => true,
			'icon'     => 'dashicons-groups',
		],
	];

	/**
	 * Event titles and descriptions.
	 *
	 * @var array<int, array<string, mixed>>
	 */
	private static $events = [
		[
			'title'       => 'Summer Music Festival 2025',
			'content'     => 'Join us for an incredible summer music festival featuring top artists from around the world. '
				. 'Three days of non-stop entertainment with multiple stages and food vendors.',
			'genre'       => 'music-concert',
			'date'        => '+15 days',
			'location'    => 'Central Park, New York',
			'capacity'    => 5000,
			'price'       => 149.99,
		],
		[
			'title'       => 'WordPress Developer Summit',
			'content'     => 'A premier conference for WordPress developers, designers, and business owners. '
				. 'Learn about the latest trends, best practices, and network with industry leaders.',
			'genre'       => 'tech-conference',
			'date'        => '+30 days',
			'location'    => 'San Francisco Convention Center',
			'capacity'    => 1200,
			'price'       => 299.00,
		],
		[
			'title'       => 'Modern Art Gallery Opening',
			'content'     => 'Experience the grand opening of our contemporary art gallery featuring works from emerging artists. '
				. 'Free admission on opening night with refreshments provided.',
			'genre'       => 'art-exhibition',
			'date'        => '+7 days',
			'location'    => 'Downtown Art District',
			'capacity'    => 300,
			'price'       => 0,
		],
		[
			'title'       => 'City Marathon 2025',
			'content'     => 'Annual city marathon open to runners of all levels. 10K, Half Marathon, and Full Marathon options available. '
				. 'Register early for discounted rates.',
			'genre'       => 'sports-event',
			'date'        => '+45 days',
			'location'    => 'City Center',
			'capacity'    => 10000,
			'price'       => 50.00,
		],
		[
			'title'       => 'International Food & Wine Expo',
			'content'     => 'Taste cuisines from over 50 countries, attend cooking demonstrations by celebrity chefs, '
				. 'and explore the finest wines from around the globe.',
			'genre'       => 'food-festival',
			'date'        => '+20 days',
			'location'    => 'Harbor Convention Center',
			'capacity'    => 3000,
			'price'       => 75.00,
		],
		[
			'title'       => 'Shakespeare in the Park',
			'content'     => 'Classic outdoor theater production of Romeo and Juliet. '
				. 'Bring your blankets and picnic baskets for a magical evening under the stars.',
			'genre'       => 'theater',
			'date'        => '+10 days',
			'location'    => 'Riverside Park Amphitheater',
			'capacity'    => 800,
			'price'       => 25.00,
		],
		[
			'title'       => 'Digital Marketing Workshop',
			'content'     => 'Hands-on workshop covering SEO, social media marketing, content strategy, and analytics. '
				. 'Perfect for beginners and intermediate marketers.',
			'genre'       => 'workshop',
			'date'        => '+5 days',
			'location'    => 'Tech Hub Co-working Space',
			'capacity'    => 50,
			'price'       => 199.00,
		],
		[
			'title'       => 'Startup Founders Meetup',
			'content'     => 'Monthly networking event for startup founders, entrepreneurs, and investors. '
				. 'Share experiences, find co-founders, and make valuable connections.',
			'genre'       => 'networking',
			'date'        => '+3 days',
			'location'    => 'Innovation District',
			'capacity'    => 150,
			'price'       => 20.00,
		],
		[
			'title'       => 'Jazz Night Under the Stars',
			'content'     => 'Intimate jazz evening featuring local and international jazz musicians. '
				. 'Enjoy smooth tunes while dining at our outdoor venue.',
			'genre'       => 'music-concert',
			'date'        => '+12 days',
			'location'    => 'Rooftop Garden',
			'capacity'    => 200,
			'price'       => 65.00,
		],
		[
			'title'       => 'AI & Machine Learning Conference',
			'content'     => 'Cutting-edge conference exploring the future of artificial intelligence and machine learning. '
				. 'Featuring keynotes from tech giants and hands-on labs.',
			'genre'       => 'tech-conference',
			'date'        => '+60 days',
			'location'    => 'Silicon Valley Tech Center',
			'capacity'    => 2000,
			'price'       => 499.00,
		],
		[
			'title'       => 'Local Artists Showcase',
			'content'     => 'Monthly showcase celebrating local talent across various art forms including painting, '
				. 'sculpture, photography, and digital art.',
			'genre'       => 'art-exhibition',
			'date'        => '+8 days',
			'location'    => 'Community Arts Center',
			'capacity'    => 250,
			'price'       => 10.00,
		],
		[
			'title'       => 'Beach Volleyball Tournament',
			'content'     => 'Summer beach volleyball tournament with prizes for winners. '
				. 'Amateur and professional divisions available. Spectators welcome!',
			'genre'       => 'sports-event',
			'date'        => '+25 days',
			'location'    => 'Sunset Beach',
			'capacity'    => 500,
			'price'       => 40.00,
		],
		[
			'title'       => 'Street Food Festival',
			'content'     => 'Weekend-long street food festival featuring the best food trucks and street vendors in the city. '
				. 'Live music and family-friendly activities.',
			'genre'       => 'food-festival',
			'date'        => '+18 days',
			'location'    => 'Main Street Plaza',
			'capacity'    => 5000,
			'price'       => 0,
		],
		[
			'title'       => 'Broadway Musical Night',
			'content'     => 'Experience the magic of Broadway with performances from award-winning musicals. '
				. 'Special guest appearances and interactive Q&A session.',
			'genre'       => 'theater',
			'date'        => '+35 days',
			'location'    => 'Grand Theater',
			'capacity'    => 1500,
			'price'       => 85.00,
		],
		[
			'title'       => 'Photography Masterclass',
			'content'     => 'Full-day photography workshop covering composition, lighting, post-processing, and portfolio building. '
				. 'Bring your camera!',
			'genre'       => 'workshop',
			'date'        => '+14 days',
			'location'    => 'Photography Studio Downtown',
			'capacity'    => 30,
			'price'       => 249.00,
		],
	];

	/**
	 * Generate all fake data.
	 *
	 * @return array<string, array<int, int>> Results summary (created IDs by group).
	 */
	public static function generate_all(): array {
		$results = [
			'genres' => self::generate_genres(),
			'events' => self::generate_events(),
		];

		return $results;
	}

	/**
	 * Generate genre terms.
	 *
	 * @return array<int, int> Created genre IDs.
	 */
	public static function generate_genres(): array {
		$created = [];

		foreach ( self::$genres as $genre_data ) {
			// Check if term already exists.
			$existing = term_exists( $genre_data['slug'], 'genre' );

			if ( $existing ) {
				$term_id = $existing['term_id'];
			} else {
				$result = wp_insert_term(
					$genre_data['name'],
					'genre',
					[
						'slug' => $genre_data['slug'],
					]
				);

				if ( is_wp_error( $result ) ) {
					continue;
				}

				$term_id = $result['term_id'];
			}

			// Update term meta.
			update_term_meta( $term_id, 'featured_genre', $genre_data['featured'] ? '1' : '' );
			update_term_meta( $term_id, 'genre_icon', $genre_data['icon'] );

			$created[] = $term_id;
		}

		return $created;
	}

	/**
	 * Generate event posts.
	 *
	 * @return array<int, int> Created post IDs.
	 */
	public static function generate_events(): array {
		$created = [];

		foreach ( self::$events as $event_data ) {
			// Check if event already exists.
			$existing = null;
			$query    = new \WP_Query(
				[
					'post_type'      => 'event',
					'posts_per_page' => 10,
					's'              => $event_data['title'],
					'fields'         => 'ids',
				]
			);

			if ( $query->have_posts() ) {
				foreach ( $query->posts as $maybe_id ) {
					if ( get_the_title( $maybe_id ) === $event_data['title'] ) {
						$existing = get_post( $maybe_id );
						break;
					}
				}
				wp_reset_postdata();
			}

			if ( $existing ) {
				$post_id = $existing->ID;
			} else {
				$post_id = wp_insert_post(
					[
						'post_title'   => $event_data['title'],
						'post_content' => $event_data['content'],
						'post_status'  => 'publish',
						'post_type'    => 'event',
						'post_author'  => 1,
					]
				);

				if ( is_wp_error( $post_id ) ) {
					continue;
				}
			}

			// Assign genre.
			wp_set_object_terms( $post_id, $event_data['genre'], 'genre' );

			// Add event meta.
			$event_date = strtotime( $event_data['date'] );
			update_post_meta( $post_id, 'event_date', $event_date );
			update_post_meta( $post_id, 'event_location', $event_data['location'] );
			update_post_meta( $post_id, 'event_capacity', $event_data['capacity'] );
			update_post_meta( $post_id, 'event_price', $event_data['price'] );

			// Generate random registration count (0-80% capacity).
			$registered = wp_rand( 0, (int) ( $event_data['capacity'] * 0.8 ) );
			update_post_meta( $post_id, 'event_registered', $registered );

			$created[] = $post_id;
		}

		return $created;
	}

	/**
	 * Delete all fake data.
	 *
	 * @return array Results summary.
	 */
	public static function delete_all(): array {
		$results = [
			'events' => self::delete_events(),
			'genres' => self::delete_genres(),
		];

		return $results;
	}

	/**
	 * Delete all events.
	 *
	 * @return int Number of deleted events.
	 */
	public static function delete_events(): int {
		$events = get_posts(
			[
				'post_type'      => 'event',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			]
		);

		$deleted = 0;
		foreach ( $events as $event_id ) {
			if ( wp_delete_post( $event_id, true ) ) {
				++$deleted;
			}
		}

		return $deleted;
	}

	/**
	 * Delete all genres.
	 *
	 * @return int Number of deleted genres.
	 */
	public static function delete_genres(): int {
		$genres = get_terms(
			[
				'taxonomy'   => 'genre',
				'hide_empty' => false,
				'fields'     => 'ids',
			]
		);

		$deleted = 0;
		foreach ( $genres as $term_id ) {
			if ( wp_delete_term( $term_id, 'genre' ) ) {
				++$deleted;
			}
		}

		return $deleted;
	}
}
