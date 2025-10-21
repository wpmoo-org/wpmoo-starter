<?php
/**
 * Color field examples.
 *
 * @package WPMooStarter\Pages\Settings\Sections
 */

namespace WPMooStarter\Pages\Settings\Sections;

use WPMoo\Options\Builder;

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
	 * @param Builder $container Options container builder.
	 * @return void
	 */
	public static function register( Builder $container ): void {
		$section = $container->section(
			'color_examples',
			'Color Picker',
			'Example configurations for the WordPress color picker.'
		)->icon( 'dashicons-art' );

		$section->field( 'color_brand', 'color' )
			->label( 'Brand Color' )
			->description( 'Default value defines your brand colour swatch.' )
			->default( '#8a00d4' );

		$palette = function_exists( 'wp_json_encode' )
			? wp_json_encode( array( '#2271b1', '#198754', '#d63638', '#f59e0b' ) )
			: json_encode( array( '#2271b1', '#198754', '#d63638', '#f59e0b' ) );

		$section->field( 'color_palette', 'color' )
			->label( 'Restricted Palette' )
			->description( 'Pass a palette via data attributes to guide selection.' )
			->attributes(
				array(
					'data-palette' => $palette,
				)
			)
			->help( 'Palette values are encoded into the input and parsed in JavaScript.' );

		$section->field( 'color_with_context', 'color' )
			->label( 'CTA Button Background' )
			->description( 'Example using before/after hints for context.' )
			->before( '<p class="description">Used for call-to-action buttons.</p>' )
			->after( '<p class="description">Adjust text colour manually if needed for contrast.</p>' )
			->default( '#2271b1' );
	}
}
