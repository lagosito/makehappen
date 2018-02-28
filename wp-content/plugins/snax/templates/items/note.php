<?php
/**
 * Template part for displaying item submission note.
 *
 * @package snax
 * @subpackage Theme
 */

?>

<?php if ( snax_item_submitted() ) : ?>

	<?php snax_get_template_part( 'items/note-submission-success' ); ?>

<?php endif; ?>
