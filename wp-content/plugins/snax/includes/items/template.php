<?php
/**
 * Snax Item Template Tags
 *
 * @package snax
 * @subpackage TemplateTags
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Output item messages (added, updated etc)
 */
function snax_item_render_notes() {
	snax_get_template_part( 'items/note' );
}

/**
 * Add item messages (added, updated etc) at the beginning of post content
 *
 * @param string $content		Post content.
 *
 * @return string
 */
function snax_item_prepend_notes( $content ) {
	ob_start();
	snax_item_render_notes();
	$note = ob_get_clean();

	$content = $note . $content;

	return $content;
}

/**
 * Output admin links for item
 *
 * @param array $args See {@link snax_get_item_admin_links()}.
 */
function snax_render_item_action_links( $args = array() ) {
	$links = snax_item_action_links( $args );

	echo filter_var( $links );
}

/**
 * Return admin links for item
 *
 * @param array $args This function supports these arguments (
 *  - before: Before the links
 *  - after: After the links
 *  - sep: Links separator
 *  - links: item admin links array
 * ).
 *
 * @return string
 */
function snax_item_action_links( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'before' => '<div class="snax-actions"><a href="#" class="snax-actions-toggle">'. esc_html__( 'More', 'snax' ) .'</a><ul class="snax-action-links"><li>',
		'after'  => '</li></ul></div>',
		'sep'    => '</li><li>',
		'links'  => array(),
	) );

	$args = apply_filters( 'snax_item_action_links_args', $args );

	if ( empty( $args['links'] ) ) {
		$args['links'] = apply_filters( 'snax_item_admin_links', array(
			'edit'      => snax_item_edit_link(),
			'delete'    => snax_item_delete_link(),
			'report'    => snax_item_report_link(),
			'featured'  => snax_item_featured_link(),
		) );
	}

	// Prepare output.
	$out   = '';
	$links = implode( $args['sep'], array_filter( $args['links'] ) );

	if ( strlen( $links ) ) {
		$out = $args['before'] . $links . $args['after'];
	}

	return apply_filters( 'snax_get_item_admin_links', $out, $args );
}

/**
 * Return item edit link
 *
 * @param array $args       Extra arguments.
 *
 * @return string
 */
function snax_item_edit_link( $args = array() ) {
	if ( ! current_user_can( 'snax_edit_others_items' ) ) {
		return '';
	}

	$defaults = array(
		'classes' => array(
			'snax-action-link',
			'snax-edit-item',
		),
	);

	$args = wp_parse_args( $args, $defaults );

	$link = sprintf(
		'<a href="%s" class="' . implode( ' ', array_map( 'sanitize_html_class', $args['classes'] ) ) . '" title="%s">%s</a>',
		get_edit_post_link( get_the_ID() ),
		__( 'Edit', 'snax' ),
		__( 'Edit', 'snax' )
	);

	return $link;
}

/**
 * Return item delete link
 *
 * @param array $args       Extra arguments.
 *
 * @return string
 */
function snax_item_delete_link( $args = array() ) {
	if ( ! current_user_can( 'snax_delete_items', get_the_ID() ) ) {
		return '';
	}

	$defaults = array(
		'classes' => array(
			'snax-action-link',
			'snax-delete-item',
		),
	);

	$args = wp_parse_args( $args, $defaults );

	$link = sprintf(
		'<a href="#" class="' . implode( ' ', array_map( 'sanitize_html_class', $args['classes'] ) ) . '" title="%s" data-snax-item-id="%d" data-snax-nonce="%s">%s</a>',
		__( 'Delete', 'snax' ),
		get_the_ID(),
		wp_create_nonce( 'snax-delete-item-' . get_the_ID() ),
		__( 'Delete', 'snax' )
	);

	return $link;
}

/**
 * Render item delete link
 *
 * @param array $args           Extra arguments.
 */
