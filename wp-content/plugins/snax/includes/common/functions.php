<?php
/**
 * Snax Common Functions
 *
 * @package snax
 * @subpackage Functions
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Assist pagination by returning correct page number
 *
 * @return int Current page number
 */
function snax_get_paged() {
	global $wp_query;

	// Check the query var.
	if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );

		// Check query paged.
	} elseif ( ! empty( $wp_query->query['paged'] ) ) {
		$paged = $wp_query->query['paged'];
	}

	// Paged found.
	if ( ! empty( $paged ) ) {
		return (int) $paged;
	}

	// Default to first page.
	return 1;
}

/**
 * Snax method of formatting numeric values
 *
 * @param float  $number Number being formatted.
 * @param bool   $decimals Number of decimal points.
 * @param string $dec_point Separator for decimal point.
 * @param string $thousands_sep Thousends separator.
 *
 * @return float
 */
function snax_number_format( $number, $decimals = false, $dec_point = '.', $thousands_sep = ',' ) {
	if ( ! is_numeric( $number ) ) {
		$number = 0;
	}

	return apply_filters( 'snax_number_format', number_format( $number, $decimals, $dec_point, $thousands_sep ), $number, $decimals, $dec_point, $thousands_sep );
}

/**
 * Return the date formatted and localized
 *
 * @param string $date_string Date string in any valid format.
 *
 * @return string                   Localized date.
 */
function snax_date_format( $date_string ) {
	$format = apply_filters( 'snax_datetime_format', get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) );

	return date_i18n( $format, strtotime( $date_string ) );
}

/**
 * Configure Plupload file-uploader
 *
 * @param array $config Default config.
 *
 * @return array
 */
function snax_plupload_config( $config ) {
	if ( is_admin() ) {
		return $config;
	}

	if ( ! isset( $config['filters'] ) ) {
		$config['filters'] = array();
	}

	$config['filters']['mime_types'] = array(
		array(
			'title'      => __( 'Image files', 'snax' ),
			'extensions' => implode( ',', snax_get_image_allowed_types() ),
		),
	);

	$max_file_size = snax_get_max_upload_size();

	$config['filters']['max_file_size'] = $max_file_size . 'b';

	$config['multi_selection'] = false;

	return apply_filters( 'snax_plupload_config', $config );
}

/**
 * Override WP limit to get more control over uploaded images
 */
function snax_set_new_upload_size_limit() {
	add_filter( 'upload_size_limit', 'snax_get_max_upload_size', 10, 3 );
}

/**
 * Revert to original WP limits
 */
function snax_reset_upload_size_limit() {
	remove_filter( 'upload_size_limit', 'snax_get_max_upload_size', 10, 3 );
}

/**
 * Allow Snax Author to upload image
 */
function snax_allow_snax_author_to_upload() {
	add_filter( 'upload_post_params', 'snax_add_media_action_param' );
}

/**
 * Deny Snax Author to upload image
 */
function snax_deny_snax_author_to_upload() {
	remove_filter( 'upload_post_params', 'snax_add_media_action_param' );
}

/**
 * Return vistor IP address
 *
 * @return string
 */
function snax_get_ip_address() {
	$http_x_forwarder_for = filter_input( INPUT_SERVER, 'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_STRING );
	$remote_addr          = filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING );

	if ( empty( $http_x_forwarder_for ) ) {
		$ip_address = $remote_addr;
	} else {
		$ip_address = $http_x_forwarder_for;
	}

	if ( false !== strpos( $ip_address, ',' ) ) {
		$ip_address = explode( ',', $ip_address );
		$ip_address = $ip_address[0];
	}

	return $ip_address;
}

/**
 * Return registered social share links
 *
 * @return array
 */
function snax_get_share_links() {


	$links = array(
		'facebook'  => array(
			'pattern' => 'https://www.facebook.com/sharer.php?u=[PERMALINK]&amp;t=[TITLE]',
			'label'   => __( 'Share on Facebook', 'snax' ),
		),
		'twitter'   => array(
			'pattern' => 'https://twitter.com/home?status=[TITLE]%20[SHORTLINK]',
			'label'   => __( 'Share on Twitter', 'snax' ),
		),
		'pinterest' => array(
			'pattern' => 'https://pinterest.com/pin/create/button/?url=[PERMALINK]&amp;description=[TITLE]&amp;media=[THUMBNAIL]',
			'label'   => __( 'Share on Pinterest', 'snax' ),
		),
	);

	return apply_filters( 'snax_share_links', $links );
}

