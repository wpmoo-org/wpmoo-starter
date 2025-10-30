<?php
/**
 * Accordion field examples.
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
 * Demonstrates the accordion field for grouping inputs.
 */
class Accordion {
	/**
	 * Register the accordion example section.
	 *
	 * @return void
	 */
	public static function register(): void {
		Moo::section( 'accordion_examples', __( 'Accordion Examples', 'wpmoo-starter' ) )
			->parent( 'wpmoo_starter_settings' )
			->description( __( 'Organise fields into collapsible groups with nested field definitions.', 'wpmoo-starter' ) )
			->icon( 'dashicons-menu' )
				->fields(
                Field::accordion('content_blocks')
						->label( __( 'Homepage Blocks', 'wpmoo-starter' ) )
					->description( __( 'Each accordion panel renders its own collection of fields.', 'wpmoo-starter' ) )
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
				'title'  => __( 'Hero Banner', 'wpmoo-starter' ),
				'open'   => true,
				'fields' => array(
                    Field::text('hero_title')
						->label( __( 'Headline', 'wpmoo-starter' ) )
						->default( __( 'Welcome to WPMoo Starter', 'wpmoo-starter' ) )
						->placeholder( __( 'Enter a strong headline', 'wpmoo-starter' ) )
						->help( __( 'Keep the headline under 60 characters for optimal layout.', 'wpmoo-starter' ) ),
                    Field::textarea('hero_subtitle')
						->label( __( 'Subtitle', 'wpmoo-starter' ) )
						->description( __( 'Shown below the headline.', 'wpmoo-starter' ) )
						->before( '<p class="description">' . __( 'Explain the product value in one or two sentences.', 'wpmoo-starter' ) . '</p>' )
						->attributes( array( 'rows' => 3 ) )
						->help( __( 'Supports HTML formatting for emphasis if needed.', 'wpmoo-starter' ) ),
                    Field::text('hero_primary_label')
						->label( __( 'Primary Button Label', 'wpmoo-starter' ) )
						->default( __( 'Get Started', 'wpmoo-starter' ) )
						->help( __( 'Leave empty to hide the button.', 'wpmoo-starter' ) ),
                    Field::text('hero_primary_url')
						->label( __( 'Primary Button URL', 'wpmoo-starter' ) )
						->attributes( array( 'type' => 'url' ) )
						->help( __( 'Button links open in the same tab by default.', 'wpmoo-starter' ) ),
                    Field::checkbox('hero_enabled')
						->label( __( 'Display Hero Section', 'wpmoo-starter' ) )
						->default( 1 )
						->help( __( 'Disable if your theme provides its own hero section.', 'wpmoo-starter' ) ),
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
				'title'  => __( 'Feature Strip', 'wpmoo-starter' ),
				'fields' => array(
                    Field::text('features_heading')
						->label( __( 'Heading', 'wpmoo-starter' ) )
						->default( __( 'Why customers love us', 'wpmoo-starter' ) )
						->help( __( 'Appears above the feature list on the homepage.', 'wpmoo-starter' ) ),
                    Field::textarea('features_copy')
						->label( __( 'Supporting Copy', 'wpmoo-starter' ) )
						->attributes( array( 'rows' => 3 ) ),
                    Field::color('features_background')
						->label( __( 'Background Colour', 'wpmoo-starter' ) )
						->default( '#f3f4f6' )
						->help( __( 'Choose a subtle neutral shade for readability.', 'wpmoo-starter' ) ),
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
				'title'  => __( 'FAQ', 'wpmoo-starter' ),
				'fields' => array(
                    Field::text('faq_title')
						->label( __( 'Section Title', 'wpmoo-starter' ) )
						->default( __( 'Frequently Asked Questions', 'wpmoo-starter' ) )
						->help( __( 'Keep the title short so it fits on mobile.', 'wpmoo-starter' ) ),
                    Field::textarea('faq_intro')
						->label( __( 'Intro Copy', 'wpmoo-starter' ) )
						->description( __( 'Shown above the accordion of questions.', 'wpmoo-starter' ) )
						->attributes( array( 'rows' => 2 ) )
						->help( __( 'Supports line breaks for longer context.', 'wpmoo-starter' ) ),
                    Field::checkbox('faq_show_search')
						->label( __( 'Display Search Box', 'wpmoo-starter' ) )
						->help( __( 'Adds a keyword filter to the FAQ list.', 'wpmoo-starter' ) ),
				),
			);
	}
}
