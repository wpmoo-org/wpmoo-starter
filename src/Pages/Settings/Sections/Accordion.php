<?php
/**
 * Accordion field examples.
 *
 * @package WPMooStarter\Pages\Settings\Sections
 */

namespace WPMooStarter\Pages\Settings\Sections;

use WPMoo\Options\Builder;

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
	 * @param Builder $container Options container builder.
	 * @return void
	 */
	public static function register( Builder $container ): void {
		$section = $container->section(
			'accordion_examples',
			'Group: Accordion',
			'Organise fields into collapsible groups with nested field definitions.'
		)->icon( 'dashicons-menu' );

		$section->field( 'content_blocks', 'accordion' )
			->label( 'Homepage Blocks' )
			->description( 'Each accordion panel renders its own collection of fields.' )
			->set(
				'sections',
				array(
					self::hero_panel(),
					self::feature_panel(),
					self::faq_panel(),
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
				array(
					'id'          => 'hero_title',
					'type'        => 'text',
					'label'       => 'Headline',
					'default'     => 'Welcome to WPMoo Starter',
					'placeholder' => 'Enter a strong headline',
				),
				array(
					'id'          => 'hero_subtitle',
					'type'        => 'textarea',
					'label'       => 'Subtitle',
					'description' => 'Shown below the headline.',
					'args'        => array( 'rows' => 3 ),
				),
				array(
					'id'      => 'hero_primary_label',
					'type'    => 'text',
					'label'   => 'Primary Button Label',
					'default' => 'Get Started',
					'help'    => 'Leave empty to hide the button.',
				),
				array(
					'id'      => 'hero_primary_url',
					'type'    => 'text',
					'label'   => 'Primary Button URL',
					'attributes' => array( 'type' => 'url' ),
				),
				array(
					'id'      => 'hero_enabled',
					'type'    => 'checkbox',
					'label'   => 'Display Hero Section',
					'default' => 1,
				),
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
				array(
					'id'      => 'features_heading',
					'type'    => 'text',
					'label'   => 'Heading',
					'default' => 'Why customers love us',
				),
				array(
					'id'          => 'features_copy',
					'type'        => 'textarea',
					'label'       => 'Supporting Copy',
					'args'        => array( 'rows' => 3 ),
				),
				array(
					'id'      => 'features_background',
					'type'    => 'color',
					'label'   => 'Background Colour',
					'default' => '#f3f4f6',
				),
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
				array(
					'id'      => 'faq_title',
					'type'    => 'text',
					'label'   => 'Section Title',
					'default' => 'Frequently Asked Questions',
				),
				array(
					'id'          => 'faq_intro',
					'type'        => 'textarea',
					'label'       => 'Intro Copy',
					'description' => 'Shown above the accordion of questions.',
					'args'        => array( 'rows' => 2 ),
				),
				array(
					'id'    => 'faq_show_search',
					'type'  => 'checkbox',
					'label' => 'Display Search Box',
				),
			),
		);
	}
}