/**
 * Prepare share url
 *
 * @param string  $url      Input url.
 * @param WP_Post $post     Post object.
 *
 * @return mixed
 */
function snax_build_post_share_url( $url, $post ) {
	$placeholders = array();

	$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) );

	$placeholders['TITLE']     = get_the_title( $post );
	$placeholders['PERMALINK'] = get_permalink( $post->ID );
	$placeholders['SHORTLINK'] = wp_get_shortlink( $post->ID );
	$placeholders['THUMBNAIL'] = is_array( $thumbnail ) && ! empty( $thumbnail ) ? $thumbnail[0] : '';

	$placeholders = apply_filters( 'snax_post_share_url_placeholders', $placeholders );

	foreach ( $placeholders as $name => $value ) {
		$url = str_replace( '[' . $name . ']', rawurlencode( $value ), $url );
	}

	return $url;
}

/**
 * Remove the item
 *
 * @param int $media_id         Media ID.
 * @param int $author_id        Author ID.
 *
 * @return bool|WP_Error
 */
function snax_delete_media( $media_id, $author_id ) {
	$media = get_post( $media_id );

	// Check type.
	if ( 'attachment' !== $media->post_type ) {
		return new WP_Error( 'post_type_test_failed', sprintf( 'Media %d is not an attachment post type.', $media_id ) );
	}

	// Check owner.
	if ( (int) $author_id !== (int) $media->post_author ) {
		return new WP_Error( 'ownership_test_failed', sprintf( 'Author %d is not an owner of the media %d.', $author_id, $media_id ) );
	}

	// Delete permanently, not move it to the trash.
	$force_delete_media = apply_filters( 'snax_force_delete_media', true, $media_id );

	// Delete media.
	$ret = wp_delete_attachment( $media_id, $force_delete_media );

	// On failure, return error.
	if ( false === $ret ) {
		return new WP_Error( 'wp_delete_attachment_failed', sprintf( 'Media %d could not be deleted.', $media_id ) );
	}

	return true;
}

/**
 * Update media meta
 *
 * @param int    $media_id       	Media ID.
 * @param string $format        	Snax format.
 *
 * @return bool|WP_Error
 */
function snax_update_media_meta( $media_id, $format ) {
	$media = get_post( $media_id );

	// Check type.
	if ( 'attachment' !== $media->post_type ) {
		return new WP_Error( 'post_type_test_failed', sprintf( 'Media %d is not an attachment post type.', $media_id ) );
	}

	$ret = add_post_meta( $media_id, '_snax_parent_format', $format );

	// On failure, return error.
	if ( false === $ret ) {
		return new WP_Error( 'snax_update_media_meta_failed', sprintf( 'Media %d could not be updated.', $media_id ) );
	}

	return true;
}

/**
 * Get the image size, that should be used when rendering a single item.
 *
 * @return mixed|void
 */
function snax_get_item_image_size() {
	return apply_filters( 'snax_get_item_image_size', 'large' );
}

/**
 * Return collection item default image size
 *
 * @return string
 */
function snax_get_collection_item_image_size() {
	return apply_filters( 'snax_get_collection_item_image_size', 'thumbnail' );
}

/**
 * Register fix for animated Gif
 */
function snax_before_media_hooks() {
	add_filter( 'wp_get_attachment_image_src', 'snax_fix_animated_gif_image', 10, 4 );
}

/**
 * Deregister fix for animated Gif
 */
function snax_after_media_hooks() {
	remove_filter( 'wp_get_attachment_image_src', 'snax_fix_animated_gif_image', 10, 4 );
}

/**
 * Return the 'full' image size, instead of a thumbnail of a GIF file
 *
 * WordPress can't scale animated GIFs properly without dropping frames.
 * Thus we hijack every image size and return the original one.
 *
 * @param array  $image Image.
 * @param int    $attachment_id Attachment ID.
 * @param string $size Image size.
 * @param bool   $icon Icon.
 *
 * @return array|false
 */
function snax_fix_animated_gif_image( $image, $attachment_id, $size, $icon ) {
	if ( 'full' !== $size ) {
		$is_intermediate = $image[3];

		if ( preg_match( '/\.gif$/', $image[0] ) > 0 && $is_intermediate ) {
			$image = wp_get_attachment_image_src( $attachment_id, 'full', $icon );
		}
	}

	return $image;
}

