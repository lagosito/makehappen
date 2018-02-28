<?php
/**
 * Snax Settings Template Tags
 *
 * @package snax
 * @subpackage Settings
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}


/** Settings ************************************************************ */


/**
 * Settings > General
 */
function snax_admin_general_settings() {
	?>

	<div class="wrap">

		<h1><?php esc_html_e( 'Snax Settings', 'snax' ) ?></h1>
		<h2 class="nav-tab-wrapper"><?php snax_admin_settings_tabs( __( 'General', 'snax' ) ); ?></h2>

		<form action="options.php" method="post">

			<?php settings_fields( 'snax-general-settings' ); ?>
			<?php do_settings_sections( 'snax-general-settings' ); ?>

			<p class="submit">
				<input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'snax' ); ?>" />
			</p>
		</form>
	</div>

<?php
}

/**
 * Settings > Lists
 */
function snax_admin_lists_settings() {
	?>

	<div class="wrap">

		<h1><?php esc_html_e( 'Snax Settings', 'snax' ) ?></h1>
		<h2 class="nav-tab-wrapper"><?php snax_admin_settings_tabs( __( 'Lists', 'snax' ) ); ?></h2>

		<form action="options.php" method="post">

			<?php settings_fields( 'snax-lists-settings' ); ?>
			<?php do_settings_sections( 'snax-lists-settings' ); ?>

			<p class="submit">
				<input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'snax' ); ?>" />
			</p>
		</form>
	</div>

	<?php
}

/**
 * Settings > Pages
 */
function snax_admin_pages_settings() {
	?>

	<div class="wrap">

		<h1><?php esc_html_e( 'Snax Settings', 'snax' ); ?> </h1>

		<h2 class="nav-tab-wrapper"><?php snax_admin_settings_tabs( __( 'Pages', 'snax' ) ); ?></h2>
		<form action="options.php" method="post">

			<?php settings_fields( 'snax-pages-settings' ); ?>
			<?php do_settings_sections( 'snax-pages-settings' ); ?>

			<p class="submit">
				<input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'snax' ); ?>" />
			</p>

		</form>
	</div>

	<?php
}

/**
 * Settings > Voting
 */
function snax_admin_voting_settings() {
	?>

	<div class="wrap">

		<h1><?php esc_html_e( 'Snax Settings', 'snax' ); ?> </h1>

		<h2 class="nav-tab-wrapper"><?php snax_admin_settings_tabs( __( 'Voting', 'snax' ) ); ?></h2>
		<form action="options.php" method="post">

			<?php settings_fields( 'snax-voting-settings' ); ?>
			<?php do_settings_sections( 'snax-voting-settings' ); ?>

			<p class="submit">
				<input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'snax' ); ?>" />
			</p>

		</form>
	</div>

	<?php
}

/**
 * Settings > Demo
 */
function snax_admin_demo_settings() {
	?>

	<div class="wrap">

		<h1><?php esc_html_e( 'Snax Settings', 'snax' ); ?> </h1>

		<h2 class="nav-tab-wrapper"><?php snax_admin_settings_tabs( __( 'Demo', 'snax' ) ); ?></h2>
		<form action="options.php" method="post">

			<?php settings_fields( 'snax-demo-settings' ); ?>
			<?php do_settings_sections( 'snax-demo-settings' ); ?>

			<p class="submit">
				<input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'snax' ); ?>" />
			</p>

		</form>
	</div>

	<?php
}


/** Sections ************************************************************ */

/**** Sections > General ************************************************ */

/**
 * Render general section description
 */
function snax_admin_settings_general_section_description() {}

/**
 * Formats
 */
function snax_admin_setting_callback_active_formats() {
	$formats = snax_get_formats();
	$active_formats_ids = snax_get_active_formats_ids();
	?>
	<div id="snax-settings-active-formats">
	<?php
	foreach ( $formats as $format_id => $format_args ) {
		$checkbox_id = 'snax_active_format_' . $format_id;
		?>
		<fieldset>
			<label for="<?php echo esc_attr( $checkbox_id ); ?>">
				<input name="snax_active_formats[]" id="<?php echo esc_attr( $checkbox_id ); ?>" type="checkbox" value="<?php echo esc_attr( $format_id ); ?>" <?php checked( in_array( $format_id, $active_formats_ids, true ) , true ); ?> /> <?php echo esc_html( $format_args['labels']['name'] ); ?>
			</label>
		</fieldset>
		<?php
	}
	?>
	</div>
	<input name="snax_formats_order" id="snax_formats_order" type="hidden" value="<?php echo esc_attr( implode( ',', snax_get_formats_order() ) ); ?>">
	<?php
}

