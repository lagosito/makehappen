<?php
/**
 * Snax Frontend Submission Formats Functions
 *
 * @package snax
 * @subpackage Functions
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Image submission handler
 *
 * @param array $data             Image data.
 * @param WP    $request          Request object.
 */
function snax_process_image_submission( $data, $request ) {
	$post_id = snax_create_image( $data );

	if ( ! is_wp_error( $post_id ) ) {
		$url_var = snax_get_url_var( 'post_submission' );
		$redirect_url = add_query_arg( $url_var, 'success', get_permalink( $post_id ) );

		$redirect_url = apply_filters( 'snax_new_post_redirect_url', $redirect_url, $post_id );

		$request->set_query_var( 'snax_redirect_to_url', $redirect_url );
	}
}

/**
 * Meme submission handler
 *
 * @param array $data             Image data.
 * @param WP    $request          Request object.
 */
function snax_process_meme_submission( $data, $request ) {
	$meme_raw = filter_input( INPUT_POST, 'snax-post-meme' );
	$meme_filtered = explode( ',', $meme_raw );
	$meme_decoded = base64_decode( $meme_filtered[1] );

	$data['meme'] = $meme_decoded;

	$post_id = snax_create_meme( $data );

	if ( ! is_wp_error( $post_id ) ) {
		$url_var = snax_get_url_var( 'post_submission' );
		$redirect_url = add_query_arg( $url_var, 'success', get_permalink( $post_id ) );

		$redirect_url = apply_filters( 'snax_new_post_redirect_url', $redirect_url, $post_id );

		$request->set_query_var( 'snax_redirect_to_url', $redirect_url );
	}
}

/**
 * Embed submission handler
 *
 * @param array $data             Embed data.
 * @param WP    $request          Request object.
 */
function snax_process_embed_submission( $data, $request ) {
	$post_id = snax_create_embed( $data );

	if ( ! is_wp_error( $post_id ) ) {
		$url_var = snax_get_url_var( 'post_submission' );
		$redirect_url = add_query_arg( $url_var, 'success', get_permalink( $post_id ) );

		$redirect_url = apply_filters( 'snax_new_post_redirect_url', $redirect_url, $post_id );

		$request->set_query_var( 'snax_redirect_to_url', $redirect_url );
	}
}

/**
 * Gallery submission handler
 *
 * @param array $data             Gallery data.
 * @param WP    $request          Request object.
 */
function snax_process_gallery_submission( $data, $request ) {
	$post_id = snax_create_gallery( $data );

	if ( ! is_wp_error( $post_id ) ) {
		$url_var = snax_get_url_var( 'post_submission' );
		$redirect_url = add_query_arg( $url_var, 'success', get_permalink( $post_id ) );

		$redirect_url = apply_filters( 'snax_new_post_redirect_url', $redirect_url, $post_id );

		$request->set_query_var( 'snax_redirect_to_url', $redirect_url );
	}
}

/**
 * List submission handler
 *
 * @param array $data             List data.
 * @param WP    $request          Request object.
 */
function snax_process_open_list_submission( $data, $request ) {
	$list_id = snax_create_open_list( $data );

	if ( ! is_wp_error( $list_id ) ) {
		$url_var = snax_get_url_var( 'post_submission' );
		$redirect_url = add_query_arg( $url_var, 'success', get_permalink( $list_id ) );

		$redirect_url = apply_filters( 'snax_new_post_redirect_url', $redirect_url, $list_id );

		$request->set_query_var( 'snax_redirect_to_url', $redirect_url );
	}
}

/**
 * Text submission handler
 *
 * @param array $data             Text data.
 * @param WP    $request          Request object.
 */
function snax_process_text_submission( $data, $request ) {
	$post_id = snax_create_text( $data );

	if ( ! is_wp_error( $post_id ) ) {
		$url_var = snax_get_url_var( 'post_submission' );
		$redirect_url = add_query_arg( $url_var, 'success', get_permalink( $post_id ) );

		$redirect_url = apply_filters( 'snax_new_post_redirect_url', $redirect_url, $post_id );

		$request->set_query_var( 'snax_redirect_to_url', $redirect_url );
	}
}

/**
 * Trivia quiz submission handler
 *
 * @param array $data             Text data.
 * @param WP    $request          Request object.
 */
function snax_process_trivia_quiz_submission( $data, $request ) {
	$post_id = snax_create_quiz( 'trivia', $data );

	if ( ! is_wp_error( $post_id ) ) {
		$url_var = snax_get_url_var( 'post_submission' );
		$redirect_url = add_query_arg( $url_var, 'success', get_permalink( $post_id ) );

		$redirect_url = apply_filters( 'snax_new_post_redirect_url', $redirect_url, $post_id );

		$request->set_query_var( 'snax_redirect_to_url', $redirect_url );
	}
}

