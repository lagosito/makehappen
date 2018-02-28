<?php
/**
 * Snax Common AJAX Functions
 *
 * @package snax
 * @subpackage Ajax
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Prints ajax response, json encoded
 *
 * @param string $status    Status of the response (success|error).
 * @param string $message   Text message describing response status code.
 * @param array  $args      Response extra arguments.
 *
 * @return void
 */
function snax_ajax_response( $status, $message, $args ) {
	$res = array(
		'status'  => $status,
		'message' => $message,
		'args'    => $args,
	);

	echo wp_json_encode( $res );
}

/**
 * Prints ajax success response, json encoded
 *
 * @param string $message       Text message describing response status code.
 * @param array  $args          Response extra arguments.
 *
 * @return void
 */
function snax_ajax_response_success( $message, $args = array() ) {
	snax_ajax_response( 'success', $message, $args );
}

/**
 * Prints ajax error response, json encoded
 *
 * @param string $message       Text message describing response status code.
 * @param array  $args          Response extra arguments.
 *
 * @return void
 */
function snax_ajax_response_error( $message, $args = array() ) {
	snax_ajax_response( 'error', $message, $args );
}

/**
 * Return HTML markup for media img tag
 */
function snax_ajax_load_media_tpl() {
	$media_id = filter_input( INPUT_GET, 'snax_media_id', FILTER_SANITIZE_NUMBER_INT );
	$post_id = filter_input( INPUT_GET, 'snax_post_id', FILTER_SANITIZE_NUMBER_INT );

	if ( ! $media_id ) {
		snax_ajax_response_error( 'Media id not set!' );
		exit;
	}

	if ( ! $post_id ) {
		snax_ajax_response_error( 'Post id not set!' );
		exit;
	}

	// Remove all other media. User can have only one uploaded media at once.
	$media = get_post( $media_id );
	$user_id = $media->post_author;

	snax_remove_user_uploaded_media( $user_id, array( 'post__not_in' => array( $media_id ) ) );

	// Mark as snax uploaded media.
	update_post_meta( $media_id, '_snax_media', 'standard' );
	update_post_meta( $media_id, '_snax_media_belongs_to', $post_id );

	add_filter( 'wp_get_attachment_image_src', 'snax_fix_animated_gif_image', 10, 4 );

	$response_args = array(
		'html' => wp_get_attachment_image( $media_id, snax_get_item_image_size() ),
	);

	remove_filter( 'wp_get_attachment_image_src', 'snax_fix_animated_gif_image', 10, 4 );

	snax_ajax_response_success( 'Media HTML tag fetched successfully.', $response_args );
	exit;
}

/**
 * Return HTML markup for embed code/url
 */
function snax_ajax_load_embed_tpl() {
	// Read raw embed code, can be url or iframe.
	$embed_code = filter_input( INPUT_POST, 'snax_embed_code' ); // Use defaulf filter to keep raw code.

	if ( empty( $embed_code ) ) {
		snax_ajax_response_error( 'Embed url not set' );
		exit;
	}

	// Sanitize the code, return value must be url to use with [embed] shortcode.
	$embed_meta = snax_get_embed_metadata( $embed_code );

	if ( false === $embed_meta ) {
		snax_ajax_response_error( 'Provided url is not a valid url to any supported services (like YouTube)' );
		exit;
	}

	$html = wp_oembed_get( $embed_meta['url'] );

	if ( false === $html ) {
		snax_ajax_response_error( 'Failed to load oEmbed HTML' );
		exit;
	}

	$response_args = array(
		'html' => $html,
	);

	snax_ajax_response_success( 'Embed template generated successfully.', $response_args );
	exit;
}

/**
 * Delete media ajax handler
 */
function snax_ajax_delete_media() {
	check_ajax_referer( 'snax-delete-media', 'security' );

	// Sanitize media id.
	$media_id = (int) filter_input( INPUT_POST, 'snax_media_id', FILTER_SANITIZE_NUMBER_INT ); // Removes all illegal characters from a number.

	if ( 0 === $media_id ) {
		snax_ajax_response_error( 'Media id not set!' );
		exit;
	}

	// Sanitize author id.
	$author_id = (int) filter_input( INPUT_POST, 'snax_author_id', FILTER_SANITIZE_NUMBER_INT );

	if ( 0 === $author_id ) {
		snax_ajax_response_error( 'Author id not set!' );
		exit;
	}

	$deleted = snax_delete_media( $media_id, $author_id );

	if ( is_wp_error( $deleted ) ) {
		snax_ajax_response_error( sprintf( 'Failed to delete media with id %d', $media_id ), array(
			'error_code'    => $deleted->get_error_code(),
			'error_message' => $deleted->get_error_message(),
		) );
		exit;
	}

	snax_ajax_response_success( 'Media deleted successfully.' );
	exit;
}

/**
 * Delete media ajax handler
 */
