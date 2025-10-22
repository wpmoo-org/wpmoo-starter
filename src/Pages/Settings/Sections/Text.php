<?php
/**
 * Text field examples.
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
 * Demonstrates different text field configurations.
 */
class Text {
	/**
	 * Attach the text section using the Moo facade.
	 *
	 * @return void
	 */
	public static function register(): void {
		Moo::make( 'section', 'text_examples', 'Text Examples' )
			->parent( 'wpmoo_starter_settings' )
			->description( 'Examples showing how to configure single line inputs.' )
			->icon( 'dashicons-editor-textcolor' )
			->fields(
				Field::fieldset( 'text_basic_form', 'Basic Details' )
					->description( 'Example grouping for frequently used account fields.' )
					->width( 50 )
					->fields(
						Field::text( 'welcome_text', 'Basic Text' )
							->description( 'A simple text input using a placeholder and default value.' )
							->placeholder( 'Enter plain text' )
							->default( 'Welcome to WPMoo' ),

						Field::text( 'text_email', 'Email Address' )
							->description( 'Custom input type set to email with autocomplete helpers.' )
							->attributes(['type' => 'email', 'autocomplete' => 'email', 'inputmode' => 'email'])
							->help( 'Validated by the browser because the input type is set to email.' )
							->placeholder( 'name@example.com' )
					),

				Field::fieldset( 'text_advanced_form', 'Advanced Inputs' )
					->description( 'Demonstrates prefix/suffix helpers and password styles.' )
					->width( 50 )
					->fields(
						Field::text( 'text_with_prefix', 'URL Slug' )
							->description( 'Demonstrates before/after markup around the control.' )
							->before( '<code>https://example.com/</code>' )
							->after( '<span class="description">Only lowercase letters and dashes.</span>' )
							->attributes(['pattern' => '[a-z0-9-]+', 'inputmode' => 'latin', 'maxlength' => 32, 'autocomplete' => 'off'])
							->default( 'starter-page' ),

						Field::text( 'text_password', 'API Token' )
							->description( 'Use password input type to hide sensitive data.' )
							->attributes(['type' => 'password', 'autocomplete' => 'new-password', 'placeholder' => '••••••••••'])
							->help( 'Stored as plain text, so treat it as display-only inside the UI.' )
					),

				Field::checkbox( 'books_toggle', 'Insert Sample Books' )
					->description( 'Controls whether the starter plugin seeds demo book entries on init.' )
					->default( 1 )
					->help( 'Disable after you are done experimenting with the sample data.' )
			);
	}
}