/**
 * Personality quiz submission handler
 *
 * @param array $data             Text data.
 * @param WP    $request          Request object.
 */
function snax_process_personality_quiz_submission( $data, $request ) {
	$post_id = snax_create_quiz( 'personality', $data );

	if ( ! is_wp_error( $post_id ) ) {
		$url_var = snax_get_url_var( 'post_submission' );
		$redirect_url = add_query_arg( $url_var, 'success', get_permalink( $post_id ) );

		$redirect_url = apply_filters( 'snax_new_post_redirect_url', $redirect_url, $post_id );

		$request->set_query_var( 'snax_redirect_to_url', $redirect_url );
	}
}

/**
 * Create new image post
 *
 * @param array $data   Image data.
 *
 * @return int          Created post id.
 */
function snax_create_image( $data ) {
	$format 		= 'image';		// Item format.
	$post_format	= 'image';		// WP post format.
	$media_id		= false;

	$defaults = array(
		'id' 			=> 0,
		'title'         => '',
		'source'        => '',
		'description'   => '',
		'category_id'   => array(),
		'tags'          => '',
		'author'        => get_current_user_id(),
		'status'        => 'pending',
	);

	$data = wp_parse_args( $data, $defaults );

	$author_id  = (int) $data['author'];
	$status 	= $data['status'];

	$orphans = snax_get_user_orphan_items( $format, $data['author'] );

	// We loop over orphans but should be only one.
	// If are more orphans we will use featrued image from last one.
	// At the end, remove all orphans.
	foreach ( $orphans as $orphan ) {
		$media_id = get_post_thumbnail_id( $orphan->ID );

		wp_delete_post( $orphan->ID, true );
	}

	// Prepend media to post content.
	if ( $media_id ) {
		$img = wp_get_attachment_image( $media_id, 'large' );
		$img = str_replace( 'class="', 'class="aligncenter snax-figure-content ', $img );

		global $content_width;

		$figure = '[caption class="snax-figure" align="aligncenter" width="' . intval( $content_width ) . '"]';
		$figure .= $img;

		if ( ! empty( $data['source'] ) ) {
			$figure .= sprintf( '<a class="snax-figure-source" href="%s" rel="nofollow" target="_blank">%s</a>', esc_url( $data['source'] ), esc_url( $data['source'] ) );
		}

		$figure .= '[/caption]';

		$figure = apply_filters( 'snax_image_post_content', $figure, $media_id );

		$data['description'] = $figure . "\n\n" . $data['description'];
	}

	// We build img/a markup so we can allowe here extra attributes.
	$extra_allowed_html = array(
		'img' => array(
			'src' 		=> true,
			'class'		=> true,
			'alt' 		=> true,
			'width'		=> true,
			'height'	=> true,
			'srcset'	=> true,
		),
		'a' => array(
			'href' 		=> true,
			'class' 	=> true,
			'rel' 		=> true,
			'target'	=> true,
		),
	);

	$content = snax_kses_post( $data['description'], $extra_allowed_html );

	$new_post = array(
		'post_title'    => wp_strip_all_tags( $data['title'] ),
		'post_content'  => $content,
		'post_author'   => $author_id,
		'post_status'   => $status,
		'post_type'     => 'post',
		'ID'			=> $data['id'],
	);

	$post_id = wp_insert_post( $new_post );

	if ( 0 === $post_id ) {
		return new WP_Error( 'snax_image_creating_failed', esc_html__( 'Some errors occured while creating image.', 'snax' ) );
	}

	// Assign category.
	$category_id = $data['category_id'];

	if ( ! empty( $category_id ) ) {
		wp_set_post_categories( $post_id, $category_id );
	}

	// Reassign tags.
	snax_remove_post_tags( $post_id );

	$tags = $data['tags'];

	if ( ! empty( $tags ) ) {
		wp_set_post_tags( $post_id, $tags, true );
	}

	// Set snax item featrued media as post (image) featured media.
	if ( $media_id ) {
		set_post_thumbnail( $post_id, $media_id );

		// Attach featured media to item (Media Library, the "Uploded to" column).
		wp_update_post( array(
			'ID'            => $media_id,
			'post_parent'   => $post_id,
		) );
	}

	// Set WP post format.
	if ( $post_format ) {
		set_post_format( $post_id, $post_format );
	}

	// Format.
	add_post_meta( $post_id, '_snax_format', $format );

	// IP.
	add_post_meta( $post_id, '_snax_author_ip', snax_get_ip_address() );

	do_action( 'snax_post_added', $post_id, 'image' );

	return $post_id;
}

