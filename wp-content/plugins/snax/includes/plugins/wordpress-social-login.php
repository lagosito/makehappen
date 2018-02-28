<?php
/**
 * Wordpress Social Login plugin functions
 *
 * @package snax
 * @subpackage Plugins
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

add_action( 'snax_login_form_top',                  'snax_wsl_render_auth_widget_in_wp_login_form' );
add_action( 'wsl_render_auth_widget_start',         'snax_wsl_render_auth_widget_start' );
add_action( 'wsl_render_auth_widget_end',           'snax_wsl_render_auth_widget_end' );
add_filter( 'snax_disable_wp_login_option_active',  '__return_true' );


add_filter( 'wsl_render_auth_widget_alter_provider_name', 'snax_wsl_prefix_provider_name' );

/**
 * Render WPSL widget inside the snax login form.
 */
function snax_wsl_render_auth_widget_in_wp_login_form() {
	 echo filter_var( wsl_render_auth_widget() );
}

/**
 * Render the opening tag of our custom wrapper for styling purposes
 */
function snax_wsl_render_auth_widget_start() {
	if ( 'none' === get_option( 'wsl_settings_social_icon_set' ) ) {
		echo '<div class="snax snax-wpsl-wrapper">';
			echo '<div class="snax-wpsl">';

	}
}

/**
 * Render the closing tag of our custom wrapper for styling purposes
 */
function snax_wsl_render_auth_widget_end() {
	if ( 'none' === get_option( 'wsl_settings_social_icon_set' ) ) {
			echo '</div>';
		echo '</div>';
	}
}

/**
 * Prefix the provider name with a CTA
 *
 * @param string $provider_name Provider name like Facebook, Twitter, etc.
 *
 * @return string
 */
function snax_wsl_prefix_provider_name( $provider_name ) {
	$provider_name = esc_html( sprintf( __( 'Connect with %s', 'snax' ), $provider_name ) );

	return $provider_name;
}
