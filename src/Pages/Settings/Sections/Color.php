<?php
/**
 * Color field examples.
 *
 * @package WPMooStarter\Pages\Settings\Sections
 */

namespace WPMooStarter\Pages\Settings\Sections;

use WPMoo\Moo;
use WPMoo\Fields\Field;

if ( ! defined( 'ABSPATH' ) ) {
	return;
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
		Moo::section( 'color_examples', __( 'Color Picker', 'wpmoo-starter' ) )
			->parent( 'wpmoo_starter_settings' )
					->description(
						__( 'Example configurations for the WordPress color picker.', 'wpmoo-starter' )
					)
			->icon( 'dashicons-art' )
				->fields(
					( new Field( 'color_brand', 'color' ) )
						->label( __( 'Brand Color', 'wpmoo-starter' ) )
					->description( __( 'Default value defines your brand colour swatch.', 'wpmoo-starter' ) )
					->after( '<p class="description">' . __( 'Applies to headers, highlights, and primary buttons.', 'wpmoo-starter' ) . '</p>' )
					->default( '#8a00d4' )
					->help(
						__( 'Pick something accessible against both light and dark backgrounds.', 'wpmoo-starter' )
					),
					( new Field( 'color_palette', 'color' ) )
						->label( __( 'Restricted Palette', 'wpmoo-starter' ) )
					->description(
						__( 'Pass a palette via data attributes to guide selection.', 'wpmoo-starter' )
					)
					->after(
						'<p class="description">' .
						__( 'Choose from the curated brand palette below.', 'wpmoo-starter' ) .
						'</p>'
					)
					->default(
						array(
							'#2271b1',
							'#198754',
							'#d63638',
							'#f59e0b',
						)
					)
					->help(
						__( 'Palette values are encoded into the input and parsed in JavaScript.', 'wpmoo-starter' )
					),
					( new Field( 'color_with_context', 'color' ) )
						->label( __( 'CTA Button Background', 'wpmoo-starter' ) )
					->description(
						__( 'Example using before/after hints for context.', 'wpmoo-starter' )
					)
					->after(
						'<p class="description">' . __( 'Used for call-to-action buttons.', 'wpmoo-starter' ) . '</p>'
					)
					->after(
						'<p class="description">' .
						__( 'Adjust text colour manually if needed for contrast.', 'wpmoo-starter' ) .
						'</p>'
					)
					->default( '#2271b1' )
				);
	}
}
