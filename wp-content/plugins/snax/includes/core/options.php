<?php
/**
 * Snax Options
 *
 * @package snax
 * @subpackage Options
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Get the default options
 *
 * @return array Filtered option names and values
 */
function snax_get_default_options() {

	return apply_filters( 'snax_get_default_options', array(

		/* General */

		'snax_active_formats'           => array( 'list', 'ranked_list', 'classic_list', 'image', 'gallery', 'embed', 'text', 'meme', 'trivia_quiz', 'personality_quiz' ),
		'snax_items_per_page'           => 20,
		'snax_show_item_count_in_title' => 'on',
		'snax_max_upload_size'          => 2 * 1024 * 1024, // 2MB.

		/* Lists */

		'snax_active_item_forms'        => array( 'image', 'embed' ),
		'snax_show_open_list_in_title'  => 'on',
		'snax_user_submission_limit'    => 1,  // How many items user can submit (-1 for no limit).

		/* Votes */

		'snax_voting_is_enabled'		=> 'on',
		'snax_guest_voting_is_enabled'	=> 'on',
		'snax_voting_post_types'		=> array( 'post' ),
		'snax_fake_vote_count_base'		=> '',

		/* Demo */

		'snax_demo_mode'                => 'off',

	) );
}

/**
 * Init plugin for immediate use
 */
function snax_default_setup() {
	snax_load_default_options();
	snax_create_and_assign_frontend_page();
}

/** General ********************************************************** */

/**
 * Return active formats.
 *
 * @param array   $default Optional. Default value.
 * @param WP_Post $post Optional. Default value.
 *
 * @return array
 */
function snax_get_active_formats_ids( $default = array(), $post = null ) {
	$post = get_post( $post );

	$formats_ids = (array) get_option( 'snax_active_formats', $default );

	return apply_filters( 'snax_active_formats', $formats_ids, $post );
}

/**
 * Return ordered list of formats.
 *
 * @return array
 */
function snax_get_formats_order() {
	$order_str = get_option( 'snax_formats_order', '' );
	$order_arr = explode( ',', $order_str );

	$order_arr = array_filter( $order_arr );

	return apply_filters( 'snax_formats_order', $order_arr );
}

/**
 * Return number of items to display on a single page, global setting
 *
 * @param int $default Optional. Default value.
 *
 * @return mixed|void
 */
function snax_get_global_items_per_page( $default = 20 ) {
	return apply_filters( 'snax_items_per_page', (int) get_option( 'snax_items_per_page', $default ) );
}

/**
 * Check whether to show items count in a post title.
 *
 * @param string $default Optional. Default value.
 *
 * @return bool
 */
function snax_show_item_count_in_title( $default = 'on' ) {
	$show = apply_filters( 'snax_show_item_count_in_title', get_option( 'snax_show_item_count_in_title', $default ) );

	return 'on' === $show;
}

/**
 * Check whether to disable traditinal WP login form.
 *
 * @param string $default Optional. Default value.
 *
 * @return bool
 */
function snax_disable_wp_login( $default = '' ) {
	if ( apply_filters( 'snax_disable_wp_login_option_active', false ) ) {
		$show = apply_filters( 'snax_disable_wp_login', get_option( 'snax_disable_wp_login', $default ) );
	} else {
		$show = '';
	}

	return 'on' === $show;
}

/**
 * Check whether to disable admin bar for logged in Snax Authors.
 *
 * @param string $default Optional. Default value.
 *
 * @return bool
 */
function snax_disable_admin_bar( $default = 'on' ) {
	$show = apply_filters( 'snax_disable_admin_bar', get_option( 'snax_disable_admin_bar', $default ) );

	return 'on' === $show;
}

/**
 * Check whether to disable dashboard access for logged in Snax Authors.
 *
 * @param string $default Optional. Default value.
 *
 * @return bool
 */
function snax_disable_dashboard_access( $default = '' ) {
	$disable = apply_filters( 'snax_disable_dashboard_access', get_option( 'snax_disable_dashboard_access', $default ) );

	return 'on' === $disable;
}

/**
 * Check whether the category field is required
 *
 * @return bool
 */
function snax_is_category_required() {
	return 'standard' === apply_filters( 'snax_category_required', get_option( 'snax_category_required', 'none' ) );
}

