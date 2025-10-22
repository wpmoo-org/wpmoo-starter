<?php
/**
 * Text field examples.
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
 * Demonstrates different text field configurations.
 */
class Text {
	/**
	 * Attach the text section to the container.
	 *
	 * @param Container $container Fluent container instance.
	 * @return void
	 */
	public static function register( Container $container ): void {
		$section = $container->section(
			'text_examples',
			'Text',
			'Examples showing how to configure single line inputs.'
		)->icon( 'dashicons-editor-textcolor' );

		$section->add_fields(
			array(
				Field::text( 'welcome_text', 'Basic Text' )
					->description( 'A simple text input using a placeholder and default value.' )
					->placeholder( 'Enter plain text' )
					->default( 'Welcome to WPMoo' )
					->size( 6 ),

				Field::text( 'text_email', 'Email Address' )
					->description( 'Custom input type set to email with autocomplete helpers.' )
					->attributes(
						array(
							'type'         => 'email',
							'autocomplete' => 'email',
							'inputmode'    => 'email',
						)
					)
					->help( 'Validated by the browser because the input type is set to email.' )
					->placeholder( 'name@example.com' )
					->size( 6 ),

				Field::text( 'text_with_prefix', 'URL Slug' )
					->description( 'Demonstrates before/after markup around the control.' )
					->before( '<code>https://example.com/</code>' )
					->after( '<span class="description">Only lowercase letters and dashes.</span>' )
					->attributes(
						array(
							'pattern'      => '[a-z0-9-]+',
							'inputmode'    => 'latin',
							'maxlength'    => 32,
							'autocomplete' => 'off',
						)
					)
					->default( 'starter-page' )
					->size( 6 ),

				Field::text( 'text_password', 'API Token' )
					->description( 'Use password input type to hide sensitive data.' )
					->attributes(
						array(
							'type'         => 'password',
							'autocomplete' => 'new-password',
							'placeholder'  => '••••••••••',
						)
					)
					->help( 'Stored as plain text, so treat it as display-only inside the UI.' )
					->size( 6 ),

				Field::checkbox( 'books_toggle', 'Insert Sample Books' )
					->description( 'Controls whether the starter plugin seeds demo book entries on init.' )
					->default( 1 )
					->help( 'Disable after you are done experimenting with the sample data.' ),
			)
		);
	}
}
