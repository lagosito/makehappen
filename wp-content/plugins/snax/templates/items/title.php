<?php
/**
 * Template for displaying single item title
 *
 * @package snax
 * @subpackage Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
$permalink = '';

$post = get_post();
$parent_id = snax_get_item_parent_id( $post );

if ( snax_is_post_open_list( $parent_id ) ) {
	$permalink = get_permalink();
}
?>
<h3 class="snax-item-title">
<?php if ( strlen( $permalink ) ) : ?>
	<a href="<?php echo esc_url( $permalink ); ?>" id="snax-itemli-<?php echo (int) get_the_ID(); ?>" rel="bookmark">
<?php endif; ?>
	<?php
		echo snax_capture_item_position();
		the_title('', '');
	?>
<?php if ( strlen( $permalink ) ) : ?>
	</a>
<?php endif; ?>
</h3>