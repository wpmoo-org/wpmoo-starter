<?php
/**
 * Accordion field examples.
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
 * Demonstrates the accordion field for grouping inputs.
 */
class Accordion {
	/**
	 * Register the accordion example section.
	 *
	 * @return void
	 */
	public static function register(): void {
		Moo::section( 'accordion_examples', 'Accordion Examples' )
			->parent( 'wpmoo_starter_settings' )
			->description( 'Organise fields into collapsible groups with nested field definitions.' )
			->icon( 'dashicons-menu' )
			->fields(
				Field::accordion( 'content_blocks', 'Homepage Blocks' )
					->description( 'Each accordion panel renders its own collection of fields.' )
					->set( 'sections', array(
						self::hero_panel(),
						self::feature_panel(),
						self::faq_panel(),
					) )
			);
	}

	/**
	 * Hero banner panel configuration.
	 *
	 * @return array<string, mixed>
	 */
	protected static function hero_panel(): array {
		return array(
			'id'     => 'hero',
			'title'  => 'Hero Banner',
			'open'   => true,
			'fields' => array(
				Field::text( 'hero_title', 'Headline' )
					->default( 'Welcome to WPMoo Starter' )
					->placeholder( 'Enter a strong headline' )
					->help( 'Keep the headline under 60 characters for optimal layout.' ),
				Field::textarea( 'hero_subtitle', 'Subtitle' )
					->description( 'Shown below the headline.' )
					->before( '<p class="description">Explain the product value in one or two sentences.</p>' )
					->attributes( array( 'rows' => 3 ) )
					->help( 'Supports HTML formatting for emphasis if needed.' ),
				Field::text( 'hero_primary_label', 'Primary Button Label' )
					->default( 'Get Started' )
					->help( 'Leave empty to hide the button.' ),
				Field::text( 'hero_primary_url', 'Primary Button URL' )
					->attributes( array( 'type' => 'url' ) )
					->help( 'Button links open in the same tab by default.' ),
				Field::checkbox( 'hero_enabled', 'Display Hero Section' )
					->default( 1 )
					->help( 'Disable if your theme provides its own hero section.' ),
			),
		);
	}

	/**
	 * Feature strip panel configuration.
	 *
	 * @return array<string, mixed>
	 */
	protected static function feature_panel(): array {
		return array(
			'id'     => 'feature_strip',
			'title'  => 'Feature Strip',
			'fields' => array(
				Field::text( 'features_heading', 'Heading' )
					->default( 'Why customers love us' )
					->help( 'Appears above the feature list on the homepage.' ),
				Field::textarea( 'features_copy', 'Supporting Copy' )
					->attributes( array( 'rows' => 3 ) ),
				Field::color( 'features_background', 'Background Colour' )
					->default( '#f3f4f6' )
					->help( 'Choose a subtle neutral shade for readability.' ),
			),
		);
	}

	/**
	 * FAQ panel configuration.
	 *
	 * @return array<string, mixed>
	 */
	protected static function faq_panel(): array {
		return array(
			'id'     => 'faq',
			'title'  => 'FAQ',
			'fields' => array(
				Field::text( 'faq_title', 'Section Title' )
					->default( 'Frequently Asked Questions' )
					->help( 'Keep the title short so it fits on mobile.' ),
				Field::textarea( 'faq_intro', 'Intro Copy' )
					->description( 'Shown above the accordion of questions.' )
					->attributes( array( 'rows' => 2 ) )
					->help( 'Supports line breaks for longer context.' ),
				Field::checkbox( 'faq_show_search', 'Display Search Box' )
					->help( 'Adds a keyword filter to the FAQ list.' ),
			),
		);
	}
}
