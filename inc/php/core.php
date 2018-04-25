<?php

/**
 * Prevent Direct Access
 */
defined( 'ABSPATH' ) or die( "Restricted access!" );

/**
 * Register text domain
 */
function spacexchimp_p005_textdomain() {
    load_plugin_textdomain( SPACEXCHIMP_P005_TEXT, false, SPACEXCHIMP_P005_DIR . '/languages/' );
}
add_action( 'init', 'spacexchimp_p005_textdomain' );

/**
 * Print direct link to plugin admin page
 *
 * Fetches array of links generated by WP Plugin admin page ( Deactivate | Edit )
 * and inserts a link to the plugin admin page
 */
function spacexchimp_p005_settings_link( $links ) {
    $page = '<a href="' . admin_url( 'options-general.php?page=' . SPACEXCHIMP_P005_SLUG ) . '">' . __( 'Settings', SPACEXCHIMP_P005_TEXT ) . '</a>';
    array_unshift( $links, $page );
    return $links;
}
add_filter( 'plugin_action_links_' . SPACEXCHIMP_P005_BASE, 'spacexchimp_p005_settings_link' );

/**
 * Print additional links to plugin meta row
 */
function spacexchimp_p005_plugin_row_meta( $links, $file ) {

    if ( strpos( $file, SPACEXCHIMP_P005_SLUG . '.php' ) !== false ) {

        $new_links = array(
                           'donate' => '<a href="https://www.spacexchimp.com/donate.html" target="_blank"><span class="dashicons dashicons-heart"></span> ' . __( 'Donate', SPACEXCHIMP_P005_TEXT ) . '</a>'
                           );
        $links = array_merge( $links, $new_links );
    }

    return $links;
}
add_filter( 'plugin_row_meta', 'spacexchimp_p005_plugin_row_meta', 10, 2 );

/**
 * Register a submenu item in the top-level menu item "Settings"
 */
function spacexchimp_p005_register_submenu_page() {

    $page_title  = SPACEXCHIMP_P005_NAME;
    $menu_title  = __( 'Social Media Follow Buttons', SPACEXCHIMP_P005_TEXT );
    $capability  = 'manage_options';
    $menu_slug   = SPACEXCHIMP_P005_SLUG;
    $function    = 'spacexchimp_p005_render_submenu_page';

    add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
}
add_action( 'admin_menu', 'spacexchimp_p005_register_submenu_page' );

/**
 * Register settings
 */
function spacexchimp_p005_register_settings() {
    register_setting( SPACEXCHIMP_P005_SETTINGS . '_settings_group', SPACEXCHIMP_P005_SETTINGS . '_settings' );
    register_setting( SPACEXCHIMP_P005_SETTINGS . '_settings_group_si', SPACEXCHIMP_P005_SETTINGS . '_service_info' );
}
add_action( 'admin_init', 'spacexchimp_p005_register_settings' );

/**
 * Branded footer text on the plugin's settings page
 */
function spacexchimp_p005_admin_footer_text() {

    // Get current screen data
    $current_screen = get_current_screen();

    // Return if the page is not a settings page of this plugin
    $settings_page = 'settings_page_' . SPACEXCHIMP_P005_SLUG;
    if ( $settings_page != $current_screen->id ) return;

    // Filter footer text
    function spacexchimp_p005_new_admin_footer_text() {
        $year = date('Y');
        return "Copyright &copy; " . $year . " <a href='https://www.spacexchimp.com' target='_blank'>Space X-Chimp</a> | Click <a href='https://www.spacexchimp.com/store.html' target='_blank'>here</a> to see our other products.";
    }
    add_filter( 'admin_footer_text', 'spacexchimp_p005_new_admin_footer_text', 11 );
}
add_action( 'current_screen', 'spacexchimp_p005_admin_footer_text' );