/**
 * Create new meme post
 *
 * @param array $data   Meme data.
 *
 * @return int          Created post id.
 */
function snax_create_meme( $data ) {
	$format 			= 'meme';		// Item format.
	$post_format		= 'image';		// WP post format.
	$meme_background_id	= false;

	$defaults = array(
		'id'         => 0,
		'title'         => '',
		'source'        => '',
		'description'   => '',
		'meme'   		=> '',
		'category_id'   => array(),
		'tags'          => '',
		'author'        => get_current_user_id(),
		'status'        => 'pending',
	);

	$data = wp_parse_args( $data, $defaults );

	$author_id  = (int) $data['author'];
	$status 	= $data['status'];

	$orphans = snax_get_user_orphan_items( $format, $data['author'] );

	// We loop over orphans but should be only one.
	// If are more orphans we will use featrued image from last one.
	// At the end, remove all orphans.
	foreach ( $orphans as $orphan ) {
		$meme_background_id = get_post_thumbnail_id( $orphan->ID );

		wp_delete_post( $orphan->ID, true );
	}

	$meme_background = get_post( $meme_background_id );

	// Add meta for further processing.
	add_post_meta( $meme_background->ID, 'snax_meme_background', true );

	// Save meme image (Base 64).
	$upload_dir 		= wp_upload_dir();
	$upload_dest_dir 	= trailingslashit( $upload_dir['path'] );
	$meme_filename 		= 'meme-' . $meme_background->post_title . '.jpg';
	$meme_path			= $upload_dest_dir . $meme_filename;

	// Save in uploads dir.
	@file_put_contents( $meme_path, $data['meme'] );

	$attachment = array(
		'post_mime_type'	=> 'image/jpeg',
		'post_title' 		=> wp_strip_all_tags( $data['title'] ),
		'post_content' 		=> '',
		'post_status' 		=> 'inherit',
	);

	$meme_id = wp_insert_attachment( $attachment, $meme_path );

	require_once( ABSPATH . 'wp-admin/includes/image.php' );

	$media_data = wp_generate_attachment_metadata( $meme_id, $meme_path );
	wp_update_attachment_metadata( $meme_id,  $media_data );

	// Prepend media to post content.
	if ( $meme_id ) {
		$img = wp_get_attachment_image( $meme_id, 'large' );
		$img = str_replace( 'class="', 'class="aligncenter snax-figure-content ', $img );

		global $content_width;

		$figure = '[caption class="snax-figure" align="aligncenter" width="' . intval( $content_width ) . '"]';
		$figure .= $img;

		if ( ! empty( $data['source'] ) ) {
			$figure .= sprintf( '<a class="snax-figure-source" href="%s" rel="nofollow" target="_blank">%s</a>', esc_url( $data['source'] ), esc_url( $data['source'] ) );
		}

		$figure .= '[/caption]';

		$data['description'] = $figure . "\n\n" . $data['description'];
	}

	// We build img/a markup so we can allow here extra attributes.
	$extra_allowed_html = array(
		'img' => array(
			'src' 		=> true,
			'class'		=> true,
			'alt' 		=> true,
			'width'		=> true,
			'height'	=> true,
			'srcset'	=> true,
		),
		'a' => array(
			'href' 		=> true,
			'class' 	=> true,
			'rel' 		=> true,
			'target'	=> true,
		),
	);

	$content = snax_kses_post( $data['description'], $extra_allowed_html );

	$new_post = array(
		'post_title'    => wp_strip_all_tags( $data['title'] ),
		'post_content'  => $content,
		'post_author'   => $author_id,
		'post_status'   => $status,
		'post_type'     => 'post',
		'ID'			=> $data['id'],
	);

	$post_id = wp_insert_post( $new_post );

	if ( 0 === $post_id ) {
		return new WP_Error( 'snax_meme_creating_failed', esc_html__( 'Some errors occured while creating meme.', 'snax' ) );
	}

	// Assign category.
	$category_id = $data['category_id'];

	if ( ! empty( $category_id ) ) {
		wp_set_post_categories( $post_id, $category_id );
	}

	// Reassign tags.
	snax_remove_post_tags( $post_id );

	$tags = $data['tags'];

	if ( ! empty( $tags ) ) {
		wp_set_post_tags( $post_id, $tags, true );
	}

	// Attach original image to post.
	if ( $meme_background_id ) {
		// Attach media to item (Media Library, the "Uploded to" column).
		wp_update_post( array(
			'ID'            => $meme_background_id,
			'post_parent'   => $post_id,
		) );
	}

	// Set snax item featrued media as post (meme) featured media.
	if ( $meme_id ) {
		set_post_thumbnail( $post_id, $meme_id );

		// Attach featured media to item (Media Library, the "Uploded to" column).
		wp_update_post( array(
			'ID'            => $meme_id,
			'post_parent'   => $post_id,
		) );
	}

	// Set WP post format.
	if ( $post_format ) {
		set_post_format( $post_id, $post_format );
	}

	// Format.
	add_post_meta( $post_id, '_snax_format', $format );

	// IP.
	add_post_meta( $post_id, '_snax_author_ip', snax_get_ip_address() );

	do_action( 'snax_post_added', $post_id, 'meme' );

	return $post_id;
}