/**
 * Prevent Snax content in the excerpt
 *
 * @param string $post_excerpt          Post excerpt.
 *
 * @return string
 */
function snax_remove_post_content( $post_excerpt ) {
	remove_filter( 'the_content', 'snax_post_content' );

	return $post_excerpt;
}

/**
 * Restore Snax content after excerpt
 *
 * @param string $post_excerpt      Post excerpt.
 *
 * @return string
 */
function snax_restore_post_content( $post_excerpt ) {
	add_filter( 'the_content', 'snax_post_content' );

	return $post_excerpt;
}

/**
 * Redirect to url if exists in request object
 */
function snax_redirect_to_url() {
	$redirect_url = get_query_var( 'snax_redirect_to_url' );

	if ( ! empty( $redirect_url ) ) {
		wp_redirect( $redirect_url );
	}
}

/**
 * When new post is created (in draft mode), redirect to its edition page
 *
 * @param string $url				Redirect url.
 * @param int    $post_id			Post id.
 *
 * @return string
 */
function snax_redirect_to_draft_edition( $url, $post_id ) {
	if ( 'draft' === get_post_status( $post_id ) ) {
		$url = snax_get_post_edit_url( $post_id );

		$draft_saved_var = snax_get_url_var( 'draft_saved' );

		$url = add_query_arg( array(
			$draft_saved_var => 'success',
		), $url );
	}

	return $url;
}

function snax_get_post_preview_url( $post_id = 0 ) {
	// If not passed, try to get from url var.
	if ( ! $post_id ) {
		$post_var = snax_get_url_var( 'post' );

		$post_id = filter_input( INPUT_GET, $post_var, FILTER_SANITIZE_NUMBER_INT );
	}

	if ( ! $post_id ) {
		return '';
	}

	return get_preview_post_link( $post_id );
}

function snax_get_post_edit_url( $post_id = 0 ) {
	$post = get_post( $post_id );
	$format_var = snax_get_url_var( 'format' );
	$post_var 	= snax_get_url_var( 'post' );

	$url = add_query_arg( array(
		$format_var => snax_get_format( $post->ID ),
		$post_var	=> $post->ID,

	), snax_get_frontend_submission_page_url() );

	return $url;
}

function snax_is_post_format_editable( $post_id = 0 ) {
	$post = get_post( $post_id );

	// User can edit only Snax posts.
	$format = snax_get_format( $post->ID );

	if ( ! $format ) {
		return false;
	}

	// User can edit only posts that were not published yet.
	if ( 'publish' === $post->post_status ) {
		return false;
	}

	// Skip for non-editable formats.
	$non_editable_formats = array( 'image', 'embed', 'meme' );

	return ! in_array( $format, $non_editable_formats, true );
}

/**
 * Redirect after successful log out.
 */
function snax_logout_redirect() {
	$redirect_to_url              = filter_input( INPUT_GET, 'redirect_to', FILTER_SANITIZE_URL );
	$frontend_submission_page_url = snax_get_frontend_submission_page_url();

	// After logging out, we don't want to leave user on the Frontend Submission page (it opens popup).
	if ( false !== strpos( $redirect_to_url, $frontend_submission_page_url ) ) {
		wp_redirect( home_url() );
		exit();
	}
}

/**
 * Adds admin bar items for easy access to the Snax tools
 *
 * @param WP_Admin_Bar $wp_admin_bar Admin bar.
 */
function snax_admin_bar_menu( $wp_admin_bar ) {
	if ( ! current_user_can( 'administrator' ) ) {
		return;
	}

	$nodes = array();

	// Realod post meta data (counters).
	if ( is_single() && snax_is_format( 'list' ) ) {
		$nodes[] = array(
			'id'     => 'snax_reload_meta',
			'parent' => 'snax',
			'title'  => __( 'Reload post meta', 'snax' ),
			'href'   => '?snax_post=' . get_the_ID() . '&snax_action=reload_meta',
			'meta'   => false,
		);
	}

	/**
	// Add only in admin area.
	if ( is_admin() ) {
		// User capabilities.
		$nodes[] = array(
			'id'     => 'snax_reset_user_roles',
			'parent' => 'snax',
			'title'  => __( 'Reset user roles', 'snax' ),
			'href'   => '?snax_action=reset_user_roles',
			'meta'   => false,
		);
	}
	*/

	// Snax main node.
	$submission_page_id = snax_get_frontend_submission_page_id();

	$wp_admin_bar->add_node( array(
		'id'    => 'snax',
		'title' => __( 'Snax', 'snax' ),
		'href'  => $submission_page_id ? get_permalink( $submission_page_id ) : false,
	) );

	if ( ! empty( $nodes ) ) {
		foreach ( $nodes as $node ) {
			$wp_admin_bar->add_node( $node );
		}
	}
}