/**
 * Items per page
 */
function snax_admin_setting_callback_items_per_page() {
	?>
	<input name="snax_items_per_page" id="snax_items_per_page" type="number" size="5" value="<?php echo esc_attr( snax_get_global_items_per_page() ); ?>" />
	<?php
}

/**
 * Item count in title
 */
function snax_admin_setting_callback_item_count_in_title() {
	?>
	<input name="snax_show_item_count_in_title" id="snax_show_item_count_in_title" type="checkbox" <?php checked( snax_show_item_count_in_title() ); ?> />
	<?php
}

/**
 * Max. upload size
 */
function snax_admin_setting_callback_max_upload_size() {
	$bytes_1mb       = 1024 * 1024;

	$max_upload_size = snax_get_max_upload_size();
	$limit           = 32 * $bytes_1mb;
	$max_limit       = wp_max_upload_size();
	$limit           = min( $limit, $max_limit );

	$choices         = array();

	for ( $i = $bytes_1mb; $i <= $limit; $i *= 2 ) {
		$choices[ $i ] = ( $i / $bytes_1mb ) . 'MB';
	}

	$choices = apply_filters( 'snax_max_upload_size_choices', $choices );
	?>
	<select name="snax_max_upload_size" id="snax_max_upload_size">
		<?php foreach ( $choices as $value => $label ) : ?>
		<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $max_upload_size, $value ); ?>><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

/**
 * How many new posts user can submit, per day.
 */
function snax_admin_setting_callback_new_posts_limit() {
	$limit = snax_get_user_posts_per_day();
	?>

	<select name="snax_user_posts_per_day" id="snax_user_posts_per_day">
		<option value="1" <?php selected( 1, $limit ) ?>><?php esc_html_e( 'only 1 post', 'snax' ) ?></option>
		<option value="10" <?php selected( 10, $limit ) ?>><?php esc_html_e( '10 posts', 'snax' ) ?></option>
		<option value="-1" <?php selected( -1, $limit ) ?>><?php esc_html_e( 'unlimited posts', 'snax' ) ?></option>
	</select>
	<span><?php esc_html_e( 'per day.', 'snax' ); ?></span>
	<?php
}

/**
 * How many new items user can submit to a new post (during creation).
 */
function snax_admin_setting_callback_new_post_items_limit() {
	$limit = snax_get_new_post_items_limit();
	?>

	<select name="snax_new_post_items_limit" id="snax_new_post_items_limit">
		<option value="10" <?php selected( 10, $limit ) ?>><?php esc_html_e( '10 items', 'snax' ) ?></option>
		<option value="20" <?php selected( 20, $limit ) ?>><?php esc_html_e( '20 items', 'snax' ) ?></option>
		<option value="-1" <?php selected( -1, $limit ) ?>><?php esc_html_e( 'unlimited items', 'snax' ) ?></option>
	</select>
	<span><?php esc_html_e( 'while creating a new list/gallery. Applies also to Story format images.', 'snax' ); ?></span>
	<?php
}

/**
 * Disable admin bar
 */
function snax_admin_setting_callback_disable_admin_bar() {
	?>
	<input name="snax_disable_admin_bar" id="snax_disable_admin_bar" type="checkbox" <?php checked( snax_disable_admin_bar() ); ?> />
	<?php
}

/**
 * Disable dashboard access
 */
function snax_admin_setting_callback_disable_dashboard_access() {
	?>
	<input name="snax_disable_dashboard_access" id="snax_disable_dashborad_access" type="checkbox" <?php checked( snax_disable_dashboard_access() ); ?> />
	<?php
}

/**
 * Disable WP login form
 */
function snax_admin_setting_callback_disable_wp_login() {
	?>
	<input name="snax_disable_wp_login" id="snax_disable_wp_login" type="checkbox" <?php checked( snax_disable_wp_login() ); ?> />
	<?php
}

/**
 * Whether force user to choose category or not
 */
function snax_admin_setting_callback_category_required() {
	$required = snax_is_category_required();
	?>

	<select name="snax_category_required" id="snax_category_required">
		<option value="standard" <?php selected( $required, true ) ?>><?php esc_html_e( 'required', 'snax' ) ?></option>
		<option value="none" <?php selected( $required, false ) ?>><?php esc_html_e( 'optional', 'snax' ) ?></option>
	</select>
	<?php
}