/**
 * Create new embed post
 *
 * @param array $data   Embed data.
 *
 * @return int          Created post id.
 */
function snax_create_embed( $data ) {
	$format = 'embed';
	$post_format = false;
	$embed_url = '';
	$embed_provider_name = '';

	$defaults = array(
		'id'			=> 0,
		'title'         => '',
		'description'   => '',
		'category_id'   => array(),
		'author'        => get_current_user_id(),
		'status'		=> 'pending',
	);

	$data = wp_parse_args( $data, $defaults );

	$author_id  = (int) $data['author'];
	$status 	= $data['status'];

	$orphans = snax_get_user_orphan_items( $format, $author_id );

	// We loop over orphans but should be only one.
	// If there are more orphans we will use embed from the last one.
	// At the end, remove all orphans.
	foreach ( $orphans as $orphan ) {
		$embed_url = snax_get_first_url_in_content( $orphan );
		$embed_provider_name = get_post_meta( $orphan->ID, '_snax_embed_provider_name', true );

		$post_format = get_post_format( $orphan );

		wp_delete_post( $orphan->ID, true );
	}

	// Prepend embed url to post content.
	$data['description'] = $embed_url . "\n\n" . $data['description'];

	$new_post = array(
		'post_title'    => wp_strip_all_tags( $data['title'] ),
		'post_content'  => snax_kses_post( $data['description'] ),
		'post_author'   => $author_id,
		'post_status'   => $status,
		'post_type'     => 'post',
		'ID'			=> $data['id'],
	);

	$post_id = wp_insert_post( $new_post );

	if ( 0 === $post_id ) {
		return new WP_Error( 'snax_embed_creating_failed', esc_html__( 'Some errors occured while creating embed.', 'snax' ) );
	}

	// Assign category.
	$category_id = $data['category_id'];

	if ( ! empty( $category_id ) ) {
		wp_set_post_categories( $post_id, $category_id );
	}

	// Reassign tags.
	snax_remove_post_tags( $post_id );

	$tags = $data['tags'];

	if ( ! empty( $tags ) ) {
		wp_set_post_tags( $post_id, $tags, true );
	}

	// Set WP post format.
	if ( $post_format ) {
		set_post_format( $post_id, $post_format );
	}

	// Set post metadata.
	add_post_meta( $post_id, '_snax_format', $format );
	add_post_meta( $post_id, '_snax_embed_provider_name', $embed_provider_name );

	// IP.
	add_post_meta( $post_id, '_snax_author_ip', snax_get_ip_address() );

	do_action( 'snax_post_added', $post_id, 'embed' );

	return $post_id;
}

/**
 * Create new gallery post
 *
 * @param array $data   Gallery data.
 *
 * @return int          Created post id.
 */
function snax_create_gallery( $data ) {
	$defaults = array(
		'id' 			=> 0,
		'title'         => '',
		'description'   => '',
		'category_id'   => array(),
		'author'        => get_current_user_id(),
		'status'        => 'pending',
	);

	$data = wp_parse_args( $data, $defaults );

	$author_id  = (int) $data['author'];
	$status 	= $data['status'];

	$new_post = array(
		'post_title'    => wp_strip_all_tags( $data['title'] ),
		'post_content'  => snax_kses_post( $data['description'] ),
		'post_author'   => $author_id,
		'post_status'   => $status,
		'post_type'     => 'post',
		'ID'			=> $data['id'],
	);

	$post_id = wp_insert_post( $new_post );

	if ( 0 === $post_id ) {
		return new WP_Error( 'snax_gallery_creating_failed', esc_html__( 'Some errors occured while creating gallery.', 'snax' ) );
	}

	// Assign category.
	$category_id = $data['category_id'];

	if ( ! empty( $category_id ) ) {
		wp_set_post_categories( $post_id, $category_id );
	}

	// Reassign tags.
	snax_remove_post_tags( $post_id );

	$tags = $data['tags'];

	if ( ! empty( $tags ) ) {
		wp_set_post_tags( $post_id, $tags, true );
	}

	// Set image meta data.
	add_post_meta( $post_id, '_snax_format', 'gallery' );

	// IP.
	add_post_meta( $post_id, '_snax_author_ip', snax_get_ip_address() );

	snax_attach_user_orphan_items_to_post( $post_id, $data['author'] );
	snax_set_first_image_item_as_post_featured( $post_id );

	do_action( 'snax_post_added', $post_id, 'gallery' );

	return $post_id;
}