/**
 * Return the post id
 *
 * @return int
 */
function snax_get_post_id() {
	$id = get_the_ID();

	return apply_filters( 'snax_get_post_id', $id );
}

/**
 * Render feedback
 */
function snax_render_feedback() {
	snax_get_template_part( 'feedback', 'processing' );
}

/**
 * Render link to edit post.
 */
function snax_render_edit_post_link() {
	if ( ! is_single() ) {
		return;
	}

	if ( current_user_can( 'snax_edit_posts', get_the_ID() ) ) {
	?>
	<div class="snax-toolbar">
		<a href="<?php echo esc_url( snax_get_post_edit_url() ); ?>"><?php esc_html_e( 'Edit', 'snax' ); ?></a>
	</div>
	<?php
	}
}

/**
 * Render link to the legal page
 */
function snax_render_legal_page_link() {
	?>
	<?php if ( snax_get_legal_page_id() ) : ?>
		<a class="snax-legal-link" href="<?php echo esc_url( snax_get_legal_page_url() ); ?>"
		   target="_blank"><?php esc_html_e( 'Learn more', 'snax' ); ?></a>
	<?php endif; ?>
	<?php
}

/**
 * Check whether legal page is set so we can force user to accept its terms
 *
 * @return bool
 */
function snax_legal_agreement_required() {
	return apply_filters( 'snax_legal_agreement_required', (bool) snax_get_legal_page_id() );
}

/**
 * Append snax_media_upload_action param to upload params
 *
 * @param array $post_params        Upload params.
 *
 * @return array
 */
function snax_add_media_action_param( $post_params ) {
	if ( snax_is_frontend_submission_page() ) {
		$post_params['snax_media_upload_action'] = 'new_post_upload';
		$url_var = snax_get_url_var( 'format' );
		$format = (string) filter_input( INPUT_GET, $url_var, FILTER_SANITIZE_STRING );

		$post_params['snax_media_upload_format'] = $format;

	} else {
		$post_params['snax_media_upload_action'] = 'contribution_upload';
	}

	return $post_params;
}

/**
 * Check whether media was uploaded via snax media upload form
 *
 * @param string $action            Performed action type.
 *
 * @return bool
 */
function snax_is_media_upload_action( $action = null ) {
	$post_action = filter_input( INPUT_POST, 'snax_media_upload_action', FILTER_SANITIZE_STRING );

	// Compare if action set.
	if ( $action ) {
		$bool = $post_action === $action;

		// If action to compare not set, return true if param was sent.
	} else {
		$bool = (bool) $post_action;
	}

	return apply_filters( 'snax_media_upload_action', $bool );
}

/**
 * Return post format to which media is uploaded
 *
 * @return string           Empty if format not set.
 */
function snax_get_media_upload_format() {
	$format = filter_input( INPUT_POST, 'snax_media_upload_format', FILTER_SANITIZE_STRING );

	if ( ! snax_is_active_format( $format ) ) {
		$format = '';
	}

	return $format;
}

/**
 * If media is attached to more than one post or to demo post, we don't want to delete it during this post deletion
 *
 * @param bool $delete                  True if media should be deleted.
 * @param int  $media_id                Processing media id.
 *
 * @return bool
 */
function snax_prevent_deletion_attached_media( $delete, $media_id ) {
	$args = array(
		'post_type'     => array( 'post', snax_get_item_post_type() ),
		'meta_key'      => '_thumbnail_id',
		'meta_value'    => $media_id,
	);

	$query = new WP_Query( $args );

	$found_posts = intval( $query->found_posts );

	// Attached to more than one post?
	if ( $found_posts > 1 ) {
		$delete = false;
		// Attached just to one post, but demo post or demo post item?
	} else if ( 1 === $found_posts ) {
		$post = $query->posts[0];

		// Is demo post?
		if ( snax_is_demo_post( $post ) ) {
			$delete = false;
		}

		// Is demo post item?
		if ( snax_is_item( $post ) && snax_is_demo_post( snax_get_item_parent_id( $post ) ) ) {
			$delete = false;
		}
	}

	return $delete;
}

