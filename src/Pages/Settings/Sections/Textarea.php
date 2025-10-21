<?php
/**
 * Textarea field examples.
 *
 * @package WPMooStarter\Pages\Settings\Sections
 */

namespace WPMooStarter\Pages\Settings\Sections;

use WPMoo\Options\Builder;

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
	 * @param Builder $container Options container builder.
	 * @return void
	 */
	public static function register( Builder $container ): void {
		$section = $container->section(
			'textarea_examples',
			'Textarea',
			'Examples covering multi-line inputs and formatting helpers.'
		)->icon( 'dashicons-editor-paragraph' );

		$section->field( 'textarea_basic', 'textarea' )
			->label( 'Basic Textarea' )
			->description( 'Default textarea with placeholder and rows attribute.' )
			->placeholder( 'Enter a short note…' )
			->attributes(
				array(
					'rows' => 4,
				)
			)
			->default( "Line one\nLine two" );

		$section->field( 'textarea_code', 'textarea' )
			->label( 'Code Snippet' )
			->description( 'Apply monospace styling via custom attributes.' )
			->attributes(
				array(
					'class'      => 'monospace',
					'rows'       => 6,
					'spellcheck' => 'false',
				)
			)
			->help( 'Add a CSS rule for `.monospace` to apply your preferred font.' );

		$section->field( 'textarea_with_wrapper', 'textarea' )
			->label( 'Custom Wrapper' )
			->description( 'Shows how before/after markup can frame the textarea.' )
			->before( '<p class="description">Enter one item per line:</p>' )
			->after( '<p class="description">These values will be parsed into an array.</p>' )
			->attributes(
				array(
					'rows'      => 5,
					'maxlength' => 500,
				)
			);
	}
}