/**
 * Check whether user can select multiple post categories.
 *
 * @param string $default Optional. Default value.
 *
 * @return bool
 */
function snax_multiple_categories_selection( $default = '' ) {
	$show = apply_filters( 'snax_multiple_categories_selection', get_option( 'snax_category_multi', $default ) );

	return 'on' === $show;
}

/**
 * Return list of allowed categories to select during front end post creation
 *
 * @return array
 */
function snax_get_category_whitelist() {
	return apply_filters( 'snax_category_whitelist', get_option( 'snax_category_whitelist', array( '' => '' ) ) );
}

/**
 * Return list of categories to auto assign during front end post creation
 *
 * @return array
 */
function snax_get_category_auto_assign() {
	return (array) apply_filters( 'snax_category_auto_assign', get_option( 'snax_category_auto_assign', array( '' => '' ) ) );
}

/**
 * Check whether to verify IP for user related posts/submissions
 *
 * @return array
 */
function snax_user_ip_verification() {
	return apply_filters( 'snax_user_ip_verification', false );
}

/**
 * Return Facebook App ID
 *
 * @return string
 */
function snax_get_facebook_app_id() {
	return apply_filters( 'snax_facebook_app_id', get_option( 'snax_facebook_app_id', '' ) );
}

/**
 * Check whether to allow users direct publishing
 *
 * @return bool
 */
function snax_skip_verification() {
	return 'standard' === apply_filters( 'snax_skip_verification', get_option( 'snax_skip_verification', 'none' ) );
}

/**
 * Check whether to send mail to admi when new post/item was added
 *
 * @return bool
 */
function snax_mail_notifications() {
	return 'standard' === apply_filters( 'snax_mail_notifications', get_option( 'snax_mail_notifications', 'standard' ) );
}

/** Lists ************************************************************ */

/**
 * Return the list of active item forms.
 *
 * @param array   $default Optional. Default value.
 * @param WP_Post $post Optional. Default value.
 *
 * @return array
 */
function snax_get_active_item_forms_ids( $default = array(), $post = null ) {
	$post = get_post( $post );

	$forms_ids = (array) get_option( 'snax_active_item_forms', $default );

	return apply_filters( 'snax_active_item_forms', $forms_ids, $post );
}

/**
 * Return number of posts to display on a single page
 *
 * @param int $default              Optional. Default value.
 *
 * @return int
 */
function snax_get_posts_per_page( $default = 10 ) {
	return apply_filters( 'snax_posts_per_page', (int) get_option( 'snax_posts_per_page', $default ) );
}


/**
 * Check whether to show open list info in a post title.
 *
 * @param string $default Optional. Default value.
 *
 * @return bool
 */
function snax_show_open_list_in_title( $default = 'on' ) {
	$show = apply_filters( 'snax_show_open_list_in_title', get_option( 'snax_show_open_list_in_title', $default ) );

	return 'on' === $show;
}

/**
 * Return items count placeholder, used in titles.
 *
 * @param string $default Optional. Default value.
 *
 * @return string
 */
function snax_get_post_title_item_count_placeholder( $default = '%%items%%' ) {
	return apply_filters( 'snax_post_title_item_count_placeholder', $default );
}

/**
 * Is the anonymous posting allowed?
 *
 * @param bool $default Optional. Default value.
 *
 * @return bool
 */
function snax_allow_anonymous( $default = false ) {
	return apply_filters( 'snax_allow_anonymous', (bool) get_option( 'snax_allow_anonymous', $default ) );
}


/**
 * Return number of votes to display on a single page
 *
 * @param int $default Optional. Default value.
 *
 * @return mixed|void
 */
function snax_get_votes_per_page( $default = 3 ) {
	return apply_filters( 'snax_votes_per_page', (int) $default );
}


/** User > Slugs ******************************************************** */

/**
 * Return the user upvotes slug
 *
 * @param string $default Default value.
 *
 * @return string
 */
function snax_get_user_upvotes_slug( $default = 'upvotes' ) {
	return apply_filters( 'snax_get_user_upvotes_slug', $default );
}

/**
 * Return the user downvotes slug
 *
 * @param string $default Default value.
 *
 * @return string
 */
function snax_get_user_downvotes_slug( $default = 'downvotes' ) {
	return apply_filters( 'snax_get_user_downvotes_slug', $default );
}