/**
 * Sanitize content for Snax allowed HTML tags for post content.
 *
 * @param string $content       Post content.
 *
 * @return string
 */
function snax_kses_post( $content, $extra_allowed_html = array() ) {
	// Replace <b> to <strong>.
	$content = str_replace(
		array( '<b>', '</b>' ),
		array( '<strong>', '</strong>' ),
		$content
	);

	$allowed_html = array(
		'a' => array(
			'href' => true,
		),
		'strong' 		=> array(),
		'em' 			=> array(),
		'p'				=> array(),
		'h2'			=> array(),
		'h3'			=> array(),
		'ol'			=> array(),
		'ul'			=> array(),
		'li'			=> array(),
		'blockquote'	=> array(),
		'figure'		=> array(
			'class' => true,
		),
		'figcaption'	=> array(
			'class' => true,
		),
	);

	if ( ! empty( $extra_allowed_html ) ) {
		$allowed_html = array_merge( $allowed_html, $extra_allowed_html );
	}

	$allowed_html = apply_filters( 'snax_allowed_html', $allowed_html );

	$content = wp_kses( $content, $allowed_html );

	// Add nofollow to links.
	$content = str_replace( '<a ', '<a rel="nofollow" ', $content );

	return $content;
}

/**
 * Add Snax items to the menu
 *
 * @param WP_Post $menu_item        The menu item.
 *
 * @return WP_Post
 */
function snax_setup_nav_menu_item( $menu_item ) {
	if ( is_admin() ) {
		return $menu_item;
	}

	$menu_classes = $menu_item->classes;

	if ( is_array( $menu_classes ) ) {
		$menu_classes = implode( ' ', $menu_item->classes );
	}

	// The only place we can identify that the $menu_item is ours is CSS class.
	if ( ! preg_match( '/snax-([^-]+)-nav/', $menu_classes, $matches ) ) {
		return $menu_item;
	}

	$menu_item_id = $matches[1];

	switch ( $menu_item_id ) {
		case 'logout' :
			if ( ! is_user_logged_in() ) {
				$menu_item->_invalid = true;
			}

			break;

		case 'login' :
			if ( is_user_logged_in() ) {
				$menu_item->_invalid = true;
			} else {
				if ( ! is_array( $menu_item->classes ) ) {
					$menu_item->classes = array();
				}

				$menu_item->classes[] = 'snax-login-required';
			}

			break;

		case 'register' :
			if ( is_user_logged_in() ) {
				$menu_item->_invalid = true;
			}

			break;
	}

	// Check if current page.
	$http_host      = filter_input( INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_URL );
	$request_uri    = filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL );
	$current_url    = ( is_ssl() ? 'https://' : 'http://' ) . $http_host . $request_uri;

	if ( false !== strpos( $current_url, $menu_item->url ) ) {
		if ( ! is_array( $menu_item->classes ) ) {
			$menu_item->classes = array();
		}

		$menu_item->classes[] = 'current_page_item';
		$menu_item->classes[] = 'current-menu-item';
	}

	return $menu_item;
}

/**
 * Clean up orphan uploads
 */
function snax_do_clean_up_junk_uploads() {
	snax_remove_orphan_items();
	snax_remove_orphan_attachments();
}

/**
 * Find and remove permanently orphan items
 */
function snax_remove_orphan_items() {
	$query_args = array(
		// Orphan.
		'post_parent'       => 0,
		'post_type'         => snax_get_item_post_type(),
		// Items created over a day ago.
		'date_query'        => array(
			'column'    => 'post_date',
			'before'    => '1 day ago',
		),
		'posts_per_page'    => -1,
	);

	$query_args = apply_filters( 'snax_orphan_items_query_args', $query_args );

	$orphan_items = get_posts( $query_args );

	foreach ( $orphan_items as $orphan_item ) {
		$media_id     = get_post_thumbnail_id( $orphan_item->ID );

		// Check if media was not assigned (somehow) to any other post.
		$delete_media = apply_filters( 'snax_delete_media', true, $media_id );

		if ( $delete_media ) {
			wp_delete_attachment( $media_id, true );
		}

		wp_delete_post( $orphan_item->ID, true );
	}
}

/**
 * Find and remove permanently orphan attachments
 */
