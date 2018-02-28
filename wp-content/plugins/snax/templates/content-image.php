<?php
/**
 * Snax Image Card
 *
 * @package snax
 * @subpackage FrontendSubmission
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>

<div class="snax-image snax-object" data-snax-id="<?php the_ID(); ?>">

	<div class="snax-object-container">
		<?php do_action( 'snax_before_card_media' ); ?>

		<?php snax_the_card_image(); ?>

		<?php do_action( 'snax_after_card_media' ); ?>
	</div>

	<div class="snax-object-actions">
		<?php snax_render_item_delete_link( array(
			'classes' => array(
				'snax-object-action',
				'snax-image-action',
				'snax-image-action-delete',
			),
		) ); ?>
	</div>
</div>
