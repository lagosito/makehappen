<?php
/**
 * Snax Login/Register Functions
 *
 * @package snax
 * @subpackage Functions
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Render login form
 */
function snax_render_login_form() {
	if ( is_user_logged_in() ) {
		return;
	}

	snax_get_template_part( 'form-login' );
}

/**
 * Check where to show WP login form
 *
 * @return bool
 */
function snax_show_wp_login_form() {
	$show = ! snax_disable_wp_login();

	return apply_filters( 'snax_wp_login_form', $show );
}

/**
 * Render login form errors
 *
 * @param string $content       Login form HTML.
 *
 * @return string
 */
function snax_render_login_form_errors( $content ) {
	$content .= '<div class="snax-validation-error snax-login-error-message"></div>';

	return $content;
}
