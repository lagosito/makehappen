<?php
/**
 * User Pending Posts
 *
 * @package snax
 * @subpackage Templates
 */

?>
<div class="snax">
	<?php do_action( 'snax_template_before_user_draft_posts' ); ?>

	<div id="snax-user-draft-posts" class="snax-user-draft-posts">
		<div class="snax-user-section">

			<?php if ( snax_has_user_draft_posts() ) : ?>

				<?php snax_get_template_part( 'buddypress/posts/pagination', 'top' ); ?>

				<?php snax_get_template_part( 'buddypress/posts/loop-posts' ); ?>

				<?php snax_get_template_part( 'buddypress/posts/pagination', 'bottom' ); ?>

			<?php else : ?>

				<p><?php esc_html_e( 'There are no items yet', 'snax' ); ?></p>

			<?php endif; ?>

		</div>
	</div>

	<?php do_action( 'snax_template_after_user_draft_posts' ); ?>
</div>