function snax_render_item_delete_link( $args = array() ) {
	$link = snax_item_delete_link( $args );

	echo wp_kses( $link, array(
		'a' => array(
			'href'              => array(),
			'class'             => array(),
			'title'             => array(),
			'data-snax-item-id' => array(),
			'data-snax-nonce'   => array(),
		),
	) );
}

/**
 * Return item link for reporting any kind of abuses
 *
 * @return string
 */
function snax_item_report_link() {
	$item_id = get_the_ID();

	// Mailto fallback.
	$mail_title = __( 'Hey, I would like to report an abuse', 'snax' );
	$mail_body  = __( 'Reported link: ', 'snax' ) . get_permalink( $item_id );

	$mailto_fallback = sprintf( 'mailto:%s?subject=%s&body=%s', get_option( 'admin_email' ), $mail_title, $mail_body );

	$link = sprintf(
		'<a href="%s" class="snax-action-link snax-report-li" target="_blank">%s</a>',
		esc_url( snax_get_report_page_url( $mailto_fallback ) ),
		esc_html__( 'Report', 'snax' )
	);

	return $link;
}

/**
 * Return link to set item as featured
 *
 * @param array $args       Link config.
 *
 * @return string
 */
function snax_item_featured_link( $args = array() ) {
	// User must be logged in.
	if ( ! is_user_logged_in() ) {
		return '';
	}

	$item = get_post();
	$current_user_id = get_current_user_id();

	$is_admin	= user_can( $current_user_id, 'administrator' );
	$is_author  = (int) $current_user_id === (int) $item->post_author;

	// Only owner and administrator can do that.
	if ( ! $is_admin && ! $is_author ) {
		return '';
	}

	$item_thumbnail_id = (int) get_post_thumbnail_id( $item->ID );

	$post_id = snax_get_item_parent_id( $item );
	$post_thumbnail_id = (int) get_post_thumbnail_id( $post_id );

	// Skip if item is already set as featured.
	if ( $item_thumbnail_id === $post_thumbnail_id ) {
		return '';
	}

	$defaults = array(
		'classes' => array(
			'snax-action-link',
			'snax-set-item-as-featured',
		),
	);

	$args = wp_parse_args( $args, $defaults );

	$link = sprintf(
		'<a href="#" class="' . implode( ' ', array_map( 'sanitize_html_class', $args['classes'] ) ) . '" title="%s" data-snax-item-id="%d" data-snax-nonce="%s">%s</a>',
		__( 'Set as Featured Image', 'snax' ),
		get_the_ID(),
		wp_create_nonce( 'snax-set-item-as-featured-' . get_the_ID() ),
		__( 'Set as Featured Image', 'snax' )
	);

	return $link;
}

/**
 * Render item media
 *
 * @param array $args   Arguments.
 */
function snax_item_media( $args = array() ) {
	echo snax_get_item_media( $args );
}

/**
 * Capture item media
 *
 * @param array $args Arguments.
 *
 * @return string       Escaped HTML
 */
function snax_get_item_media( $args ) {
	$args = wp_parse_args( $args, array(
		'size'			=> 'post-thumbnail',
		'class'			=> '',
		'apply_link'    => true,
		'allow_video'   => false,
	) );

	$args = apply_filters( 'snax_item_media_args', $args );

	$final_class = array();
	$final_class = array_merge( $final_class, explode( ' ', $args['class'] ) );

	do_action( 'snax_before_capture_item_media', $args );

	$html = '';

	if ( $args['apply_link'] ) {
		$html .= '<a class="' . implode( ' ', array_map( 'sanitize_html_class', $final_class ) ) . '" href="' . esc_url( get_permalink() ) . '">';
	}

	$html .= get_the_post_thumbnail( null, $args['size'] );

	if ( $args['apply_link'] ) {
		$html .= '</a>';
	}

	do_action( 'snax_after_capture_item_media', $args );

	return $html;
}

/**
 * Render item description.
 *
 * @param int $item_id              Snax item id.
 *
 * @return bool
 */
