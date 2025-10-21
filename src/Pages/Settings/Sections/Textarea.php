<?php
/**
 * Textarea field examples.
 *
 * @package WPMooStarter\Pages\Settings\Sections
 */

namespace WPMooStarter\Pages\Settings\Sections;

use WPMoo\Options\Container;
use WPMoo\Options\Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Demonstrates the textarea field configuration options.
 */
class Textarea {
	/**
	 * Attach textarea examples to the container.
	 *
	 * @param Container $container Fluent container instance.
	 * @return void
	 */
	public static function register( Container $container ): void {
		$section = $container->section(
			'textarea_examples',
			'Textarea',
			'Examples covering multi-line inputs and formatting helpers.'
		)->icon( 'dashicons-editor-paragraph' );

		$section->add_fields(
			array(
				Field::textarea( 'textarea_basic', 'Basic Textarea' )
					->description( 'Default textarea with placeholder and rows attribute.' )
					->placeholder( 'Enter a short note…' )
					->attributes(
						array(
							'rows' => 4,
						)
					)
					->default( "Line one\nLine two" ),

				Field::textarea( 'textarea_code', 'Code Snippet' )
					->description( 'Apply monospace styling via custom attributes.' )
					->attributes(
						array(
							'class'      => 'monospace',
							'rows'       => 6,
							'spellcheck' => 'false',
						)
					)
					->help( 'Add a CSS rule for `.monospace` to apply your preferred font.' ),

				Field::textarea( 'textarea_with_wrapper', 'Custom Wrapper' )
					->description( 'Shows how before/after markup can frame the textarea.' )
					->before( '<p class="description">Enter one item per line:</p>' )
					->after( '<p class="description">These values will be parsed into an array.</p>' )
					->attributes(
						array(
							'rows'      => 5,
							'maxlength' => 500,
						)
					),
			)
		);
	}
}
