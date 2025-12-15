<?php
/**
 * Sample Settings Page for WPMooStarter using WPMoo Framework.
 *
 * This demonstrates the usage of the new WPMoo architecture for creating
 * a settings page with tabs and fields with the starter plugin.
 *
 * @package WPMooStarter
 * @since 0.1.0
 */

use WPMooStarter\WPMoo\Moo;
use WPMooStarter\WPMoo\Field\Field;

// Register the settings page and tabs to be created after translations are available
add_action('init', function() {
    // Create a settings page using the starter plugin's facade.
    Moo::page( 'wpmoo_starter_settings', __( 'Starter Settings', 'wpmoo-starter' ) )
        ->capability( 'manage_options' )
        ->description( __( 'Configure WPMoo Starter plugin settings', 'wpmoo-starter' ) )
        ->menu_slug( 'wpmoo-starter-settings' )
        ->menu_position( 20 )
        ->menu_icon( 'dashicons-admin-generic' );

    // Create tabs for the settings page using the starter plugin's facade.
    Moo::tabs( 'wpmoo_starter_main_tabs' )
        ->parent( 'wpmoo_starter_settings' )  // Link to the starter settings page
        ->items(
            array(
                array(
                    'id' => 'general',
                    'title' => __( 'General Settings', 'wpmoo-starter' ),
                    'content' => array(
                        Field::input( 'site_title' )
                            ->label( __( 'Site Title', 'wpmoo-starter' ) )
                            ->placeholder( __( 'Enter your site title', 'wpmoo-starter' ) ),
                        Field::textarea( 'site_description' )
                            ->label( __( 'Site Description', 'wpmoo-starter' ) )
                            ->placeholder( __( 'Enter site description', 'wpmoo-starter' ) ),
                        Field::toggle( 'enable_cache' )
                            ->label( __( 'Enable Caching', 'wpmoo-starter' ) ),
                    ),
                ),
                array(
                    'id' => 'advanced',
                    'title' => __( 'Advanced Settings', 'wpmoo-starter' ),
                    'content' => array(
                        Field::input( 'cache_duration' )
                            ->label( __( 'Cache Duration (seconds)', 'wpmoo-starter' ) )
                            ->placeholder( __( 'Enter cache duration', 'wpmoo-starter' ) ),
                        Field::toggle( 'enable_debug' )
                            ->label( __( 'Enable Debug Mode', 'wpmoo-starter' ) ),
                    ),
                ),
            )
        );
}, 10); // Run after the textdomain is loaded (which happens at priority 5 by default)

