<?php
/**
 * New post form for format "Trvia quiz"
 *
 * @package snax
 * @subpackage Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>

<?php
// HTML classes of the form.
$snax_class = array(
	'snax',
	'snax-form-frontend',
	'snax-form-without-items',
);
if ( snax_is_frontend_submission_edit_mode() ) {
	$snax_class[] = 'snax-form-frontend-edit-mode';
}
?>

<?php do_action( 'snax_before_frontend_submission_form', 'personality_quiz' ); ?>

	<form action="" method="post" class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $snax_class ) ); ?>">
		<?php do_action( 'snax_frontend_submission_form_start', 'personality_quiz' ); ?>

		<div class="snax-form-main">
			<h2 class="snax-form-main-title screen-reader-text"><?php esc_html_e( 'Share your story', 'snax' ); ?></h2>

			<?php snax_get_template_part( 'posts/form-edit/row-title' ); ?>

			<?php snax_get_template_part( 'posts/form-edit/row-description' ); ?>

			<?php
			// Load JS.
			wp_enqueue_script('backbone');
			wp_enqueue_media();
			wp_enqueue_script( 'snax-quiz-common', 	snax_get_includes_url() . 'quizzes/admin/js/common.js', array( 'jquery' ), snax_get_version(), true );
			wp_enqueue_script( 'snax-personality-quiz',  snax_get_includes_url() . 'quizzes/admin/js/personality-quiz.js', array( 'backbone', 'snax-quiz-common', 'jquery', 'jquery-ui-sortable' ), snax_get_version(), true );

			$snax_post_id = (int) filter_input( INPUT_GET, snax_get_url_var( 'post' ), FILTER_SANITIZE_NUMBER_INT );

			if ( $snax_post_id ) {
				$quiz_post = get_post( $snax_post_id );
			} else {
				$quiz_post = snax_get_user_draft_quizz( 'personality' );
			}

			// Set up global post to quiz draft.
			global $post;
			$current_post = $post;

			$post = $quiz_post;

			// Load template.
			add_filter( 'snax_quiz_settings_tab_active', '__return_false' );

			snax_get_template_part( 'quizzes/personality/form-frontend/quiz-tpl' );

			$post = $current_post;
			wp_reset_postdata();
			?>

		</div><!-- .snax-form-main -->

		<div class="snax-form-side">
			<h2 class="snax-form-side-title screen-reader-text"><?php esc_html_e( 'Publish Options', 'snax' ); ?></h2>

			<input type="hidden" name="snax-post-format" value="personality_quiz"/>

			<?php
			global $snax_post_format;
			global $snax_post_id;
			$snax_post_id = $quiz_post->ID;
			$snax_post_format = 'personality_quiz';
			snax_get_template_part( 'posts/form-edit/row-featured-image' );
			?>

			<?php snax_get_template_part( 'posts/form-edit/row-categories' ); ?>

			<?php snax_get_template_part( 'posts/form-edit/row-tags' ); ?>

			<?php snax_get_template_part( 'posts/form-edit/row-legal' ); ?>

			<?php snax_get_template_part( 'posts/form-edit/row-draft-actions' ); ?>

			<?php snax_get_template_part( 'posts/form-edit/row-actions' ); ?>
		</div><!-- .snax-form-side -->

		<?php do_action( 'snax_frontend_submission_form_end', 'personality_quiz' ); ?>
	</form>

<?php do_action( 'snax_after_frontend_submission_form', 'personality_quiz' ); ?>