/**
 * Create new text post
 *
 * @param array $data   Text data.
 *
 * @return int          Created post id.
 */
function snax_create_text( $data ) {
	$defaults = array(
		'id' 			=> 0,
		'title'         => '',
		'description'   => '',
		'category_id'   => array(),
		'tags'          => '',
		'author'        => get_current_user_id(),
		'status'        => 'pending',
	);

	$data = wp_parse_args( $data, $defaults );

	$author_id  = (int) $data['author'];
	$status 	= $data['status'];
	$content 	= $data['description'];

	$content = force_balance_tags( $content );

	// Convert image to figure.
	$converted = snax_convert_format_elements( $content );

	$content 	= $converted['content'];
	$media_ids 	= $converted['media_ids'];

	// We build img/a markup so we can allowe here extra attributes.
	$extra_allowed_html = array(
		'img' => array(
			'src' 	=> true,
			'class'	=> true,
			'alt' 	=> true,
			'width'		=> true,
			'height'	=> true,
			'srcset'	=> true,
		),
		'a' => array(
			'href' 		=> true,
			'class' 	=> true,
			'rel' 		=> true,
			'target'	=> true,
		),
	);

	$content = snax_kses_post( $content, $extra_allowed_html );

	$content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );

	$new_post = array(
		'post_title'    => wp_strip_all_tags( $data['title'] ),
		'post_content'  => $content,
		'post_author'   => $author_id,
		'post_status'   => $status,
		'post_type'     => 'post',
		'ID'			=> $data['id'],
	);

	$post_id = wp_insert_post( $new_post );

	if ( 0 === $post_id ) {
		return new WP_Error( 'snax_text_creating_failed', esc_html__( 'Some errors occured while creating text.', 'snax' ) );
	}

	// Assign media to post.
	foreach ( $media_ids as $media_index => $media_id ) {
		// Attach media to post.
		wp_update_post( array(
			'ID'            => $media_id,
			'post_parent'   => $post_id,
		) );
	}

	// Set featured image.
	$featured_image = snax_get_format_featured_image( 'text', $author_id, $data['id'] );

	if ( $featured_image ) {
		set_post_thumbnail( $post_id, $featured_image->ID );

		snax_reset_format_featured_image( $featured_image );
	}

	// Assign category.
	$category_id = $data['category_id'];

	if ( ! empty( $category_id ) ) {
		wp_set_post_categories( $post_id, $category_id );
	}

	// Reassign tags.
	snax_remove_post_tags( $post_id );

	$tags = $data['tags'];

	if ( ! empty( $tags ) ) {
		wp_set_post_tags( $post_id, $tags, true );
	}

	$format = 'text';

	// Format.
	add_post_meta( $post_id, '_snax_format', $format );

	// IP.
	add_post_meta( $post_id, '_snax_author_ip', snax_get_ip_address() );

	do_action( 'snax_post_added', $post_id, 'text' );

	return $post_id;
}

/**
 * Create new quiz
 *
 * @param string $quiz_type         Quiz type.
 * @param array  $data              Post data.
 *
 * @return int          Created post id.
 */