/**
 * Multiple categories selection.
 */
function snax_admin_setting_callback_category_multi() {
	?>
	<input name="snax_category_multi" id="snax_category_multi" type="checkbox" <?php checked( snax_multiple_categories_selection() ); ?> />
	<?php
}

/**
 * Category white-list
 */
function snax_admin_setting_callback_category_whitelist() {
	$whitelist = snax_get_category_whitelist();
	$all_categories = get_categories( 'hide_empty=0' );
	?>
	<select size="5" name="snax_category_whitelist[]" id="snax_category_whitelist" multiple="multiple">
		<option value="" <?php selected( in_array( '', $whitelist, true ) ); ?>><?php esc_html_e( '- Allow all -', 'snax' ) ?></option>
		<?php foreach ( $all_categories as $category_obj ) : ?>
			<?php
			// Exclude the Uncategorized option.
			if ( 'uncategorized' === $category_obj->slug ) {
				continue;
			}
			?>

			<option value="<?php echo esc_attr( $category_obj->slug ); ?>" <?php selected( in_array( $category_obj->slug, $whitelist, true ) ); ?>><?php echo esc_html( $category_obj->name ) ?></option>
		<?php endforeach; ?>
	</select>
	<span><?php esc_html_e( 'Categories allowed for user while creating a new post.', 'snax' ); ?></span>
	<?php
}

/**
 * Auto assign to category.
 */