function snax_has_item_description( $item_id = 0 ) {
	$item = get_post( $item_id );

	return ! empty( $item->post_content );
}

/**
 * Return item description
 *
 * @return string
 */
function snax_get_item_description() {
	if ( is_singular( snax_get_item_post_type() ) ) {
		return '%%SNAX_ITEM_DESCRIPTION%%';
	} else {
		$content = get_the_content();

		$content = snax_strip_embed_url_from_embed_content( $content );

		return $content;
	}
}

/**
 * Render item description
 */
function snax_item_description() {
	echo wpautop( wp_kses_post( snax_get_item_description() ) );
}

/**
 * Render item share links.
 */
function snax_item_share_links() {
	global $post;

	$links = apply_filters( 'snax_item_share_links', snax_get_share_links() );

	foreach ( $links as $link_id => $link ) {
		// We want to share post url, not item url.
		$link['pattern'] = str_replace( '[PERMALINK]', rawurlencode( get_permalink( $post->post_parent ) ), $link['pattern'] );

		printf(
			'<a class="snax-share %1s" href="%2s" title="%3s" target="_blank" rel="nofollow">%4s</a>',
			sanitize_html_class( 'snax-share-' . $link_id ),
			esc_url( snax_build_post_share_url( $link['pattern'], $post ) ),
			esc_attr( $link['label'] ),
			esc_html( $link['label'] )
		);
	}
}

/**
 * Capture author information for item
 *
 * @param array $args       Extra arguments.
 */
function snax_render_item_author( $args = array() ) {
	if ( snax_show_item_author() ) {
		echo wp_kses_post( snax_capture_item_author( $args ) );
	}
}

/**
 * Capture author information for item
 *
 * @param array $args           Extra arguments.
 *
 * @return string
 */
function snax_capture_item_author( $args = array() ) {
	$out = '';

	$args = wp_parse_args( $args, array(
		'avatar'      => true,
		'avatar_size' => 40,
	) );

	$out .= '<span class="snax-item-author" itemscope="" itemprop="author" itemtype="http://schema.org/Person">';
	$out .= '<span class="snax-item-author-label">' . __( 'by', 'snax' ) . ' </span>';
	$out .= sprintf(
		'<a href="%s" title="%s" rel="author">',
		snax_get_item_author_url(),
		sprintf( __( 'Posts by %s', 'snax' ), get_the_author() )
	);

	if ( $args['avatar'] ) {
		$out .= get_avatar( get_the_author_meta( 'email' ), $args['avatar_size'] );
	}

	$out .= '<strong itemprop="name">' . get_the_author() . '</strong>';
	$out .= '</a>';
	$out .= '</span>';

	return $out;
}

/**
 * Render date information for the current item.
 */
function snax_render_item_date() {
	if ( snax_show_item_date() ) {

		echo wp_kses( snax_capture_item_date(), array(
			'time' => array(
				'class'     => array(),
				'datetime'  => array(),
				'itemprop'  => array(),
			),
		) );
	}
}

/**
 * Capture date information for the current post.
 *
 * @return string
 */
function snax_capture_item_date() {
	$out = '';
	$out .= sprintf( '<time class="snax-item-date" datetime="%s">', esc_attr( get_the_time( 'Y-m-d' ) . 'T' . get_the_time( 'H:i:s' ) ) );
	$out .= get_the_time( get_option( 'date_format' ) ) . ', ' . get_the_time( get_option( 'time_format' ) );
	$out .= '</time>';

	return $out;
}

/**
 * Render embed code
 *
 * @param int|WP_Post $item Item.
 */
function snax_render_item_embed_code( $item = null ) {
	$item = get_post( $item );

	$embed_url = snax_get_item_embed_code( $item );

	global $wp_embed;
	$out = $wp_embed->run_shortcode( '[embed]' . $embed_url . '[/embed]' );

	echo ! empty( $out ) ? filter_var( $out ) : '';
}