function snax_create_quiz( $quiz_type, $data ) {
	$defaults = array(
		'title'         => '',
		'description'   => '',
		'category_id'   => array(),
		'author'        => get_current_user_id(),
		'status'        => 'pending',
	);

	$data = wp_parse_args( $data, $defaults );

	$author_id = (int) $data['author'];

	$quiz_id = $data['id'];

	if ( $quiz_id ) {
		$quiz = get_post( $quiz_id );
	} else {
		$quiz = snax_get_user_draft_quizz( $quiz_type, $author_id );
	}

	if ( ! $quiz ) {
		return new WP_Error( 'snax_quiz_creating_failed', esc_html__( 'User draft quiz not exists!.', 'snax' ) );
	}

	$post_id = $quiz->ID;
	$status  = $data['status'];

	$content = snax_kses_post( $data['description'] );
	$content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );

	// New quiz data.
	$post_data = array(
		'ID'            => $post_id,
		'post_title'    => wp_strip_all_tags( $data['title'] ),
		'post_content'  => $content,
		'post_status'   => $status,
		'post_type'     => snax_get_quiz_post_type(),
	);

	// Update quiz.
	wp_insert_post( $post_data );

	// Set featured image.
	$featured_image = snax_get_format_featured_image( $quiz_type . '_quiz', $author_id, $post_id );

	if ( $featured_image ) {
		set_post_thumbnail( $post_id, $featured_image->ID );

		snax_reset_format_featured_image( $featured_image );
	}

	// Assign category.
	$category_id = $data['category_id'];

	if ( ! empty( $category_id ) ) {
		wp_set_post_categories( $post_id, $category_id );
	}

	// Reassign tags.
	snax_remove_post_tags( $post_id );

	$tags = $data['tags'];

	if ( ! empty( $tags ) ) {
		wp_set_post_tags( $post_id, $tags, true );
	}

	// Format.
	add_post_meta( $post_id, '_snax_format', $quiz_type . '_quiz' );

	// Where quiz was created?
	add_post_meta( $post_id, '_snax_origin', 'front' );

	// IP.
	add_post_meta( $post_id, '_snax_author_ip', snax_get_ip_address() );

	do_action( 'snax_post_added', $post_id, 'quiz_' . $quiz_type );

	return $post_id;
}


/**
 * Convert element like img, embeds into figure.
 *
 * @param string $content		Input text.
 *
 * @return array				Content and media to assign.
 */
function snax_convert_format_elements( $content ) {
	// Images.
	$img_pattern 		= '/<img[^>]+>/';
	$img_attrs_pattern	= '/(data-snax-id|data-snax-source|alt)="([^"]*)"/i';
	$media_ids 			= array(); // Store media for further assignment.

	// Find images.
	if ( preg_match_all( $img_pattern, $content, $img_matches ) ) {
		foreach ( $img_matches[0] as $img_tag ) {
			$media_id	= '';
			$source 	= '';
			$alt 		= '';

			// Find attributes.
			if ( preg_match_all( $img_attrs_pattern, $img_tag, $img_attrs ) ) {
				$tags = $img_attrs[1];
				$values = $img_attrs[2];

				foreach ( $tags as $index => $tag ) {
					if ( 'data-snax-id' === $tag ) {
						$media_id = $values[ $index ];
					}

					if ( 'data-snax-source' === $tag ) {
						$source = $values[ $index ];
					}

					if ( 'alt' === $tag ) {
						$alt = $values[ $index ];
					}
				}
			}

			// If image is not valid, we will just strip it (replacing with empty string).
			$figure = '';

			if ( $media_id ) {
				// Get only user attachments.
				$attachments = get_posts( array(
					'p' 		=> $media_id,				// Match id?
					'post_type' => 'attachment',			// Is attachment?
					'author' 	=> get_current_user_id(),	// Belongs to user?
				) );

				// It should be only one.
				foreach ( $attachments as $attachment ) {
					// Store to use it further, when parent post will be created.
					$media_ids[] = $attachment->ID;

					// Build final markup.
					$img = wp_get_attachment_image( $media_id, 'large' );
					$img = str_replace( 'class="', 'class="aligncenter snax-figure-content ', $img );
					$img = str_replace( 'src=', 'alt="'. $alt .'" src=', $img );

					global $content_width;

					$figure .= '[caption class="snax-figure" align="aligncenter" width="' . intval( $content_width ) . '"]';
						$figure .= $img;

						if ( $source ) {
							$figure .= sprintf( '<a class="snax-figure-source" href="%s" rel="nofollow" target="_blank">%s</a>', esc_url( $source ), esc_url( $source ) );
						}
					$figure .= '[/caption]';
				}
			}

			// Replace image with figure.
			$content = str_replace( $img_tag, $figure, $content );
		}
	}

	return array(
		'content' 	=> $content,		// Converted content.
		'media_ids' => $media_ids,		// Medias that were used in content.
	);
}

/**
 * Return all registered formats
 *
 * @return array
 */
