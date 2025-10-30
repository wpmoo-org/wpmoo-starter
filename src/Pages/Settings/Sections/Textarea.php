<?php
/**
 * Textarea field examples.
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
 * Demonstrates the textarea field configuration options.
 */
class Textarea {
	/**
	 * Attach textarea section via Moo facade.
	 *
	 * @return void
	 */
	public static function register(): void {
		Moo::section( 'textarea_examples', __( 'Textarea Examples', 'wpmoo-starter' ) )
			->parent( 'wpmoo_starter_settings' )
			->description(
				__( 'Examples covering multi-line inputs and formatting helpers.', 'wpmoo-starter' )
			)
			->icon( 'dashicons-editor-paragraph' )
				->fields(
					Field::textarea( 'textarea_basic' )
						->label( __( 'Basic Textarea', 'wpmoo-starter' ) )
					->description( __( 'Default textarea with placeholder and rows attribute.', 'wpmoo-starter' ) )
					->placeholder( __( 'Enter a short note…', 'wpmoo-starter' ) )
					->attributes( [ 'rows' => 4 ] )
					->default( __( "Line one\nLine two", 'wpmoo-starter' ) )
					->help( __( 'Ideal for short text snippets like summaries or blurbs.', 'wpmoo-starter' ) ),
					Field::textarea( 'textarea_code' )
						->label( __( 'Code Snippet', 'wpmoo-starter' ) )
					->description(
						__( 'Apply monospace styling via custom attributes.', 'wpmoo-starter' )
					)
					->attributes(
						[
							'class' => 'monospace',
							'rows' => 6,
							'spellcheck' => 'false',
						]
					)
					->help(
						__( 'Add a `.monospace` rule in your stylesheet to control the font family.', 'wpmoo-starter' )
					),
					Field::textarea( 'textarea_with_wrapper' )
						->label( __( 'Custom Wrapper', 'wpmoo-starter' ) )
					->description(
						__( 'Shows how before/after markup can frame the textarea.', 'wpmoo-starter' )
					)
					->before(
						'<p class="description">' .
						__( 'Enter one item per line:', 'wpmoo-starter' ) .
						'</p>'
					)
					->after(
						'<p class="description">' .
						__( 'These values will be parsed into an array.', 'wpmoo-starter' ) .
						'</p>'
					)
					->attributes(
						[
							'rows' => 5,
							'maxlength' => 500,
						]
					)
					->help(
						__( 'Keep the list concise; each line becomes an individual entry.', 'wpmoo-starter' )
					)
				);
	}
}