function snax_remove_orphan_attachments() {
	$query_args = array(
		'post_type'             => 'attachment',
		'post_status'           => 'inherit',
		// Orphan.
		'post_parent'           => 0,
		'meta_key'              => '_snax_media_belongs_to',
		'meta_compare'          => 'EXISTS',
		// Attachment created over a day ago.
		'date_query'        => array(
			'column'    => 'post_date',
			'before'     => '1 day ago',
		),
		'posts_per_page'    => -1,
	);

	$query_args = apply_filters( 'snax_orphan_attachments_query_args', $query_args );

	$orphan_attachments = get_posts( $query_args );

	foreach ( $orphan_attachments as $orphan_attachment ) {
		wp_delete_attachment( $orphan_attachment->ID, true );
	}
}

function snax_media_upload_form() {
	ob_start();
	media_upload_form();
	$form = ob_get_clean();

	$replace = array();

	$replace['in'] = array(
		'drop_files' 		=> __( 'Drop files here' ),
		'select_files' 		=> __( 'Select Files' ),
		'max_upload_size'	=> __( 'Maximum upload file size: ' ),
	);

	// Register WP phrases in plugin domain.
	$replace['out'] = array(
		'drop_files' 		=> __( 'Drop files here', 'snax' ),
		'select_files' 		=> __( 'Select Files', 'snax' ),
		'max_upload_size'	=> __( 'Maximum upload file size: ', 'snax' ),
	);

	$replace = apply_filters( 'snax_media_upload_replace_form', $replace, snax()->get_current_format() );

	$form = str_replace( $replace['in'], $replace['out'], $form );

	echo filter_var( $form );
}

function snax_add_caption_source( $content ) {
	$content = str_replace( 'class="snax-figure-source"', 'data-snax-placeholder="'. esc_attr__( 'Source', 'snax' ) .'" class="snax-figure-source"', $content );

	return $content;
}


/**
 * Add body classes.
 *
 * @param array $classes Body classes.
 * @return array
 */
function snax_body_class( $classes ) {
	$classes[] = 'snax-hoverable';

	return $classes;
}

/**
 * Return list of all tags
 *
 * @param int   $limit		Optional. If tags is more that $limit, return empty set.
 * @param array $args		Optional. Tags query args.
 *
 * @return array
 */
function snax_get_tags_array( $limit = -1, $args = array() ) {
	$arr = array();

	$defaults = array(
		'hide_empty' => false,
	);

	$args = wp_parse_args( $args, $defaults );

	$tags = get_tags( $args );

	if ( -1 !== $limit && (int) count( $tags ) > $limit ) {
		return $arr;
	}

	foreach ($tags as $tag) {
		$arr[] = $tag->name;
	}

	return $arr;
}

/**
 * Do a format specific action (backward compatibility)
 *
 * @param int    $post_id           Post id.
 * @param string $format            Post format.
 */
function snax_do_format_specific_action( $post_id, $format ) {
	do_action( 'snax_post_format_' . $format . '_created', $post_id );
}

/**
 * Send mail to admin when new item was added
 *
 * @param int    $post_id           Post id.
 * @param string $format            Post format.
 * @param string $origin            Item origin (post | contribution).
 */
function snax_notify_admin_about_new_item( $post_id, $format, $origin ) {
	if ( ! snax_mail_notifications() ) {
		return;
	}

	// Item is a part of a new post, don't notify about that.
	if ( 'post' === $origin ) {
		return;
	}

	$post            = get_post( $post_id );
	$admin_email     = get_option( 'admin_email' );
	$permalink       = get_permalink( $post );
	$link            = '<a href="' . $permalink . '">' . $permalink . '</a>';
	$review_required = snax_get_item_pending_status() === get_post_status( $post );
	$subject         = _x( 'New item was submitted.', 'Mail notification', 'snax' );

	if ( $review_required ) {
		$message = sprintf( _x( 'New item (%1$s) awaits approval: %2$s', 'Mail notification', 'snax' ), $format, $link );
	} else {
		$message = sprintf( _x( 'New item (%1$s) was published: %2$s', 'Mail notification', 'snax' ), $format, $link );
	}

	wp_mail( $admin_email, $subject, $message );
}

/**
 * Send mail to admin when new post was added
 *
 * @param int    $post_id           Post id.
 * @param string $format            Post format.
 */