function snax_get_formats() {
	$format_var = snax_get_url_var( 'format' );

	$formats = array(
		'text' => array(
			'labels'		=> array(
				'name' 			=> __( 'Story', 'snax' ),
				'add_new'		=> __( 'Submit Story', 'snax' ),
			),
			'description'	=> __( 'Mix text with images and embeds', 'snax' ),
			'position'		=> 10,
			'url'           => add_query_arg( $format_var, 'text' ),
		),
		'image' => array(
			'labels'		=> array(
				'name' 			=> __( 'Image', 'snax' ),
				'add_new'		=> __( 'Upload Image', 'snax' ),
			),
			'description'	=> __( 'Photo, GIF', 'snax' ),
			'position'		=> 20,
			'url'           => add_query_arg( $format_var, 'image' ),
		),
		'gallery' => array(
			'labels'		=> array(
				'name' 			=> __( 'Gallery', 'snax' ),
				'add_new'		=> __( 'Upload Gallery', 'snax' ),
			),
			'description'	=> __( 'A collection of images', 'snax' ),
			'position'		=> 30,
			'url'           => add_query_arg( $format_var, 'gallery' ),
		),
		'embed' => array(
			'labels'		=> array(
				'name' 			=> __( 'Embed', 'snax' ),
				'add_new'		=> __( 'Embed Content', 'snax' ),
			),
			'description'	=> __( 'YouTube videos, Instagram photos, Twitter statuses, etc.', 'snax' ),
			'position'		=> 40,
			'url'           => add_query_arg( $format_var, 'embed' ),
		),
		'list' => array(
			'labels'		=> array(
				'name' 			=> __( 'Open list', 'snax' ),
				'add_new'		=> __( 'Start an Open List', 'snax' ),
			),
			'description'	=> __( 'Everyone can submit new list items and vote up for the best submission', 'snax' ),
			'position'		=> 50,
			'url'           => add_query_arg( $format_var, 'list' ),
		),
		'ranked_list' => array(
			'labels'		=> array(
				'name' 			=> __( 'Ranked list', 'snax' ),
				'add_new'		=> __( 'Create a Ranked List', 'snax' ),
			),
			'description'	=> __( 'Everyone can vote up for the best list item', 'snax' ),
			'position'		=> 60,
			'url'           => add_query_arg( array(
				$format_var => 'list',
				'type' 		=> 'ranked',
			) ),
		),
		'classic_list' => array(
			'labels'		=> array(
				'name' 			=> __( 'Classic list', 'snax' ),
				'add_new'		=> __( 'Create a List', 'snax' ),
			),
			'description'	=> __( 'A list-based article', 'snax' ),
			'position'		=> 70,
			'url'           => add_query_arg( array(
				$format_var => 'list',
				'type' 		=> 'classic',
			) ),
		),
		'meme' => array(
			'labels'		=> array(
				'name' 			=> __( 'Meme', 'snax' ),
				'add_new'		=> __( 'Make a Meme', 'snax' ),
			),
			'description'	=> __( 'Create a funny pic', 'snax' ),
			'position'		=> 80,
			'url'           => add_query_arg( $format_var, 'meme' ),
		),
		'trivia_quiz' => array(
			'labels'		=> array(
				'name' 			=> __( 'Trivia quiz', 'snax' ),
				'add_new'		=> __( 'Create a Trivia Quiz', 'snax' ),
			),
			'description'	=> __( 'What do you know about ...?', 'snax' ),
			'position'		=> 90,
			'url'           => add_query_arg( $format_var, 'trivia_quiz' ),
		),
		'personality_quiz' => array(
			'labels'		=> array(
				'name' 			=> __( 'Personality quiz', 'snax' ),
				'add_new'		=> __( 'Create a Personality Quiz', 'snax' ),
			),
			'description'	=> __( 'What type of person are you?', 'snax' ),
			'position'		=> 100,
			'url'           => add_query_arg( $format_var, 'personality_quiz' ),
		),
	);

	$formats = apply_filters( 'snax_get_formats', $formats );
	$order 	 = snax_get_formats_order();

	// Sort by user defined order.
	if ( ! empty( $order ) ) {
		if ( count( $order ) !== count( $formats ) ) {
			$order = array_unique( array_merge( $order, array_keys( $formats ) ) );
		}

		$sorted = array();

		foreach ( $order as $format_id ) {
			if ( isset( $formats[ $format_id ] ) ) {
				$sorted[ $format_id ] = $formats[ $format_id ];
			}
		}

		$formats = $sorted;
	} else {
		// Sort by position.
		uasort( $formats, 'snax_sort_formats_by_position' );
	}

	return $formats;
}

/**
 * Return only active formats
 *
 * @return array
 */
function snax_get_active_formats() {
	$formats = snax_get_formats();
	$active_formats_ids = snax_get_active_formats_ids();

	foreach ( $formats as $format_id => $format_args ) {
		if ( ! in_array( $format_id, $active_formats_ids, true ) ) {
			unset( $formats[ $format_id ] );
		}
	}

	return $formats;
}

