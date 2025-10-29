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
	return;
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
			__( 'Fake Data Generator', 'wpmoo-starter' ),
			__( 'Fake Data', 'wpmoo-starter' ),
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

        // Verify a nonce to ensure the notice parameters come from our actions.
        if ( ! isset( $_GET['notice_nonce'] ) ) {
            return;
        }
        $notice_nonce = sanitize_text_field( wp_unslash( $_GET['notice_nonce'] ) );
        if ( ! wp_verify_nonce( $notice_nonce, 'wpmoo_fake_data_notice' ) ) {
            return;
        }

        if ( ! isset( $_GET['message'] ) ) {
            return;
        }

		$message = sanitize_text_field( wp_unslash( $_GET['message'] ) );

		if ( $message === 'generated' ) {
			$genres = isset( $_GET['genres'] ) ? (int) $_GET['genres'] : 0;
			$events = isset( $_GET['events'] ) ? (int) $_GET['events'] : 0;

            $headline = esc_html__( '✨ Success!', 'wpmoo-starter' );
            $body     = sprintf(
				// translators: 1: number of genres created, 2: number of events created.
				__( 'Generated %1$d genres and %2$d events.', 'wpmoo-starter' ),
				$genres,
				$events
			);

			printf(
				'<div class="notice notice-success is-dismissible"><p><strong>%s</strong> %s</p></div>',
				esc_html( $headline ),
				esc_html( $body )
			);
        } elseif ( $message === 'deleted' ) {
            $genres = isset( $_GET['genres'] ) ? (int) $_GET['genres'] : 0;
            $events = isset( $_GET['events'] ) ? (int) $_GET['events'] : 0;

			$headline = esc_html__( '🗑️ Deleted!', 'wpmoo-starter' );
			$body     = sprintf(
				// translators: 1: number of events deleted, 2: number of genres deleted.
				__( 'Removed %1$d events and %2$d genres.', 'wpmoo-starter' ),
				$events,
				$genres
			);

			printf(
				'<div class="notice notice-warning is-dismissible"><p><strong>%s</strong> %s</p></div>',
				esc_html( $headline ),
				esc_html( $body )
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
		$genre_count = wp_count_terms(
			[
				'taxonomy' => 'genre',
				'hide_empty' => false,
			]
		);

		?>
		<div class="wrap">
			<h1><?php esc_html_e( '🎭 WPMoo Fake Data Generator', 'wpmoo-starter' ); ?></h1>

			<div class="card" style="max-width: 800px;">
				<h2><?php esc_html_e( '📊 Current Status', 'wpmoo-starter' ); ?></h2>
				<table class="widefat" style="width: auto; min-width: 400px;">
					<tbody>
						<tr>
							<td><strong><?php esc_html_e( 'Events:', 'wpmoo-starter' ); ?></strong></td>
								<?php // translators: %d: number of published events. ?>
								<td><?php printf( esc_html__( '%d published', 'wpmoo-starter' ), (int) $event_count->publish ); ?></td>
						</tr>
						<tr>
							<td><strong><?php esc_html_e( 'Genres:', 'wpmoo-starter' ); ?></strong></td>
								<?php // translators: %d: number of terms in the Genre taxonomy. ?>
								<td><?php printf( esc_html__( '%d terms', 'wpmoo-starter' ), (int) $genre_count ); ?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="card" style="max-width: 800px;">
				<h2><?php esc_html_e( '🎨 Generate Fake Data', 'wpmoo-starter' ); ?></h2>
				<p><?php esc_html_e( 'This will create sample Events and Genres with custom columns and metadata.', 'wpmoo-starter' ); ?></p>
				
				<h3><?php esc_html_e( 'What will be created:', 'wpmoo-starter' ); ?></h3>
				<ul style="list-style: disc; margin-left: 20px;">
					<?php // translators: %s: number of genre terms to be created. ?>
					<li>
						<?php
							echo wp_kses_post(
								sprintf(
									// translators: %s: number of genre terms to be created.
									__( '<strong>%s Genre terms</strong> with:', 'wpmoo-starter' ),
									number_format_i18n( 8 )
								)
							);
						?>
						<ul style="list-style: circle; margin-left: 20px;">
							<li><?php esc_html_e( 'Featured status (for testing sortable columns)', 'wpmoo-starter' ); ?></li>
							<li><?php esc_html_e( 'Custom icons (dashicons)', 'wpmoo-starter' ); ?></li>
							<?php
							$genres_list = __(
								'Music Concert, Tech Conference, Art Exhibition, Sports Event, Food Festival, Theater, Workshop, Networking',
								'wpmoo-starter'
							);
							?>
							<li><?php echo esc_html( $genres_list ); ?></li>
						</ul>
					</li>
					<?php // translators: %s: number of event posts to be created. ?>
					<li>
						<?php
							echo wp_kses_post(
								sprintf(
									// translators: %s: number of event posts to be created.
									__( '<strong>%s Event posts</strong> with:', 'wpmoo-starter' ),
									number_format_i18n( 15 )
								)
							);
						?>
						<ul style="list-style: circle; margin-left: 20px;">
							<li><?php esc_html_e( 'Full content and descriptions', 'wpmoo-starter' ); ?></li>
							<li><?php esc_html_e( 'Event dates (upcoming events)', 'wpmoo-starter' ); ?></li>
							<li><?php esc_html_e( 'Location data', 'wpmoo-starter' ); ?></li>
							<li><?php esc_html_e( 'Capacity and pricing', 'wpmoo-starter' ); ?></li>
							<li><?php esc_html_e( 'Random registration numbers', 'wpmoo-starter' ); ?></li>
							<li><?php esc_html_e( 'Genre assignments', 'wpmoo-starter' ); ?></li>
						</ul>
					</li>
				</ul>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'generate_fake_data', 'fake_data_nonce' ); ?>
					<input type="hidden" name="action" value="generate_fake_data">
					<p>
						<button type="submit" class="button button-primary button-hero">
							<?php esc_html_e( '✨ Generate Fake Data', 'wpmoo-starter' ); ?>
						</button>
					</p>
				</form>
			</div>

			<div class="card" style="max-width: 800px; border-left: 4px solid #dc3232;">
				<h2 style="color: #dc3232;"><?php esc_html_e( '🗑️ Delete All Data', 'wpmoo-starter' ); ?></h2>
				<?php // translators: %s: the word "Warning:" emphasized before the sentence. ?>
				<?php
					$delete_warning = sprintf(
						// translators: %s: the word "Warning:" emphasized before the sentence.
						__( '<strong>%s</strong> This will permanently delete all Events and Genres!', 'wpmoo-starter' ),
						esc_html__( 'Warning:', 'wpmoo-starter' )
					);
				?>
				<p><?php echo wp_kses_post( $delete_warning ); ?></p>

				<?php $confirm_text = __( 'Are you sure you want to delete ALL Events and Genres? This cannot be undone!', 'wpmoo-starter' ); ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" 
						onsubmit="return confirm('<?php echo esc_js( $confirm_text ); ?>');">
					<?php wp_nonce_field( 'delete_fake_data', 'fake_data_nonce' ); ?>
					<input type="hidden" name="action" value="delete_fake_data">
					<p>
						<button type="submit" class="button button-secondary">
							<?php esc_html_e( '🗑️ Delete All Events & Genres', 'wpmoo-starter' ); ?>
						</button>
					</p>
				</form>
			</div>

			<div class="card" style="max-width: 800px; background: #f0f6fc;">
				<h2><?php esc_html_e( '💡 Quick Tips', 'wpmoo-starter' ); ?></h2>
				<ul style="list-style: disc; margin-left: 20px;">
					<?php // translators: %s: admin menu path to the list of generated events. ?>
				<?php
				$see_events = sprintf(
					// translators: %s: admin menu path to the list of generated events.
					__( 'Visit <strong>%s</strong> to see the generated events', 'wpmoo-starter' ),
					esc_html__( 'Events > All Events', 'wpmoo-starter' )
				);
				?>
					<li><?php echo wp_kses_post( $see_events ); ?></li>
					<?php // translators: %s: admin menu path to the terms screen showing custom columns. ?>
				<?php
				$see_genres = sprintf(
					// translators: %s: admin menu path to the terms screen showing custom columns.
					__( 'Visit <strong>%s</strong> to see custom columns in action:', 'wpmoo-starter' ),
					esc_html__( 'Events > Genres', 'wpmoo-starter' )
				);
				?>
					<li><?php echo wp_kses_post( $see_genres ); ?>
						<ul style="list-style: circle; margin-left: 20px;">
							<?php // translators: %s: the column label "Events". ?>
				<?php
				$col_events = sprintf(
					// translators: %s: the column label "Events".
					__( '<strong>%s</strong> column shows event count per genre', 'wpmoo-starter' ),
					esc_html__( 'Events', 'wpmoo-starter' )
				);
				?>
							<li><?php echo wp_kses_post( $col_events ); ?></li>
							<?php // translators: %s: the column label "Featured". ?>
				<?php
				$col_featured = sprintf(
					// translators: %s: the column label "Featured".
					__( '<strong>%s</strong> column shows featured status (★)', 'wpmoo-starter' ),
					esc_html__( 'Featured', 'wpmoo-starter' )
				);
				?>
							<li><?php echo wp_kses_post( $col_featured ); ?></li>
							<?php // translators: %s: the word "sortable". ?>
				<?php
				$col_sortable = sprintf(
					// translators: %s: the word "sortable".
					__( 'Both columns are <strong>%s</strong>!', 'wpmoo-starter' ),
					esc_html__( 'sortable', 'wpmoo-starter' )
				);
				?>
							<li><?php echo wp_kses_post( $col_sortable ); ?></li>
						</ul>
					</li>
					<li><?php esc_html_e( 'Click on column headers to sort by different criteria', 'wpmoo-starter' ); ?></li>
					<li><?php esc_html_e( 'Check event meta fields for additional data (date, location, capacity, etc.)', 'wpmoo-starter' ); ?></li>
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
                    'notice_nonce' => wp_create_nonce( 'wpmoo_fake_data_notice' ),
                ],
                admin_url( 'tools.php' )
            )
        );
        return;
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
                    'notice_nonce' => wp_create_nonce( 'wpmoo_fake_data_notice' ),
                ],
                admin_url( 'tools.php' )
            )
        );
        return;
    }
}