function snax_notify_admin_about_new_post( $post_id, $format ) {
	if ( ! snax_mail_notifications() ) {
		return;
	}

	$post            = get_post( $post_id );
	$admin_email     = get_option( 'admin_email' );
	$permalink       = get_permalink( $post );
	$link            = '<a href="' . $permalink . '">' . $permalink . '</a>';
	$review_required = snax_get_post_pending_status() === get_post_status( $post );
	$subject         = _x( 'New post was submitted.', 'Mail notification', 'snax' );

	if ( $review_required ) {
		$message = sprintf( _x( 'New post (%1$s) awaits approval: %2$s', 'Mail notification', 'snax' ), $format, $link );
	} else {
		$message = sprintf( _x( 'New post (%1$s) was published: %2$s', 'Mail notification', 'snax' ), $format, $link );
	}

	wp_mail( $admin_email, $subject, $message );
}

/**
 * Load FB SDK script in footer
 */
function snax_enqueue_fb_sdk() {
	add_action( 'wp_footer', 'snax_print_fb_sdk', 100 );
}

/**
 * Print FB SDK
 */
function snax_print_fb_sdk() {
	$facebook_sdk_src = apply_filters( 'snax_facebook_sdk_src', '//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5' );
	?>
	<div id="fb-root"></div>
	<script type="text/javascript">
		(function (d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s);
			js.id = id;
			js.src = "<?php echo esc_url_raw( $facebook_sdk_src ); ?>";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<?php
}

function snax_remove_post_tags( $post_id ) {
	$post_tags = wp_get_object_terms( $post_id, 'post_tag' );

	$term_ids = array();

	foreach ( $post_tags as $post_tag ) {
		$term_ids[] = $post_tag->term_id;
	}

	wp_remove_object_terms( $post_id, $term_ids, 'post_tag' );
}

/**
 * Save image from url into the Media Library.
 *
 * @param string $image_url			Image url.
 * @param int    $author_id			Author id.
 *
 * @return int|WP_Error
 */
function snax_save_image_from_url( $image_url, $author_id = 0 ) {
	if ( ! $author_id ) {
		$author_id = get_current_user_id();
	}

	// Check mime type.
	$filetype = wp_check_filetype( $image_url );

	if ( ! in_array( $filetype['ext'], snax_get_image_allowed_types(), true ) ) {
		return new WP_Error( 'snax_save_image_from_url_failed', __( 'Upload failed. Image type is not allowed.', 'snax' ) );
	}

	// Check size (download only file headers).
	$headers = get_headers( $image_url, true );

	if ( false !== $headers && isset( $headers['Content-Length'] ) ) {
		$max_allowed_size_in_bytes = snax_get_max_upload_size();
		$size_in_bytes = $headers['Content-Length'];

		if ( $size_in_bytes > $max_allowed_size_in_bytes ) {
			return new WP_Error( 'snax_save_image_from_url_failed', __( 'Upload failed. Image file is too big.', 'snax' ) );
		}
	} else {
		return new WP_Error( 'snax_save_image_from_url_failed', __( 'Upload failed. Image file is too big or its size couldn\'t be verified.', 'snax' ) );
	}

	// Download file content.
	$response = wp_remote_get( esc_url_raw( $image_url ), array( 'timeout' => 10 ) );

	if ( is_wp_error( $response ) ) {
		return new WP_Error( 'snax_save_image_from_url_failed', __( 'Upload failed. Image couldn\'t be downloaded from the url.', 'snax' ) );
	}

	$body 				= wp_remote_retrieve_body( $response );
	$upload_dir 		= wp_upload_dir();
	$upload_dest_dir 	= trailingslashit( $upload_dir['path'] );
	$upload_dest_url 	= trailingslashit( $upload_dir['url'] );
	$filename 			= basename( $image_url );
	$path				= $upload_dest_dir . $filename;

	// Save in uploads dir.
	@file_put_contents( $path, $body );

	$attachment = array(
		'guid'              => $upload_dest_url . $filename,
		'post_title' 		=> '',
		'post_content' 		=> '',
		'post_status' 		=> 'inherit',
		'post_mime_type'	=> $filetype['type'],
		'post_author'		=> $author_id,
	);

	$post_id = wp_insert_attachment( $attachment, $path );

	// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );

	$metadata = wp_generate_attachment_metadata( $post_id, $path );
	wp_update_attachment_metadata( $post_id, $metadata );

	return $post_id;
}
