<?php
/**
 * Snax News Post Row Actions
 *
 * @package snax
 * @subpackage Theme
 */

?>

<div class="snax-edit-post-row-actions">

	<?php if ( current_user_can( 'snax_publish_posts' ) ) : ?>

		<input type="submit" value="<?php esc_attr_e( 'Publish', 'snax' ); ?>"
		       class="snax-button snax-button-publish-post" />

	<?php else : ?>

		<input type="submit" value="<?php esc_attr_e( 'Submit for Review', 'snax' ); ?>"
		       class="snax-button snax-button-submit-post" />

	<?php endif; ?>

</div>
