<?php
/**
 * Snax Item Ajax Functions
 *
 * @package snax
 * @subpackage Ajax
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Add new image item to existing post
 */
function snax_ajax_add_image_item() {
	check_ajax_referer( 'snax-add-image-item', 'security' );

	/** Required fields */

	// Sanitize media id.
	$media_id = (int) filter_input( INPUT_POST, 'snax_media_id', FILTER_SANITIZE_NUMBER_INT ); // Removes all illegal characters from a number.

	if ( 0 === $media_id ) {
		snax_ajax_response_error( 'Item uploaded image id not set!' );
		exit;
	}

	// Sanitize author id.
	$author_id = (int) filter_input( INPUT_POST, 'snax_author_id', FILTER_SANITIZE_NUMBER_INT );

	if ( 0 === $author_id ) {
		snax_ajax_response_error( 'Author (submitter) id not set!' );
		exit;
	}

	if ( ! user_can( $author_id, 'snax_add_items' ) ) {
		wp_die( esc_html__( 'Cheatin&#8217; uh?', 'snax' ) );
	}

	// Legal.
	$legal = filter_input( INPUT_POST, 'snax_legal', FILTER_SANITIZE_STRING );

	if ( empty( $legal ) && snax_legal_agreement_required() ) {
		snax_ajax_response_error( 'Legal agreement not accepted!' );
		exit;
	}

	/** Options fields */

	// Sanitize post id.
	$post_id = (int) filter_input( INPUT_POST, 'snax_post_id', FILTER_SANITIZE_NUMBER_INT ); // Removes all illegal characters from a number.

	// Sanitize title.
	$title = snax_sanitize_item_title( filter_input( INPUT_POST, 'snax_title', FILTER_SANITIZE_STRING ) ); // Remove all HTML tags from a string.

	// Sanitize source.
	$source = snax_sanitize_item_source( filter_input( INPUT_POST, 'snax_source', FILTER_SANITIZE_STRING ) ); // Remove all HTML tags from a string.

	// Sanitize description.
	$description = snax_sanitize_item_content( filter_input( INPUT_POST, 'snax_description', FILTER_SANITIZE_STRING ) );

	// Sanitize status.
	$status = filter_input( INPUT_POST, 'snax_status', FILTER_SANITIZE_STRING );

	// Sanitize parent format.
	$parent_format = filter_input( INPUT_POST, 'snax_parent_format', FILTER_SANITIZE_STRING );

	// Sanitize origin.
	$origin = snax_sanitize_item_origin_value( filter_input( INPUT_POST, 'snax_origin', FILTER_SANITIZE_STRING ) );

	if ( empty( $origin ) ) {
		$origin = 'post';
	}

	// Add item.
	$item_id = snax_add_image_item( $post_id, array(
		'title'         => $title,
		'media_id'      => $media_id,
		'source'        => $source,
		'description'   => $description,
		'author_id'     => $author_id,
		'status'        => $status,
		'parent_format' => $parent_format,
		'origin'        => $origin,
	) );

	if ( is_wp_error( $item_id ) ) {
		snax_ajax_response_error( 'Failed to create new item.', array(
			'error_code'    => $item_id->get_error_code(),
			'error_message' => $item_id->get_error_message(),
		) );
		exit;
	}

	$url_var = snax_get_url_var( 'item_submission' );

	$response_args = array(
		'item_id'      => $item_id,
		'redirect_url' => add_query_arg( $url_var, 'success', get_permalink( $item_id ) ),
	);

	snax_ajax_response_success( 'Item added successfully.', $response_args );
	exit;
}

/**
 * Add new embed item to existing post
 */
function snax_ajax_add_embed_item() {
	check_ajax_referer( 'snax-add-embed-item', 'security' );

	/** Required fields */

	// Read raw embed code, can be url or iframe.
	$embed_code = filter_input( INPUT_POST, 'snax_embed_code' ); // Use defaulf filter to keep raw code.

	// Sanitize the code, return value must be url to use with [embed] shortcode.
	$embed_meta = snax_get_embed_metadata( $embed_code );

	if ( false === $embed_meta ) {
		snax_ajax_response_error( 'Provided URL or embed code is not allowed!' );
		exit;
	}

	// Sanitize author id.
	$author_id = (int) filter_input( INPUT_POST, 'snax_author_id', FILTER_SANITIZE_NUMBER_INT );

	if ( 0 === $author_id ) {
		snax_ajax_response_error( 'Author (submitter) id not set!' );
		exit;
	}

	if ( ! user_can( $author_id, 'snax_add_items' ) ) {
		wp_die( esc_html__( 'Cheatin&#8217; uh?', 'snax' ) );
	}

	// Legal.
	$legal = filter_input( INPUT_POST, 'snax_legal', FILTER_SANITIZE_STRING );

	if ( empty( $legal ) && snax_legal_agreement_required() ) {
		snax_ajax_response_error( 'Legal agreement not accepted!' );
		exit;
	}

	/** Options fields */

	// Sanitize post id.
	$post_id = (int) filter_input( INPUT_POST, 'snax_post_id', FILTER_SANITIZE_NUMBER_INT ); // Removes all illegal characters from a number.

	// Sanitize title.
	$title = snax_sanitize_item_title( filter_input( INPUT_POST, 'snax_title', FILTER_SANITIZE_STRING ) ); // Remove all HTML tags from a string.

	// Sanitize description.
	$description = snax_sanitize_item_content( filter_input( INPUT_POST, 'snax_description', FILTER_SANITIZE_STRING ) );

	// Sanitize status.
	$status = filter_input( INPUT_POST, 'snax_status', FILTER_SANITIZE_STRING );

	// Sanitize parent format.
	$parent_format = filter_input( INPUT_POST, 'snax_parent_format', FILTER_SANITIZE_STRING );

	// Sanitize origin.
	$origin = snax_sanitize_item_origin_value( filter_input( INPUT_POST, 'snax_origin', FILTER_SANITIZE_STRING ) );

	if ( empty( $origin ) ) {
		$origin = 'post';
	}

	// Add item.
	$item_id = snax_add_embed_item( $post_id, array(
		'title'         => $title,
		'author_id'     => $author_id,
		'embed_meta'    => $embed_meta,
		'description'   => $description,
		'status'        => $status,
		'parent_format' => $parent_format,
		'origin'        => $origin,
	) );

	if ( is_wp_error( $item_id ) ) {
		snax_ajax_response_error( 'Failed to create new embed item.', array(
			'error_code'    => $item_id->get_error_code(),
			'error_message' => $item_id->get_error_message(),
		) );
		exit;
	}

	$url_var = snax_get_url_var( 'item_submission' );

	$response_args = array(
		'item_id'      => $item_id,
		'redirect_url' => add_query_arg( $url_var, 'success', get_permalink( $item_id ) ),
	);

	snax_ajax_response_success( 'Item (embed) added successfully.', $response_args );
	exit;
}

