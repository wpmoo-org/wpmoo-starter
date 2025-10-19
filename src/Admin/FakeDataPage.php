<?php
/**
 * Admin page for generating fake data.
 *
 * @package WPMooStarter\Admin
 * @since 0.2.0
 */

namespace WPMooStarter\Admin;

use WPMooStarter\Helpers\FakeData;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fake data admin page.
 */
class FakeDataPage {
	/**
	 * Initialize the admin page.
	 *
	 * @return void
	 */
	public static function init(): void {
		add_action( 'admin_menu', [ __CLASS__, 'add_menu' ] );
		add_action( 'admin_post_generate_fake_data', [ __CLASS__, 'handle_generate' ] );
		add_action( 'admin_post_delete_fake_data', [ __CLASS__, 'handle_delete' ] );
	}

	/**
	 * Add admin menu item.
	 *
	 * @return void
	 */
	public static function add_menu(): void {
		add_management_page(
			'Fake Data Generator',
			'Fake Data',
			'manage_options',
			'wpmoo-fake-data',
			[ __CLASS__, 'render_page' ]
		);

		// Add admin notices.
		add_action( 'admin_notices', [ __CLASS__, 'show_notices' ] );
	}

	/**
	 * Show admin notices.
	 *
	 * @return void
	 */
	public static function show_notices(): void {
		if ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'wpmoo-fake-data' ) {
			return;
		}

		if ( ! isset( $_GET['message'] ) ) {
			return;
		}

		$message = sanitize_text_field( wp_unslash( $_GET['message'] ) );

