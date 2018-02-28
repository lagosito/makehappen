<?php
/**
 * Snax Frontend Submission Template Tags
 *
 * @package snax
 * @subpackage TemplateTags
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Whether there are more cards available in the loop
 *
 * @return bool
 */
function snax_cards() {

	$have_posts = snax()->cards_query->have_posts();

	// Reset the post data when finished.
	if ( empty( $have_posts ) ) {
		wp_reset_postdata();
	}

	return $have_posts;
}

/**
 * Loads up the current card in the loop
 */
function snax_the_card() {
	snax()->cards_query->the_post();
}

/**
 * Render number of the current card in the loop
 */
function snax_the_card_position() {
	echo esc_html( snax()->cards_query->current_post + 1 );
}

/**
 * Render image of the current card in the loop
 */
function snax_the_card_image() {
	the_post_thumbnail( apply_filters( 'snax_get_item_image_size', 'post-thumbnail' ) );
}

/**
 * Render embed code of the current card in the loop
 */
function snax_the_card_embed_code() {
	global $wp_embed;

	$code = $wp_embed->run_shortcode( '[embed]'. snax_get_the_card_embed_code() .'[/embed]' );

	echo ! empty( $code ) ? filter_var( $code ) : '';
}

/**
 * Print frontend submission form javascripts
 */
function snax_frontend_submission_render_scripts() {
?>
	<script type="text/javascript">
		(function() {
			if ( typeof window.snax === 'undefined' ) {
				window.snax = {};
			}

			var ctx = window.snax;

			ctx.currentUserId = <?php echo intval( get_current_user_id() ); ?>;

			if (0 === ctx.currentUserId) {
				document.addEventListener('DOMContentLoaded', function() {
					ctx.loginRequired(true);
				});
			}
		})();
	</script>
<?php
}

/**
 * Print frontend submission form hidden fields
 */
function snax_frontend_submission_render_hidden_data() {
?>
	<input type="hidden" name="snax-frontend-submission-nonce" value="<?php echo esc_attr( wp_create_nonce( 'snax-frontend-submission' ) ); ?>" />
<?php
}

/**
 * Load failed validation template
 */
function snax_frontend_submission_validation_feedback() {
	$errors = get_query_var( 'snax_errors' );

	if ( ! empty( $errors ) ) {
		snax_get_template_part( 'frontend-submission-validation-failed' );
	}
}


/**
 * Load info after saving Draft
 */
function snax_frontend_submission_draft_saved() {
	$draft_saved = filter_input( INPUT_GET, snax_get_url_var( 'draft_saved' ), FILTER_SANITIZE_STRING );

	if ( $draft_saved ) {
		snax_get_template_part( 'frontend-submission-post-draft-saved' );
	}
}