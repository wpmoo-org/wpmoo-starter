<?php
/**
 * Text field examples.
 *
 * @package WPMooStarter\Pages\Settings\Sections
 */

namespace WPMooStarter\Pages\Settings\Sections;

use WPMoo\Options\Builder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Demonstrates different text field configurations.
 */
class Text {
	/**
	 * Attach the text section to the container.
	 *
	 * @param Builder $container Options container builder.
	 * @return void
	 */
	public static function register( Builder $container ): void {
		$section = $container->section(
			'text_examples',
			'Input: Text',
			'Examples showing how to configure single line inputs.'
		)->icon( 'dashicons-editor-textcolor' );

		$section->field( 'welcome_text', 'text' )
			->label( 'Basic Text' )
			->description( 'A simple text input using a placeholder and default value.' )
			->placeholder( 'Enter plain text' )
			->default( 'Welcome to WPMoo' );

		$section->field( 'text_email', 'text' )
			->label( 'Email Address' )
			->description( 'Custom input type set to email with autocomplete helpers.' )
			->attributes(
				array(
					'type'         => 'email',
					'autocomplete' => 'email',
					'inputmode'    => 'email',
				)
			)
			->help( 'Validated by the browser because the type is set to email.' )
			->placeholder( 'name@example.com' );

		$section->field( 'text_with_prefix', 'text' )
			->label( 'URL Slug' )
			->description( 'Demonstrates before/after markup around the control.' )
			->before( '<code>https://example.com/</code>' )
			->after( '<span class="description">Only lowercase letters and dashes.</span>' )
			->attributes(
				array(
					'pattern'      => '[a-z0-9\-]+',
					'inputmode'    => 'latin',
					'maxlength'    => 32,
					'autocomplete' => 'off',
				)
			)
			->default( 'starter-page' );

		$section->field( 'text_password', 'text' )
			->label( 'API Token' )
			->description( 'Use password input type to hide sensitive data.' )
			->attributes(
				array(
					'type'         => 'password',
					'autocomplete' => 'new-password',
					'placeholder'  => '••••••••••',
				)
			)
			->help( 'The value is stored as plain text in options; use it for display only.' );

		$section->field( 'books_toggle', 'checkbox' )
			->label( 'Insert Sample Books' )
			->description( 'Controls whether the starter plugin seeds demo book entries on init.' )
			->default( 1 )
			->help( 'Disable after you are done experimenting with the sample data.' );
	}
}
