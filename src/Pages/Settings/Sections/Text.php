<?php
/**
 * Text field examples.
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
 * Demonstrates different text field configurations.
 */
class Text {
	/**
	 * Attach the text section using the Moo facade.
	 *
	 * @return void
	 */
	public static function register(): void {
		Moo::section( 'text_examples', __( 'Text Examples', 'wpmoo-starter' ) )
			->parent( 'wpmoo_starter_settings' )
			->description(
				__( 'Examples showing how to configure single line inputs.', 'wpmoo-starter' )
			)
			->icon( 'dashicons-editor-textcolor' )
				->fields(
                    Field::text('welcome_text')
						->label( __( 'Basic Text', 'wpmoo-starter' ) )
					->description(
						__( 'A simple text input using a placeholder and default value.', 'wpmoo-starter' )
					)
					->before(
						'<p class="description">' .
						__( 'Shown on the welcome banner across the site.', 'wpmoo-starter' ) .
						'</p>'
					)
					->placeholder( __( 'Enter plain text', 'wpmoo-starter' ) )
					->default( __( 'Welcome to WPMoo', 'wpmoo-starter' ) )
					->help(
						__( 'Keep short and punchy so the tooltip stays legible.', 'wpmoo-starter' )
					),
                    Field::text('text_email')
						->label( __( 'Email Address', 'wpmoo-starter' ) )
					->description(
						__( 'Custom input type set to email with autocomplete helpers.', 'wpmoo-starter' )
					)
					->before(
						'<p class="description">' .
						__( 'We notify this address about account activity.', 'wpmoo-starter' ) .
						'</p>'
					)
					->attributes(
						[
							'type' => 'email',
							'autocomplete' => 'email',
							'inputmode' => 'email',
						]
					)
					->help(
						__( 'Browser validation enforces the email format automatically.', 'wpmoo-starter' )
					)
					->placeholder( __( 'name@example.com', 'wpmoo-starter' ) ),
                    Field::text('text_with_prefix')
						->label( __( 'URL Slug', 'wpmoo-starter' ) )
					->description(
						__( 'Demonstrates before/after markup around the control.', 'wpmoo-starter' )
					)
					->before(
						'<p class="description"><strong>' .
						__( 'Base URL:', 'wpmoo-starter' ) .
						'</strong> https://example.com/</p>'
					)
					->after(
						'<p class="description">' .
						__( 'Only lowercase letters and dashes.', 'wpmoo-starter' ) .
						'</p>'
					)
					->attributes(
						[
							'pattern' => '[a-z0-9-]+',
							'inputmode' => 'latin',
							'maxlength' => 32,
							'autocomplete' => 'off',
						]
					)
					->default( __( 'starter-page', 'wpmoo-starter' ) ),
                    Field::text('text_password')
						->label( __( 'API Token', 'wpmoo-starter' ) )
					->description( __( 'Use password input type to hide sensitive data.', 'wpmoo-starter' ) )
					->attributes(
						[
							'type' => 'password',
							'autocomplete' => 'new-password',
							'placeholder' => '••••••••••',
						]
					)
					->help(
						__( 'Copy the token to a secure place before saving changes.', 'wpmoo-starter' )
					),
                    Field::checkbox('books_toggle')
						->label( __( 'Insert Sample Books', 'wpmoo-starter' ) )
					->description(
						__( 'Controls whether the starter plugin seeds demo book entries on init.', 'wpmoo-starter' )
					)
					->default( 1 )
					->before(
						'<p class="description">' .
						__( 'Adds demo items to the Books custom post type.', 'wpmoo-starter' ) .
						'</p>'
					)
					->help(
						__( 'Turn this off once you no longer need the sample content.', 'wpmoo-starter' )
					)
				);
	}
}