		if ( $message === 'generated' ) {
			$genres = isset( $_GET['genres'] ) ? (int) $_GET['genres'] : 0;
			$events = isset( $_GET['events'] ) ? (int) $_GET['events'] : 0;

			printf(
				'<div class="notice notice-success is-dismissible"><p><strong>✨ Success!</strong> Generated %d genres and %d events.</p></div>',
				esc_html( $genres ),
				esc_html( $events )
			);
		} elseif ( $message === 'deleted' ) {
			$genres = isset( $_GET['genres'] ) ? (int) $_GET['genres'] : 0;
			$events = isset( $_GET['events'] ) ? (int) $_GET['events'] : 0;

			printf(
				'<div class="notice notice-warning is-dismissible"><p><strong>🗑️ Deleted!</strong> Removed %d events and %d genres.</p></div>',
				esc_html( $events ),
				esc_html( $genres )
			);
		}
	}

	/**
	 * Render the admin page.
	 *
	 * @return void
	 */
	public static function render_page(): void {
		// Check permissions.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'wpmoo-starter' ) );
		}

		// Get existing counts.
		$event_count = wp_count_posts( 'event' );
		$genre_count = wp_count_terms( [ 'taxonomy' => 'genre', 'hide_empty' => false ] );

		?>
		<div class="wrap">
			<h1>🎭 WPMoo Fake Data Generator</h1>

			<div class="card" style="max-width: 800px;">
				<h2>📊 Current Status</h2>
				<table class="widefat" style="width: auto; min-width: 400px;">
					<tbody>
						<tr>
							<td><strong>Events:</strong></td>
							<td><?php echo esc_html( $event_count->publish ); ?> published</td>
						</tr>
						<tr>
							<td><strong>Genres:</strong></td>
							<td><?php echo esc_html( $genre_count ); ?> terms</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="card" style="max-width: 800px;">
				<h2>🎨 Generate Fake Data</h2>
				<p>This will create sample Events and Genres with custom columns and metadata.</p>
				
				<h3>What will be created:</h3>
				<ul style="list-style: disc; margin-left: 20px;">
					<li><strong>8 Genre terms</strong> with:
						<ul style="list-style: circle; margin-left: 20px;">
							<li>Featured status (for testing sortable columns)</li>
							<li>Custom icons (dashicons)</li>
							<li>Music Concert, Tech Conference, Art Exhibition, Sports Event, Food Festival, Theater, Workshop, Networking</li>
						</ul>
					</li>
					<li><strong>15 Event posts</strong> with:
						<ul style="list-style: circle; margin-left: 20px;">
							<li>Full content and descriptions</li>
							<li>Event dates (upcoming events)</li>
							<li>Location data</li>
							<li>Capacity and pricing</li>
							<li>Random registration numbers</li>
							<li>Genre assignments</li>
						</ul>
					</li>
				</ul>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'generate_fake_data', 'fake_data_nonce' ); ?>
					<input type="hidden" name="action" value="generate_fake_data">
					<p>
						<button type="submit" class="button button-primary button-hero">
							✨ Generate Fake Data
						</button>
					</p>
				</form>
			</div>

			<div class="card" style="max-width: 800px; border-left: 4px solid #dc3232;">
				<h2 style="color: #dc3232;">🗑️ Delete All Data</h2>
				<p><strong>Warning:</strong> This will permanently delete all Events and Genres!</p>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" 
					  onsubmit="return confirm('Are you sure you want to delete ALL Events and Genres? This cannot be undone!');">
					<?php wp_nonce_field( 'delete_fake_data', 'fake_data_nonce' ); ?>
					<input type="hidden" name="action" value="delete_fake_data">
					<p>
						<button type="submit" class="button button-secondary">
							🗑️ Delete All Events & Genres
						</button>
					</p>
				</form>
			</div>

			<div class="card" style="max-width: 800px; background: #f0f6fc;">
				<h2>💡 Quick Tips</h2>
				<ul style="list-style: disc; margin-left: 20px;">
					<li>Visit <strong>Events > All Events</strong> to see the generated events</li>
					<li>Visit <strong>Events > Genres</strong> to see custom columns in action:
						<ul style="list-style: circle; margin-left: 20px;">
							<li><strong>Events</strong> column shows event count per genre</li>
							<li><strong>Featured</strong> column shows featured status (★)</li>
							<li>Both columns are <strong>sortable</strong>!</li>
						</ul>
					</li>
					<li>Click on column headers to sort by different criteria</li>
					<li>Check event meta fields for additional data (date, location, capacity, etc.)</li>
				</ul>
			</div>
		</div>

		<style>
			.card {
				background: white;
				border: 1px solid #ccd0d4;
				box-shadow: 0 1px 1px rgba(0,0,0,.04);
				margin-top: 20px;
				padding: 20px;
			}
			.card h2 {
				margin-top: 0;
			}
			.card table {
				margin-top: 15px;
			}
			.card table td {
				padding: 10px;
			}
			.card table tr:nth-child(even) {
				background: #f9f9f9;
			}
		</style>
		<?php
	}

	/**
	 * Handle generate action.
	 *
	 * @return void
	 */
	public static function handle_generate(): void {
		// Check permissions and nonce.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions.', 'wpmoo-starter' ) );
		}

		check_admin_referer( 'generate_fake_data', 'fake_data_nonce' );

		// Generate data.
		$results = FakeData::generate_all();

		// Redirect with success message.
		wp_safe_redirect(
			add_query_arg(
				[
					'page'    => 'wpmoo-fake-data',
					'message' => 'generated',
					'genres'  => count( $results['genres'] ),
					'events'  => count( $results['events'] ),
				],
				admin_url( 'tools.php' )
			)
		);
		exit;
	}

	/**
	 * Handle delete action.
	 *
	 * @return void
	 */
	public static function handle_delete(): void {
		// Check permissions and nonce.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions.', 'wpmoo-starter' ) );
		}

		check_admin_referer( 'delete_fake_data', 'fake_data_nonce' );

		// Delete data.
		$results = FakeData::delete_all();

		// Redirect with success message.
		wp_safe_redirect(
			add_query_arg(
				[
					'page'    => 'wpmoo-fake-data',
					'message' => 'deleted',
					'genres'  => $results['genres'],
					'events'  => $results['events'],
				],
				admin_url( 'tools.php' )
			)
		);
		exit;
	}
}
