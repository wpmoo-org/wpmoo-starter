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

// Create a settings page using the starter plugin's facade.
Moo::page( 'settings', __( 'Starter Settings', 'wpmoo-starter' ) )
    ->capability( 'manage_options' )
    ->description( __( 'Configure WPMoo Starter plugin settings', 'wpmoo-starter' ) )
    ->menu_slug( 'settings' )
    ->menu_position( 21 )
    ->menu_icon( 'dashicons-admin-generic' );

// Create tabs container for the settings page using the starter plugin's facade.
Moo::container( 'tabs', 'main_tabs' )
    ->parent( 'settings' );  // Link to the starter settings page

// Create individual tabs
Moo::tab( 'general', __( 'General Settings', 'wpmoo-starter' ) )
    ->parent( 'main_tabs' )  // Link to the tabs container
    ->fields( array(
        Moo::input( 'site_title' )
            ->label( __( 'Site Title', 'wpmoo-starter' ) )
            ->placeholder( __( 'Enter your site title', 'wpmoo-starter' ) ),
        Moo::textarea( 'site_description' )
            ->label( __( 'Site Description', 'wpmoo-starter' ) )
            ->placeholder( __( 'Enter site description', 'wpmoo-starter' ) ),
        Moo::toggle( 'enable_cache' )
            ->label( __( 'Enable Caching', 'wpmoo-starter' ) ),
    ) );

Moo::tab( 'advanced', __( 'Advanced Settings', 'wpmoo-starter' ) )
    ->parent( 'main_tabs' )  // Link to the tabs container
    ->fields( array(
        Moo::input( 'cache_duration' )
            ->label( __( 'Cache Duration (seconds)', 'wpmoo-starter' ) )
            ->placeholder( __( 'Enter cache duration', 'wpmoo-starter' ) ),
        Moo::toggle( 'enable_debug' )
            ->label( __( 'Enable Debug Mode', 'wpmoo-starter' ) ),
    ) );

// Also demonstrate accordion container
Moo::container( 'accordion', 'sample_accordion' )
    ->parent( 'settings' );  // Link to the settings page.

Moo::accordion( 'acc_general', __( 'Accordion Example', 'wpmoo-starter' ) )
    ->parent( 'sample_accordion' )  // Link to the accordion container
    ->fields( array(
        Moo::input( 'info_field' )
            ->label( __( 'Info Field', 'wpmoo-starter' ) ),
    ) );

Moo::accordion( 'acc_help', __( 'Help & Support', 'wpmoo-starter' ) )
    ->parent( 'sample_accordion' )  // Link to the accordion container
    ->fields( array(
        Moo::textarea( 'support_info' )
            ->label( __( 'Support Information', 'wpmoo-starter' ) ),
    ) );