/**
 * Return the user approved posts slug
 *
 * @param string $default Default value.
 *
 * @return string
 */
function snax_get_user_approved_posts_slug( $default = 'approved' ) {
	return apply_filters( 'snax_get_user_approved_posts_slug', $default );
}

/**
 * Return the user draft posts slug
 *
 * @param string $default Default value.
 *
 * @return string
 */
function snax_get_user_draft_posts_slug( $default = 'draft' ) {
	return apply_filters( 'snax_get_user_draft_posts_slug', $default );
}

/**
 * Return the user pending posts slug
 *
 * @param string $default Default value.
 *
 * @return string
 */
function snax_get_user_pending_posts_slug( $default = 'pending' ) {
	return apply_filters( 'snax_get_user_pending_posts_slug', $default );
}

/**
 * Return the user approved items slug
 *
 * @param string $default Default value.
 *
 * @return string
 */
function snax_get_user_approved_items_slug( $default = 'approved' ) {
	return apply_filters( 'snax_get_user_approved_items_slug', $default );
}

/**
 * Return the user pending items slug
 *
 * @param string $default Default value.
 *
 * @return string
 */
function snax_get_user_pending_items_slug( $default = 'pending' ) {
	return apply_filters( 'snax_get_user_pending_items_slug', $default );
}

/** Pages ******************************************************** */


/**
 * Return url of the Terms and Conditions page
 *
 * @param string $default Optional. Default value.
 *
 * @return string
 */
function snax_get_legal_page_url( $default = '' ) {
	$page_id = snax_get_legal_page_id();

	return ! empty( $page_id ) ? get_permalink( $page_id ) : $default;
}

/**
 * Return ID of the Terms and Conditions page
 *
 * @return int
 */
function snax_get_legal_page_id() {
	return apply_filters( 'snax_legal_page_id', get_option( 'snax_legal_page_id' ) );
}

/**
 * Return url of the page where user can submit a story
 *
 * @param string $default Optional. Default value.
 *
 * @return string
 */
function snax_get_frontend_submission_page_url( $default = '' ) {
	$page_id = snax_get_frontend_submission_page_id();

	return ! empty( $page_id ) ? get_permalink( $page_id ) : $default;
}

/**
 * Return ID of the page where user can submit a story
 *
 * @return int
 */
function snax_get_frontend_submission_page_id() {
	return (int) apply_filters( 'snax_frontend_submission_page_id', get_option( 'snax_frontend_submission_page_id' ) );
}

/**
 * Return url of the page where user can report any kind of abuse
 *
 * @param string $default Optional. Default value.
 *
 * @return string
 */
function snax_get_report_page_url( $default = '' ) {
	$page_id = snax_get_report_page_id();

	return ! empty( $page_id ) ? get_permalink( $page_id ) : $default;
}

/**
 * Return ID of the page where user can report any kind of abuse
 *
 * @return int
 */
function snax_get_report_page_id() {
	return apply_filters( 'snax_report_page_id', get_option( 'snax_report_page_id' ) );
}


/* Votes *********************************************************** */

/**
 * Check whether the voting system is enabled (globally, for all formats and post types)
 *
 * @return bool
 */
function snax_voting_is_enabled() {
	return 'on' === apply_filters( 'snax_voting_is_enabled', get_option( 'snax_voting_is_enabled', 'on' ) );
}

/**
 * Check whether guest user can vote
 *
 * @return bool
 */
function snax_guest_voting_is_enabled() {
	return 'on' === apply_filters( 'snax_guest_voting_is_enabled', get_option( 'snax_guest_voting_is_enabled', 'on' ) );
}

/**
 * Return list of post types than can be voted
 *
 * @return array
 */
function snax_voting_get_post_types() {
	$post_types = get_option( 'snax_voting_post_types', array() );

	// Allow voting for snax item on a single item page.
	$post_types[] = snax_get_item_post_type();

	$post_types = apply_filters( 'snax_voting_post_types', $post_types );

	if ( ! is_array( $post_types ) ) {
		$post_types = array();
	}

	return $post_types;
}

/**
 * Return fake vote count base
 *
 * @return int
 */
function snax_get_fake_vote_count_base() {
	return apply_filters( 'snax_fake_vote_count_base', get_option( 'snax_fake_vote_count_base', '' ) );
}

/* Demo ************************************************************ */