function snax_admin_setting_callback_category_auto_assign() {
	$auto_assign_list = snax_get_category_auto_assign();
	$all_categories = get_categories( 'hide_empty=0' );
	?>
	<select size="5" name="snax_category_auto_assign[]" id="snax_category_auto_assign" multiple="multiple">
		<option value="" <?php selected( in_array( '', $auto_assign_list, true ) ); ?>><?php esc_html_e( '- Not assign -', 'snax' ) ?></option>
		<?php foreach ( $all_categories as $category_obj ) : ?>
			<?php
			// Exclude the Uncategorized option.
			if ( 'uncategorized' === $category_obj->slug ) {
				continue;
			}
			?>

			<option value="<?php echo esc_attr( $category_obj->slug ); ?>" <?php selected( in_array( $category_obj->slug, $auto_assign_list, true ) ); ?>><?php echo esc_html( $category_obj->name ) ?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

/**
 * Facebook App Id
 */
function snax_admin_setting_callback_facebook_app_id() {
	?>
	<input name="snax_facebook_app_id" id="snax_facebook_app_id" type="number" size="5" value="<?php echo esc_attr( snax_get_facebook_app_id() ); ?>" />
	<?php
}

/**
 * Whether to allow user direct publishing
 */
function snax_admin_setting_callback_skip_verification() {
	$skip = snax_skip_verification();
	?>

	<select name="snax_skip_verification" id="snax_skip_verification">
		<option value="standard" <?php selected( $skip, true ) ?>><?php esc_html_e( 'yes', 'snax' ) ?></option>
		<option value="none" <?php selected( $skip, false ) ?>><?php esc_html_e( 'no', 'snax' ) ?></option>
	</select>
	<?php
}

/**
 * Whether to send mail to admin when new post/item was added
 */
function snax_admin_setting_callback_mail_notifications() {
	$mail = snax_mail_notifications();
	?>

	<select name="snax_mail_notifications" id="snax_mail_notifications">
		<option value="standard" <?php selected( $mail, true ) ?>><?php esc_html_e( 'yes', 'snax' ) ?></option>
		<option value="none" <?php selected( $mail, false ) ?>><?php esc_html_e( 'no', 'snax' ) ?></option>
	</select>
	<?php
}

/**** Sections > Lists ************************************************** */

/**
 * Render Lists section description
 */
function snax_admin_settings_lists_section_description() {}

/**
 * New item forms
 */
function snax_admin_setting_callback_active_item_forms() {
	$forms = snax_get_registered_item_forms();
	$active_forms_ids = snax_get_active_item_forms_ids();

	foreach ( $forms as $form_id => $form_args ) {
		$checkbox_id = 'snax_active_item_form_' . $form_id;
		?>
		<fieldset>
			<label for="<?php echo esc_attr( $checkbox_id ); ?>">
				<input name="snax_active_item_forms[]" id="<?php echo esc_attr( $checkbox_id ); ?>" type="checkbox" value="<?php echo esc_attr( $form_id ); ?>" <?php checked( in_array( $form_id, $active_forms_ids, true ) , true ); ?> /> <?php echo esc_html( $form_args['labels']['name'] ); ?>
			</label>
		</fieldset>
		<?php
	}
	?>
	<?php
}

/**
 * Show open list status in title
 */
function snax_admin_setting_callback_list_status_in_title() {
	?>
	<input name="snax_show_open_list_in_title" id="snax_show_open_list_in_title" type="checkbox" <?php checked( snax_show_open_list_in_title() ); ?> />
	<?php
}

/**
 * Anonymous posting
 */
function snax_admin_setting_callback_anonymous() {
	?>

	<input name="snax_allow_anonymous" id="snax_allow_anonymous" type="checkbox" value="1" <?php checked( snax_allow_anonymous( false ) ); ?> />
	<label for="snax_allow_anonymous"><?php esc_html_e( 'Allow guest users without accounts to submit new items.', 'snax' ); ?></label>

<?php
}

/**
 * User can submit (limit)
 */
function snax_admin_setting_callback_user_submission_limit() {
	$limit = snax_get_user_submission_limit();
	?>

	<select name="snax_user_submission_limit" id="snax_user_submission_limit">
		<option value="1" <?php selected( 1, $limit ) ?>><?php esc_html_e( 'only 1 item', 'snax' ) ?></option>
		<option value="-1" <?php selected( -1, $limit ) ?>><?php esc_html_e( 'unlimited items', 'snax' ) ?></option>
	</select>
	<span><?php esc_html_e( 'to an existing list.', 'snax' ); ?></span>
<?php
}


/** Pages Section **************************************************************/


/**
 * Pages section description
 */
function snax_admin_settings_pages_section_description() {}

/**
 * Frontend Submission page
 */
function snax_admin_setting_callback_frontend_submission_page() {
	$selected_page_id = snax_get_frontend_submission_page_id();
	?>

	<?php wp_dropdown_pages( array(
		'name'             => 'snax_frontend_submission_page_id',
		'show_option_none' => esc_html__( '- None -', 'snax' ),
		'selected'         => absint( $selected_page_id ),
	) );

if ( ! empty( $selected_page_id ) ) :
	?>
		<a href="<?php echo esc_url( snax_get_frontend_submission_page_url() ); ?>" class="button-secondary" target="_blank"><?php esc_html_e( 'View', 'snax' ); ?></a>
	<?php
	endif;
}

/**
 * Legal page
 */
function snax_admin_setting_callback_legal_page() {
	$selected_page_id = snax_get_legal_page_id();
	?>

	<?php wp_dropdown_pages( array(
		'name'             => 'snax_legal_page_id',
		'show_option_none' => esc_html__( '- None -', 'snax' ),
		'selected'         => absint( $selected_page_id ),
	) );

if ( ! empty( $selected_page_id ) ) :
		?>
		<a href="<?php echo esc_url( snax_get_legal_page_url() ); ?>" class="button-secondary" target="_blank"><?php esc_html_e( 'View', 'snax' ); ?></a>
		<?php
	endif;
}

/**
 * Report page
 */
function snax_admin_setting_callback_report_page() {
	$selected_page_id = snax_get_report_page_id();
	?>

	<?php wp_dropdown_pages( array(
		'name'             => 'snax_report_page_id',
		'show_option_none' => esc_html__( '- None -', 'snax' ),
		'selected'         => absint( $selected_page_id ),
	) );

if ( ! empty( $selected_page_id ) ) :
		?>
		<a href="<?php echo esc_url( snax_get_report_page_url() ); ?>" class="button-secondary" target="_blank"><?php esc_html_e( 'View', 'snax' ); ?></a>
		<?php
	endif;
}

/** Voting Section ************************************************************/

/**
 * Voting section description
 */
function snax_admin_settings_voting_section_description() {}

/**
 * Voting enabled?
 */
function snax_admin_setting_callback_voting_enabled() {
	?>
	<input name="snax_voting_is_enabled" id="snax_voting_is_enabled" type="checkbox" <?php checked( snax_voting_is_enabled() ); ?> />
	<?php
}

/**
 * Guest Voting enabled?
 */
function snax_admin_setting_callback_guest_voting_enabled() {
	?>
	<input name="snax_guest_voting_is_enabled" id="snax_guest_voting_is_enabled" type="checkbox" <?php checked( snax_guest_voting_is_enabled() ); ?> />
	<?php
}


/**
 * Post types.
 */
function snax_admin_setting_callback_voting_post_types() {
	$post_types = get_post_types();
	$supported_post_types = snax_voting_get_post_types();

	foreach ( $post_types as $post_type ) {
		$skipped = array( 'attachment', 'revision', 'nav_menu_item', snax_get_item_post_type() );

		if ( in_array( $post_type, $skipped, true ) ) {
			continue;
		}

		$checkbox_id = 'snax_voting_post_type_' . $post_type;
		?>
		<fieldset>
			<label for="<?php echo esc_attr( $checkbox_id ); ?>">
				<input name="snax_voting_post_types[]" id="<?php echo esc_attr( $checkbox_id ); ?>" type="checkbox" value="<?php echo esc_attr( $post_type ); ?>" <?php checked( in_array( $post_type, $supported_post_types, true ) , true ); ?> /> <?php echo esc_html( $post_type ); ?>
			</label>
		</fieldset>
		<?php
	}
	?>
	<?php
}

/**
 * Fake vote count base
 */
function snax_admin_setting_callback_fake_vote_count_base() {
	?>
	<input name="snax_fake_vote_count_base" id="snax_fake_vote_count_base" type="number" value="<?php echo esc_attr( snax_get_fake_vote_count_base() ); ?>" placeholder="<?php esc_attr_e( 'e.g. 1000', 'snax' ); ?>" />
	<span><?php esc_html_e( 'Leave empty to not use "Fake votes" feature.', 'snax' ); ?></span>
	<?php
}

/** Demo Section **************************************************************/


/**
 * Demo section description
 */
function snax_admin_settings_demo_section_description() {}

/**
 * Demo mode enabled?
 */
function snax_admin_setting_callback_demo_mode() {
	?>
	<input name="snax_demo_mode" id="snax_demo_mode" type="checkbox" <?php checked( snax_is_demo_mode() ); ?> />
	<?php
}


/**
 * Demo post
 *
 * @param array $args			Renderer config.
 */
function snax_admin_setting_callback_demo_post( $args ) {
	$format = $args['format'];
	$selected_post_id = snax_get_demo_post_id( $format );
	$select_name = sprintf( 'snax_demo_%s_post_id', $format );

	$posts = get_posts( array(
		'posts_per_page'   => -1,
		'orderby'          => 'title',
		'order'            => 'ASC',
		'post_status'      => 'any',
		'meta_key'         => '_snax_format',
		'meta_value'       => 'meme' === $format ? 'image' : $format,
	) );
	?>
	<select name="<?php echo esc_attr( $select_name ) ?>" id="<?php echo esc_attr( $select_name ); ?>">
		<option value=""><?php esc_html_e( '- None -', 'snax' ) ?></option>

		<?php foreach( $posts as $post ) : ?>
			<option class="level-0" value="<?php echo intval( $post->ID ) ?>" <?php selected( $post->ID, $selected_post_id ); ?>><?php echo esc_html( get_the_title( $post ) ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php

	if ( ! empty( $selected_post_id ) ) :
		?>
		<a href="<?php echo esc_url( get_permalink( $selected_post_id ) ); ?>" class="button-secondary" target="_blank"><?php esc_html_e( 'View', 'snax' ); ?></a>
		<?php
	endif;

	if ( 'meme' === $format ) {
		esc_html_e( 'Choose an Image post', 'snax' );
	}
}

/** Permalinks Section **************************************************************/


/**
 * Permalinks section description
 */
function snax_permalinks_section_description() {}

/**
 * Item post type slug
 */
function snax_permalink_callback_item_slug() {
	?>
	<code><?php echo esc_url( trailingslashit( home_url() ) ); ?></code>
	<input name="snax_item_slug" id="snax_item_slug" maxlength="20" type="text" value="<?php echo esc_attr( snax_get_item_slug() ) ?>" />
	<code>/sample-post/</code>
	<?php
}

/**
 * Prefix for all Snax url variables
 */
function snax_permalink_callback_url_var_prefix() {
	?>
	<input name="snax_url_var_prefix" id="snax_url_var_prefix" type="text" value="<?php echo esc_attr( snax_get_url_var_prefix() ) ?>" />
	<?php
}
