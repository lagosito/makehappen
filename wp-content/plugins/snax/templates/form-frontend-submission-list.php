<?php
/**
 * New post form for format "List"
 *
 * @package snax
 * @subpackage Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$snax_has_items = snax_has_user_cards( 'list' );

// HTML classes of the form.
$snax_class = array(
	'snax',
	'snax-form-frontend',
);

if ( ! $snax_has_items ) {
	$snax_class[] = 'snax-form-frontend-without-media';
}
if ( snax_is_frontend_submission_edit_mode() ) {
	$snax_class[] = 'snax-form-frontend-edit-mode';
}
?>

<?php do_action( 'snax_before_frontend_submission_form', 'list' ); ?>

	<form action="" method="post" class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $snax_class ) ); ?>">
		<?php do_action( 'snax_frontend_submission_form_start', 'list' ); ?>

		<div class="snax-form-main">
			<h2 class="snax-form-main-title screen-reader-text"><?php esc_html_e( 'Share your story', 'snax' ); ?></h2>

			<?php snax_get_template_part( 'posts/form-edit/row-title' ); ?>

			<?php snax_get_template_part( 'posts/form-edit/row-description' ); ?>

			<div class="snax-cards">
				<?php
				if ( $snax_has_items ) :
					snax_get_template_part( 'loop-cards' );
				endif;
				?>
			</div><!-- .snax-cards -->

			<div class="snax-edit-post-row-media">
				<?php snax_render_snax_new_item_tabs( array( 'add_new' => 'add_new_items' ) ); ?>

				<?php foreach ( snax_get_new_item_forms() as $snax_key => $snax_value ) : ?>
					<?php
					$snax_class = array(
						'snax-tab-content',
						'snax-tab-content-' . $snax_key,
					);

					if ( snax_get_selected_new_item_form() === $snax_key ) {
						$snax_class[] = 'snax-tab-content-current';
					}
					?>
					<div class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $snax_class ) ); ?>">
						<?php add_filter( 'snax_plupload_config', 'snax_plupload_allow_multi_selection' ); ?>
						<?php snax_get_template_part( 'posts/form-edit/new', $snax_key ); ?>
					</div>
				<?php endforeach; ?>
			</div>
			<?php snax_get_template_part( 'notes/limit-edit-post-items' ); ?>

		</div><!-- .snax-form-main -->

		<div class="snax-form-side">
			<h2 class="snax-form-side-title screen-reader-text"><?php esc_html_e( 'Publish Options', 'snax' ); ?></h2>

			<input type="hidden" name="snax-post-format" value="list" />

			<?php snax_get_template_part( 'posts/form-edit/row-categories' ); ?>

			<?php snax_get_template_part( 'posts/form-edit/row-tags' ); ?>

			<?php snax_get_template_part( 'posts/form-edit/row-list-options' ); ?>

			<?php snax_get_template_part( 'posts/form-edit/row-legal' ); ?>

			<?php snax_get_template_part( 'posts/form-edit/row-draft-actions' ); ?>

			<?php snax_get_template_part( 'posts/form-edit/row-actions' ); ?>
		</div><!-- .snax-form-side -->

		<?php do_action( 'snax_frontend_submission_form_end', 'list' ); ?>
	</form>

<?php do_action( 'snax_after_frontend_submission_form', 'list' ); ?>