/**
 * Render share buttons for item
 */
function snax_render_item_share() {
	if ( snax_show_item_share() ) {
		$thumb_url = '';

		if ( snax_is_item( null, 'image' ) ) {
			$thumb_url = get_the_post_thumbnail_url();
		}
		?>
		<div class="snax-item-share"
		     data-snax-share-title="<?php echo esc_attr( get_the_title() ); ?>"
		     data-snax-share-url="<?php echo esc_url( get_permalink( snax_get_item_parent_id() ) ); ?>"
		     data-snax-share-thumb="<?php echo esc_url( $thumb_url ); ?>">
			<a class="snax-item-share-toggle" href="#"><?php esc_html_e( 'Share', 'snax' ); ?></a>
			<div class="snax-item-share-content">
				<?php snax_item_share_links(); ?>
			</div>
		</div>
		<?php
	}
}


/**
 * Whether there are more posts available in the loop
 *
 * @return bool
 */
function snax_items() {

	$have_posts = snax()->items_query->have_posts();

	// Reset the post data when finished.
	if ( empty( $have_posts ) ) {
		wp_reset_postdata();
	}

	return $have_posts;
}

/**
 * Loads up the current post in the loop
 */
function snax_the_item() {
	snax()->items_query->the_post();
}

/**
 * Output the pagination count
 */
function snax_items_pagination_count() {
	echo esc_html( snax_get_items_pagination_count() );
}

/**
 * Return the pagination count
 *
 * @return string
 */
function snax_get_items_pagination_count() {
	$query = snax()->items_query;

	if ( empty( $query ) ) {
		return false;
	}

	// Set pagination values.
	$start_num = intval( ( $query->paged - 1 ) * $query->posts_per_page ) + 1;
	$from_num  = snax_number_format( $start_num );
	$to_num    = snax_number_format( ( $start_num + ( $query->posts_per_page - 1 ) > $query->found_posts ) ? $query->found_posts : $start_num + ( $query->posts_per_page - 1 ) );
	$total_int = (int) ! empty( $query->found_posts ) ? $query->found_posts : $query->post_count;
	$total     = snax_number_format( $total_int );

	// Several topics in a forum with a single page.
	if ( empty( $to_num ) ) {
		$retstr = sprintf( _n( 'Viewing %1$s item', 'Viewing %1$s items', $total_int, 'snax' ), $total );

		// Several topics in a forum with several pages.
	} else {
		$retstr = sprintf( _n( 'Viewing item %2$s (of %4$s total)', 'Viewing %1$s items - %2$s through %3$s (of %4$s total)', $total_int, 'snax' ), $query->post_count, $from_num, $to_num, $total );
	}

	// Filter and return.
	return apply_filters( 'snax_get_items_pagination_count', esc_html( $retstr ) );
}

/**
 * Output pagination links
 */
function snax_items_pagination_links() {
	echo wp_kses_post( snax_get_items_pagination_links() );
}

/**
 * Return pagination links
 *
 * @return string
 */
function snax_get_items_pagination_links() {
	$query = snax()->items_query;

	if ( empty( $query ) ) {
		return false;
	}

	return apply_filters( 'snax_get_items_pagination_links', $query->pagination_links );
}

/**
 * Get all registered li forms
 *
 * @return array
 */
function snax_get_registered_item_forms() {

	$forms = array(
		'image' => array(
			'labels' => array(
				'name'          => __( 'Image', 'snax' ),
				'add_new_item'  => __( 'Upload image', 'snax' ),
				'add_new_items' => __( 'Upload images', 'snax' ),
			),
		),

		// @premium
		'embed' => array(
			'labels' => array(
				'name'          => __( 'Embed', 'snax' ),
				'add_new_item'  => __( 'Embed content', 'snax' ),
				'add_new_items' => __( 'Embed content', 'snax' ),
			),
		),
	);

	return apply_filters( 'snax_get_registered_item_forms', $forms );
}

