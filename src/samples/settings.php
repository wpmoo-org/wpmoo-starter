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

use WPMooStarter\Moo;

// Register the settings page and components to be created after translations are available
add_action('init', function() {
    // Create a settings page using the starter plugin's facade.
    Moo::page( 'wpmoo_starter_settings', __( 'Starter Settings', 'wpmoo-starter' ) )
        ->capability( 'manage_options' )
        ->description( __( 'Configure WPMoo Starter plugin settings', 'wpmoo-starter' ) )
        ->menu_slug( 'wpmoo-starter-settings' )
        ->menu_position( 20 )
        ->menu_icon( 'dashicons-admin-generic' );

    // Create tabs container for the settings page using the starter plugin's facade.
    Moo::container( 'tabs', 'wpmoo_starter_main_tabs' )
        ->parent( 'wpmoo_starter_settings' );  // Link to the starter settings page

    // Create individual tabs
    Moo::tab( 'starter_general', __( 'General Settings', 'wpmoo-starter' ) )
        ->parent( 'wpmoo_starter_main_tabs' )  // Link to the tabs container
        ->fields( array(
            Moo::input( 'starter_site_title' )
                ->label( __( 'Site Title', 'wpmoo-starter' ) )
                ->placeholder( __( 'Enter your site title', 'wpmoo-starter' ) ),
            Moo::textarea( 'starter_site_description' )
                ->label( __( 'Site Description', 'wpmoo-starter' ) )
                ->placeholder( __( 'Enter site description', 'wpmoo-starter' ) ),
            Moo::toggle( 'starter_enable_cache' )
                ->label( __( 'Enable Caching', 'wpmoo-starter' ) ),
        ) );

    Moo::tab( 'starter_advanced', __( 'Advanced Settings', 'wpmoo-starter' ) )
        ->parent( 'wpmoo_starter_main_tabs' )  // Link to the tabs container
        ->fields( array(
            Moo::input( 'starter_cache_duration' )
                ->label( __( 'Cache Duration (seconds)', 'wpmoo-starter' ) )
                ->placeholder( __( 'Enter cache duration', 'wpmoo-starter' ) ),
            Moo::toggle( 'starter_enable_debug' )
                ->label( __( 'Enable Debug Mode', 'wpmoo-starter' ) ),
        ) );

    // Also demonstrate accordion container
    Moo::container( 'accordion', 'wpmoo_starter_accordion' )
        ->parent( 'wpmoo_starter_settings' );  // Link to the settings page.

    Moo::accordion( 'starter_acc_general', __( 'General Information', 'wpmoo-starter' ) )
        ->parent( 'wpmoo_starter_accordion' )  // Link to the accordion container
        ->fields( array(
            Moo::input( 'starter_info_field' )
                ->label( __( 'Info Field', 'wpmoo-starter' ) ),
        ) );

    Moo::accordion( 'starter_acc_help', __( 'Help & Support', 'wpmoo-starter' ) )
        ->parent( 'wpmoo_starter_accordion' )  // Link to the accordion container
        ->fields( array(
            Moo::textarea( 'starter_support_info' )
                ->label( __( 'Support Information', 'wpmoo-starter' ) ),
        ) );
}, 10); // Run after the textdomain is loaded (which happens at priority 5 by default)

