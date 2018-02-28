<?php
/**
 * Upload media form
 *
 * @package snax
 * @subpackage Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$snax_upload_dir = wp_upload_dir();

if ( ! wp_is_writable( $snax_upload_dir['basedir'] ) ) {
	snax_get_template_part( 'notes/uploads-dir-not-writable' );
	return;
}
?>

<div class="snax-upload">

	<?php do_action( 'snax_before_upload_form' ); ?>

	<input type="hidden" name="snax-add-image-item-nonce"
	       value="<?php echo esc_attr( wp_create_nonce( 'snax-add-image-item' ) ); ?>"/>

	<?php snax_media_upload_form(); ?>

	<label>
		<?php esc_html_e( 'Or get image from URL', 'snax' ); ?>
		<input type="text" class="snax-load-image-from-url" size="255" placeholder="<?php esc_html_e( 'http://', 'snax' ); ?>" />
	</label>

	<?php do_action( 'snax_after_upload_form' ); ?>

</div>