/**
 * Return number of active formats
 *
 * @return int
 */
function snax_get_format_count() {
	return count( snax_get_active_formats() );
}

/**
 * Check wheter format is active
 *
 * @param string $format        Format id.
 *
 * @return bool
 */
function snax_is_active_format( $format ) {
	$formats = snax_get_active_formats();

	$is_active = (bool) isset( $formats[ $format ] );

	// List format is active if at least one of its types is active.
	if ( 'list' === $format && ! $is_active ) {
		 $is_active = isset( $formats['ranked_list'] ) || isset( $formats['classic_list'] );
	}

	return $is_active;
}

/**
 * Callback for uasort.
 *
 * @param array $a             First elemenet to compare.
 * @param array $b             Second elemenet to compare.
 *
 * @return integer
 */
function snax_sort_formats_by_position( $a, $b ) {
	if ( $a['position'] === $b['position'] ) {
		return 0;
	}

	return ( $a['position'] < $b['position']) ? -1 : 1;
}

/**
 * Whether the $post is one of allowed snax formats
 *
 * @param string      $format              Optional. Default is all formats.
 * @param int|WP_Post $post_id             Optional. Post ID or WP_Post object. Default is global `$post`.
 *
 * @return bool
 */
function snax_is_format( $format = null, $post_id = 0 ) {
	$is_format  = false;
	$post       = get_post( $post_id );

	if ( ! empty( $post ) ) {
		$post_format = snax_get_format( $post );

		// Check agains all formats.
		if ( null === $format ) {
			$formats = snax_get_formats();

			$is_format = isset( $formats[ $post_format ] );
			// Check if formats match.
		} else {
			$is_format = $format === $post_format;
		}
	}

	return apply_filters( 'snax_is_format', $is_format, $format, $post );
}

/**
 * Return current post format
 *
 * @param int|WP_Post $post_id             Optional. Post ID or WP_Post object. Default is global `$post`.
 *
 * @return mixed|void
 */
function snax_get_format( $post_id = 0 ) {
	$post = get_post( $post_id );
	$format = null;

	if ( $post ) {
		$format = get_post_meta( $post->ID, '_snax_format', true );
	}

	return apply_filters( 'snax_get_format', $format, $post );
}

/**
 * Return user uploaded image
 *
 * @param string $parent_format     Snax format.
 * @param int    $user_id           User id.
 * @param int    $post_id           Optional. Post id.
 *
 * @return WP_Post                  False if not exists.
 */
function snax_get_format_featured_image( $parent_format, $user_id, $post_id = 0 ) {
	if ( empty( $parent_format ) || empty( $user_id ) ) {
		return false;
	}

	$attachment = false;

	// Get post thumbnail (eg. if it's a draft).
	if ( $post_id ) {
		$post_thumbnail_id = get_post_thumbnail_id( $post_id );

		if ( $post_thumbnail_id ) {
			$attachment = get_post( $post_thumbnail_id );
		}

	// Try to get orphan (post not exists yet).
	} else {
		$attachments = get_posts( array(
			'author' 			=> $user_id,
			'post_type' 		=> 'attachment',
			'meta_key' 			=> '_snax_featured_image_format',
			'meta_value'		=> $parent_format,
			'posts_per_page'	=> 1,
		) );

		if ( ! empty( $attachments ) ) {
			$attachment = $attachments[0];
		}
	}

	return $attachment;
}

/**
 * Make format featured image a regular attachment
 *
 * @param WP_Post $post         Post object or id.
 *
 * @return bool
 */
function snax_reset_format_featured_image( $post ) {
	$post = get_post( $post );

	delete_post_meta( $post->ID, '_snax_featured_image_format' );
}

function snax_replace_formats_upload_form( $replace, $format ) {
	// Story.
	if ( in_array( $format, array( 'text', 'trivia_quiz', 'personality_quiz' ), true ) ) {
		$replace['out']['drop_files'] = __( 'Drop Featured Image Here', 'snax' );
		$replace['out']['select_files'] = __( 'Select File', 'snax' );

		$replace['in']['class']		= 'class="button"';
		$replace['out']['class'] 	= 'class="g1-button g1-button-s g1-button-simple"';
	}

	// Image and Meme.
	if ( in_array( $format, array( 'image', 'meme' ), true ) ) {
		$replace['out']['drop_files'] = __( 'Drop file here', 'snax' );
		$replace['out']['select_files'] = __( 'Select File', 'snax' );
	}

	return $replace;
}