/**
 * Delete item ajax handler
 */
function snax_ajax_delete_item() {
	// Sanitize item id.
	$item_id = (int) filter_input( INPUT_POST, 'snax_item_id', FILTER_SANITIZE_NUMBER_INT ); // Removes all illegal characters from a number.

	if ( 0 === $item_id ) {
		snax_ajax_response_error( 'Item id not set!' );
		exit;
	}

	$parent_id = wp_get_post_parent_id( $item_id );

	check_ajax_referer( 'snax-delete-item-' . $item_id, 'security' );

	// Sanitize user id.
	$user_id = (int) filter_input( INPUT_POST, 'snax_user_id', FILTER_SANITIZE_NUMBER_INT );

	if ( 0 === $user_id ) {
		snax_ajax_response_error( 'User id not set!' );
		exit;
	}

	if ( ! user_can( $user_id, 'snax_delete_items', $item_id ) ) {
		wp_die( esc_html__( 'Cheatin&#8217; uh?', 'snax' ) );
	}

	$deleted = snax_delete_item( $item_id, $user_id );

	if ( is_wp_error( $deleted ) ) {
		snax_ajax_response_error( sprintf( 'Failed to delete item with id %d', $item_id ), array(
			'error_code'    => $deleted->get_error_code(),
			'error_message' => $deleted->get_error_message(),
		) );
		exit;
	}

	$response_args = array(
		'redirect_url' => add_query_arg( 'snax_item_deleted', 'success', get_permalink( $parent_id ) ),
	);

	snax_ajax_response_success( 'Item deleted successfully.', $response_args );
	exit;
}

/**
 * Set item as Featured ajax handler
 */
function snax_ajax_set_item_as_featured() {
	// Sanitize item id.
	$item_id = (int) filter_input( INPUT_POST, 'snax_item_id', FILTER_SANITIZE_NUMBER_INT ); // Removes all illegal characters from a number.

	if ( 0 === $item_id ) {
		snax_ajax_response_error( 'Item id not set!' );
		exit;
	}

	check_ajax_referer( 'snax-set-item-as-featured-' . $item_id, 'security' );

	// Sanitize user id.
	$user_id = (int) filter_input( INPUT_POST, 'snax_user_id', FILTER_SANITIZE_NUMBER_INT );

	if ( 0 === $user_id ) {
		snax_ajax_response_error( 'User id not set!' );
		exit;
	}

	$item = get_post( $item_id );
	$item_author_id = (int) $item->post_author;

	$is_author = ( $item_author_id === $user_id );

	if ( ! $is_author && ! user_can( $user_id, 'administrator' ) ) {
		wp_die( esc_html__( 'Cheatin&#8217; uh?', 'snax' ) );
	}

	$deleted = snax_set_item_as_featured( $item_id );

	if ( is_wp_error( $deleted ) ) {
		snax_ajax_response_error( sprintf( 'Failed to set item with id %d', $item_id ), array(
			'error_code'    => $deleted->get_error_code(),
			'error_message' => $deleted->get_error_message(),
		) );
		exit;
	}

	snax_ajax_response_success( 'Item set successfully.' );
	exit;
}

/**
 * Update items data (title, source, description)
 */
function snax_ajax_update_items() {
	check_ajax_referer( 'snax-frontend-submission', 'security' );

	$raw_data = filter_input_array( INPUT_POST, array(
		'snax_items' => array(
			'filter' => FILTER_DEFAULT,
			'flags'  => FILTER_REQUIRE_ARRAY,
		),
	) );

	$items = (array) $raw_data['snax_items'];

	$errors = array();

	foreach ( $items as $item_index => $item ) {
		$ret = snax_update_item( (int) $item['id'], array(
			'title'       => $item['title'],
			'source'      => $item['source'],
			'description' => $item['description'],
			'order'       => $item_index,
		) );

		if ( is_wp_error( $ret ) ) {
			$errors[] = $ret;
		}
	}

	if ( ! empty( $errors ) ) {
		snax_ajax_response_error( 'Failed to update items', $errors );
		exit;
	}

	snax_ajax_response_success( 'Items updated successfully.' );
	exit;
}
