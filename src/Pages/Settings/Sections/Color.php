<?php
/**
 * Color field examples.
 *
 * @package WPMooStarter\Pages\Settings\Sections
 */

namespace WPMooStarter\Pages\Settings\Sections;

use WPMoo\Moo;
use WPMoo\Options\Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Demonstrates usage of the color picker field.
 */
class Color {
	/**
	 * Register the color examples section.
	 *
	 * @return void
	 */
	public static function register(): void {
		$palette = function_exists( 'wp_json_encode' )
			? wp_json_encode( array( '#2271b1', '#198754', '#d63638', '#f59e0b' ) )
			: json_encode( array( '#2271b1', '#198754', '#d63638', '#f59e0b' ) );

		Moo::make( 'section', 'color_examples', 'Color Picker' )
			->parent( 'wpmoo_starter_settings' )
			->description( 'Example configurations for the WordPress color picker.' )
			->icon( 'dashicons-art' )
			->fields(
			Field::color( 'color_brand', 'Brand Color' )
				->description( 'Default value defines your brand colour swatch.' )
				->default( '#8a00d4' )
				->width( 33 ),

			Field::color( 'color_palette', 'Restricted Palette' )
				->description( 'Pass a palette via data attributes to guide selection.' )
				->attributes(['data-palette' => $palette])
				->help( 'Palette values are encoded into the input and parsed in JavaScript.' )
				->width( 33 ),

			Field::color( 'color_with_context', 'CTA Button Background' )
				->description( 'Example using before/after hints for context.' )
				->before( '<p class="description">Used for call-to-action buttons.</p>' )
				->after( '<p class="description">Adjust text colour manually if needed for contrast.</p>' )
				->default( '#2271b1' )
				->width( 33 )
			);
	}
}
