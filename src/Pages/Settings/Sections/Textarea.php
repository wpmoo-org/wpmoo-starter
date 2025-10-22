<?php
/**
 * Textarea field examples.
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
 * Demonstrates the textarea field configuration options.
 */
class Textarea {
	/**
	 * Attach textarea section via Moo facade.
	 *
	 * @return void
	 */
	public static function register(): void {
		Moo::make( 'section', 'textarea_examples', 'Textarea Examples' )
			->parent( 'wpmoo_starter_settings' )
			->description( 'Examples covering multi-line inputs and formatting helpers.' )
			->icon( 'dashicons-editor-paragraph' )
			->fields(
			Field::textarea( 'textarea_basic', 'Basic Textarea' )
				->description( 'Default textarea with placeholder and rows attribute.' )
				->placeholder( 'Enter a short note…' )
				->attributes(['rows' => 4])
				->default( "Line one\nLine two" )
				->width( 50 ),

			Field::textarea( 'textarea_code', 'Code Snippet' )
				->description( 'Apply monospace styling via custom attributes.' )
				->attributes(['class' => 'monospace', 'rows' => 6, 'spellcheck' => 'false'])
				->help( 'Add a CSS rule for `.monospace` to apply your preferred font.' )
				->width( 50 ),

				Field::textarea( 'textarea_with_wrapper', 'Custom Wrapper' )
					->description( 'Shows how before/after markup can frame the textarea.' )
					->before( '<p class="description">Enter one item per line:</p>' )
					->after( '<p class="description">These values will be parsed into an array.</p>' )
					->attributes(['rows' => 5, 'maxlength' => 500])
			);
	}
}
