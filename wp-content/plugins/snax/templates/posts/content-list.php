<?php
/**
 * Snax List Content Template Part
 *
 * @package snax
 * @subpackage Theme
 */

?>

<div class="snax snax-post-container">
<?php
	do_action( 'snax_before_content_single_post', 'list' );

	snax_render_post_items();
	do_action( 'snax_post_voting_box' );
	snax_render_new_item_form();
	snax_render_post_origin();

	do_action( 'snax_after_content_single_post', 'list' );
?>
</div>