/**
 * Check whether the demo mode is enabled
 *
 * @return bool
 */
function snax_is_demo_mode() {
	return 'on' === apply_filters( 'snax_is_demo_mode', get_option( 'snax_demo_mode', 'on' ) );
}

/**
 * Return id of demo post
 *
 * @param string $format 		Post format.
 *
 * @return bool|int        		False if not set.
 */
function snax_get_demo_post_id( $format ) {
	if ( ! $format ) {
		return false;
	}

	$post_id = intval( get_option( 'snax_demo_'. $format .'_post_id' ) );

	if ( ! $post_id ) {
		$post_id = false;
	}

	return apply_filters( 'snax_demo_post_id', $post_id, $format );
}

/* Limits ************************************************************ */

/**
 * Return maximum size (in bytes) of uploaded files
 *
 * @return int
 */
function snax_get_max_upload_size() {
	$bytes_2mb = 2 * 1024 * 1024;

	return apply_filters( 'snax_max_upload_size', get_option( 'snax_max_upload_size', $bytes_2mb ) );
}

/**
 * Return image allowed mime types
 *
 * @return array
 */
function snax_get_image_allowed_types() {
	$types = array(
		'jpeg',
		'jpg',
		'png',
		'gif',
	);

	return apply_filters( 'snax_image_allowed_types', $types );
}

/**
 * Return maximum number of items that can be uploaded to an existing post
 *
 * @param int $default Optional. Default value.
 *
 * @return int
 */
function snax_get_user_submission_limit( $default = 1 ) {
	return (int) apply_filters( 'snax_user_submission_limit', get_option( 'snax_user_submission_limit', $default ) );
}

/**
 * Return maximum number of tags that can be assigned to a post during submission
 *
 * @return int
 */
function snax_get_tags_limit() {
	return (int) apply_filters( 'snax_tags_limit', 10 );
}

/**
 * Return maximum number of user submitted posts, in a day
 *
 * @param int $default Optional. Default value.
 *
 * @return int
 */
function snax_get_user_posts_per_day( $default = 1 ) {
	return (int) apply_filters( 'snax_user_posts_per_day', get_option( 'snax_user_posts_per_day', $default ) );
}

/**
 * Return maximum number of items that can be uploaded to a post during submission
 *
 * @param int $default Optional. Default value.
 *
 * @return int
 */
function snax_get_new_post_items_limit( $default = 20 ) {
	return (int) apply_filters( 'snax_new_post_items_limit', get_option( 'snax_new_post_items_limit', $default ) );
}

/**
 * Return maximum number of characters allowed in a post title
 *
 * @return int
 */
function snax_get_post_title_max_length() {
	return (int) apply_filters( 'snax_post_title_max_length', 64 );
}

/**
 * Return maximum number of characters allowed in a post description (short content)
 *
 * @return int
 */
function snax_get_post_description_max_length() {
	return (int) apply_filters( 'snax_post_description_max_length', 3600 );
}

/**
 * Return maximum number of characters allowed in a post content
 *
 * @return int
 */
function snax_get_post_content_max_length() {
	return (int) apply_filters( 'snax_post_content_max_length', 7200 );
}

/**
 * Return maximum number of characters allowed in a post title
 *
 * @return int
 */
function snax_get_item_title_max_length() {
	return (int) apply_filters( 'snax_item_title_max_length', 64 );
}

/**
 * Return maximum number of characters allowed in a post content
 *
 * @return int
 */
function snax_get_item_content_max_length() {
	return (int) apply_filters( 'snax_item_content_max_length', 3600 );
}

/**
 * Return maximum number of characters allowed in an item source
 *
 * @return int
 */
function snax_get_item_source_max_length() {
	return (int) apply_filters( 'snax_item_source_max_length', 256 );
}

/**
 * Return the slug of the custom post type for items
 *
 * @return string 	Snax item slug
 */
function snax_get_item_slug() {
	return apply_filters( 'snax_item_slug', get_option( 'snax_item_slug', 'snax_item' ) );
}

/**
 * Return the url prefix for snax elements
 *
 * @return string 	Url variable
 */
function snax_get_url_var_prefix() {
	$default = get_option( 'snax_url_var_prefix' );

	// Set default only if is not set.
	if ( false === $default ) {
		$default = 'snax';
	}

	return apply_filters( 'snax_url_var_prefix', $default );
}
