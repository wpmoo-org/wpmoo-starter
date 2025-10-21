<?php
/**
 * Accordion field examples.
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
 * Demonstrates the accordion field for grouping inputs.
 */
class Accordion {
	/**
	 * Register the accordion example section.
	 *
	 * @param Container $container Fluent container instance.
	 * @return void
	 */
	public static function register( Container $container ): void {
		$section = $container->section(
			'accordion_examples',
			'Accordion',
			'Organise fields into collapsible groups with nested field definitions.'
		)->icon( 'dashicons-menu' );

		$section->add_field(
			Field::accordion( 'content_blocks', 'Homepage Blocks' )
				->description( 'Each accordion panel renders its own collection of fields.' )
				->set(
					'sections',
					array(
						self::hero_panel(),
						self::feature_panel(),
						self::faq_panel(),
					)
				)
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
					->toArray(),
				Field::textarea( 'hero_subtitle', 'Subtitle' )
					->description( 'Shown below the headline.' )
					->args( array( 'rows' => 3 ) )
					->toArray(),
				Field::text( 'hero_primary_label', 'Primary Button Label' )
					->default( 'Get Started' )
					->help( 'Leave empty to hide the button.' )
					->toArray(),
				Field::text( 'hero_primary_url', 'Primary Button URL' )
					->attributes( array( 'type' => 'url' ) )
					->toArray(),
				Field::checkbox( 'hero_enabled', 'Display Hero Section' )
					->default( 1 )
					->toArray(),
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
					->toArray(),
				Field::textarea( 'features_copy', 'Supporting Copy' )
					->args( array( 'rows' => 3 ) )
					->toArray(),
				Field::color( 'features_background', 'Background Colour' )
					->default( '#f3f4f6' )
					->toArray(),
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
					->toArray(),
				Field::textarea( 'faq_intro', 'Intro Copy' )
					->description( 'Shown above the accordion of questions.' )
					->args( array( 'rows' => 2 ) )
					->toArray(),
				Field::checkbox( 'faq_show_search', 'Display Search Box' )
					->toArray(),
			),
		);
	}
}
