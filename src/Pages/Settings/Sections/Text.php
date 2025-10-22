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
				Field::text( 'welcome_text', 'Basic Text' )
					->description( 'A simple text input using a placeholder and default value.' )
					->before( '<p class="description">Shown on the welcome banner across the site.</p>' )
					->placeholder( 'Enter plain text' )
					->default( 'Welcome to WPMoo' )
					->help( 'Keep short and punchy so the tooltip stays legible.' ),

				Field::text( 'text_email', 'Email Address' )
					->description( 'Custom input type set to email with autocomplete helpers.' )
					->before( '<p class="description">We notify this address about account activity.</p>' )
					->attributes(['type' => 'email', 'autocomplete' => 'email', 'inputmode' => 'email'])
					->help( 'Browser validation enforces the email format automatically.' )
					->placeholder( 'name@example.com' ),

				Field::text( 'text_with_prefix', 'URL Slug' )
					->description( 'Demonstrates before/after markup around the control.' )
					->before( '<p class="description"><strong>Base URL:</strong> https://example.com/</p>' )
					->after( '<p class="description">Only lowercase letters and dashes.</p>' )
					->attributes(['pattern' => '[a-z0-9-]+', 'inputmode' => 'latin', 'maxlength' => 32, 'autocomplete' => 'off'])
					->default( 'starter-page' ),

				Field::text( 'text_password', 'API Token' )
					->description( 'Use password input type to hide sensitive data.' )
					->attributes(['type' => 'password', 'autocomplete' => 'new-password', 'placeholder' => '••••••••••'])
					->help( 'Copy the token to a secure place before saving changes.' ),

				Field::checkbox( 'books_toggle', 'Insert Sample Books' )
					->description( 'Controls whether the starter plugin seeds demo book entries on init.' )
					->default( 1 )
					->before( '<p class="description">Adds demo items to the Books custom post type.</p>' )
					->help( 'Turn this off once you no longer need the sample content.' )
			);
	}
}