function snax_ajax_update_media_meta() {
	// @todo - use own security
	check_ajax_referer( 'snax-delete-media', 'security' );

	// Sanitize media id.
	$media_id = (int) filter_input( INPUT_POST, 'snax_media_id', FILTER_SANITIZE_NUMBER_INT ); // Removes all illegal characters from a number.

	if ( 0 === $media_id ) {
		snax_ajax_response_error( 'Media id not set!' );
		exit;
	}

	// Sanitize format.
	$format = filter_input( INPUT_POST, 'snax_parent_format', FILTER_SANITIZE_STRING );

	if ( ! $format ) {
		snax_ajax_response_error( 'Parent format not set!' );
		exit;
	}

	$updated = snax_update_media_meta( $media_id, $format );

	if ( is_wp_error( $updated ) ) {
		snax_ajax_response_error( sprintf( 'Failed to update media with id %d', $media_id ), array(
			'error_code'    => $updated->get_error_code(),
			'error_message' => $updated->get_error_message(),
		) );
		exit;
	}

	snax_ajax_response_success( 'Media updated successfully.' );
	exit;
}

/**
 * Delete media ajax handler
 */
function snax_ajax_load_user_uploaded_images() {
	// @todo - use own security
	check_ajax_referer( 'snax-delete-media', 'security' );

	// Sanitize author id.
	$author_id = (int) filter_input( INPUT_GET, 'snax_author_id', FILTER_SANITIZE_NUMBER_INT );

	if ( 0 === $author_id ) {
		snax_ajax_response_error( 'Author id not set!' );
		exit;
	}

	// Sanitize format.
	$format = filter_input( INPUT_GET, 'snax_format', FILTER_SANITIZE_STRING );

	if ( empty( $format ) ) {
		snax_ajax_response_error( 'Format not set!' );
		exit;
	}

	$media = snax_get_user_uploaded_media( $format, $author_id );

	$images = array();

	foreach ( $media as $image ) {
		$images[] = array(
			'url' 			=> wp_get_attachment_url( $image->ID ),
			'thumb'			=> wp_get_attachment_thumb_url( $image->ID ),
			'snax_media_id'	=> $image->ID,
		);
	}

	echo wp_json_encode( $images );
	exit;
}

/**
 * Get list of all tags filtered by term
 */
function snax_ajax_get_tags() {
	$term = filter_input( INPUT_GET, 'snax_term', FILTER_SANITIZE_STRING );

	$args = apply_filters( 'snax_ajax_tags_query_args', array(
		'name__like'	=> $term,
		'number'		=> 10,
	) );

	$arr = snax_get_tags_array( -1, $args );

	snax_ajax_response_success( 'Tags loaded successfully.', array(
		'tags' => $arr,
	) );
	exit;
}

/**
 * Ajax login action
 */
function snax_ajax_login() {
	check_ajax_referer( 'snax-ajax-login-nonce', 'security', true );

	$credentials = array();
	$credentials['user_login'] 		= filter_input( INPUT_POST, 'log', FILTER_SANITIZE_STRING );
	$credentials['user_password']	= filter_input( INPUT_POST, 'pwd', FILTER_SANITIZE_STRING );
	$credentials['remember'] 		= filter_input( INPUT_POST, 'rememberme', FILTER_SANITIZE_STRING );

	$secure_cookie = is_ssl();

	$user = wp_signon( $credentials, $secure_cookie );

	if ( is_wp_error( $user ) ){
		$message = $user->get_error_message();
		snax_ajax_response_error($message);
		exit;
	}

	$response_args = array(
		'redirect_url' => filter_input( INPUT_POST, 'redirect_to', FILTER_SANITIZE_STRING ),
	);

	snax_ajax_response_success( 'Log in successfull', $response_args );
	exit;
}

/**
 *
 */
function snax_ajax_save_image_from_url() {
	check_ajax_referer( 'snax-add-image-item', 'security' );

	// Sanitize image url.
	$image_url = filter_input( INPUT_POST, 'snax_image_url', FILTER_SANITIZE_URL );

	if ( 0 === $image_url ) {
		snax_ajax_response_error( 'Image url not set!' );
		exit;
	}

	// Sanitize author id.
	$author_id = (int) filter_input( INPUT_POST, 'snax_author_id', FILTER_SANITIZE_NUMBER_INT );

	if ( 0 === $author_id ) {
		snax_ajax_response_error( 'Author id not set!' );
		exit;
	}

	$saved = snax_save_image_from_url( $image_url, $author_id );

	if ( is_wp_error( $saved ) ) {
		snax_ajax_response_error( 'Failed to saved image.', array(
			'error_code'    => $saved->get_error_code(),
			'error_message' => $saved->get_error_message(),
		) );
		exit;
	}

	snax_ajax_response_success( 'Image saved successfully.', array(
		'image_id' => $saved
	) );
	exit;
}