/**
 * Get active na item forms
 *
 * @param int|WP_Post $post_id Post.
 *
 * @return array
 */
function snax_get_new_item_forms( $post_id = 0 ) {
	$p = get_post( $post_id );

	// Single post config.
	$config        = snax_get_post_config( $p );
	$override_form = 'standard' === $config['override_forms'];

	if ( $override_form ) {
		// Use single post active forms.
		$forms_ids = $config['forms'];
	} else {
		// Use globally active forms.
		$forms_ids = snax_get_active_item_forms_ids( array(), $p );
	}

	// All possible forms.
	$forms = snax_get_registered_item_forms();

	foreach ( $forms as $form_id => $form ) {
		$is_form_enabled = in_array( $form_id, $forms_ids, true );

		if ( ! $is_form_enabled ) {
			unset( $forms[ $form_id ] );
		}
	}

	return apply_filters( 'snax_get_new_item_forms', $forms, $p );
}

/**
 * Get default (selected) new item form.
 *
 * @return string
 */
function snax_get_selected_new_item_form() {
	$forms = snax_get_new_item_forms();

	$selected = array_slice( $forms, 0, 1, true );
	$selected = key( $selected );

	return apply_filters( 'snax_get_selected_new_item_form', $selected );
}

/**
 * Render tabs navigation for the new item form.
 *
 * @param array $args           Tabs config.
 */
function snax_render_snax_new_item_tabs( $args = array() ) {
	$defaults = array(
		'add_new' => 'add_new_item',
	);

	$args = wp_parse_args( $args, $defaults );

	$forms = snax_get_new_item_forms();

	?>
	<?php if ( 1 < count( $forms ) ) : ?>
		<p class="snax-tabs-nav">
			<?php foreach ( $forms as $form_id => $form_args ) : ?>
				<?php
				$class = array(
					'snax-tabs-nav-item',
					'snax-tabs-nav-item-' . $form_id,
				);

				if ( snax_get_selected_new_item_form() === $form_id ) {
					$class[] = 'snax-tabs-nav-item-current';
				}
				?>
				<a class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $class ) ); ?>"><?php echo esc_html( $form_args['labels'][ $args['add_new'] ] ); ?></a>
			<?php endforeach; ?>
		</p>
	<?php endif; ?>
	<?php
}

/**
 * Render comments box
 *
 * @param int|WP_Post $post                 Optional. Post ID or WP_Post object. Default is global `$post`.
 */
function snax_render_comments_box( $post = null ) {
	// Disabled.
	return;

	$post = get_post( $post );

	if ( ! snax_show_item_comments_box( $post ) ) {
		return;
	}
	$final_class = array(
		'snax-item-comments',
	);

	?>
	<div class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $final_class ) ); ?>">
		<?php do_action( 'snax_before_item_comments' ); ?>

		<?php add_filter( 'comments_template', 'snax_filter_item_comments_template' ); ?>

		<?php comments_template(); ?>

		<?php remove_filter( 'comments_template', 'snax_filter_item_comments_template' ); ?>

		<a href="<?php echo esc_url( get_permalink( $post ) . '#comments' ); ?>"><?php esc_html_e( 'See all', 'snax' ); ?></a>

		<?php do_action( 'snax_after_item_comments' ); ?>
	</div>
	<?php
}

function snax_filter_item_comments_template( $theme_template ) {
	$parent_dir_path = trailingslashit( get_template_directory() );
	$child_dir_path  = trailingslashit( get_stylesheet_directory() );

	$files = array(
		$child_dir_path . 'snax/items/comments-inside-collection.php',
		$parent_dir_path . 'snax/items/comments-inside-collection.php',
	);

	$located = '';

	foreach ( $files as $file ) {
		if ( file_exists( $file ) ) {
			$located = $file;
			break;
		}
	}

	if ( strlen( $located ) ) {
		$theme_template = $located;
	}

	return $theme_template;
}


