<?php
/**
 * New item form
 *
 * @package snax
 * @subpackage Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>

<?php do_action( 'snax_frontend_submission_form_before_new_embed' ); ?>

<input type="hidden" name="snax-add-embed-item-nonce" value="<?php echo esc_attr( wp_create_nonce( 'snax-add-embed-item' ) ); ?>"/>

<div class="snax-new-embeds">

	<p class="snax-new-embeds-url">
		<textarea class="snax-embed-url snax-embed-url-multi" rows="3" cols=40"
		          placeholder="<?php esc_attr_e( 'Paste link or embed code&hellip;', 'snax' ); ?>"></textarea>
		<span class="snax-hint"><?php esc_html_e( 'e.g.: https://www.youtube.com/watch?v=WwoKkq685Hk', 'snax' ); ?></span>
	</p>

	<p class="snax-new-embeds-actions">
		<input class="g1-button g1-button-simple g1-button-m" type="submit" name="snax-add-embed-item"
		       value="<?php esc_attr_e( 'Add', 'snax' ); ?>"/>
	</p>
</div>

<?php do_action( 'snax_frontend_submission_form_after_new_embed' ); ?>
