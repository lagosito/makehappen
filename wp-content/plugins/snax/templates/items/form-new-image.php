<?php
/**
 * New item form
 *
 * @package snax
 * @subpackage Theme
 */

?>

<form id="snax-new-item-image" class="snax-form snax-form-without-media snax-form-prior-media snax-new-item" xmlns="http://www.w3.org/1999/html">

	<?php if ( 2 > count( snax_get_new_item_forms() ) ) : ?>
		<h2 class="snax-new-item-title"><?php esc_html_e( 'Add New Image', 'snax' ); ?></h2>
	<?php endif; ?>

	<p class="snax-new-item-row-title">
		<label><?php esc_html_e( 'Title', 'snax' ); ?></label>
		<input name="snax-item-title"
		       type="text"
		       value=""
		       maxlength="<?php echo esc_attr( snax_get_item_title_max_length() ); ?>"
		       placeholder="<?php esc_attr_e( 'Enter title&hellip;', 'snax' ); ?>"
		       autocomplete="off"
		/>
	</p>

	<?php // @csstodo - zmienic snax-media na snax-media-row. ?>
	<div class="snax-media">

		<span class="snax-validation-tip"><?php esc_html_e( 'This field is required', 'snax' ); ?></span>

		<div class="snax-upload-preview" data-snax-media-id="<?php echo esc_attr( snax_get_user_uploaded_media_id() ); ?>">
			<div class="snax-upload-preview-inner"></div>
			<a href="#" class="snax-upload-preview-delete"><?php esc_html_e( 'Delete', 'snax' ); ?></a>
		</div>

		<?php snax_get_template_part( 'form-upload-media' ); ?>

		<div class="snax-upload-icon"><?php esc_html_e( 'Processing...', 'snax' ); ?></div>

		<input type="hidden" name="snax-delete-media-nonce"
		       value="<?php echo esc_attr( wp_create_nonce( 'snax-delete-media' ) ); ?>"/>
	</div>

	<p class="snax-new-item-row-source">
		<input type="checkbox" name="snax-item-has-source" id="snax-item-has-source" /> <label for="snax-item-has-source"><?php esc_html_e( 'Not your original work? Note the source', 'snax' ); ?></label>
		<input name="snax-item-source"
		       type="text"
		       maxlength="<?php echo esc_attr( snax_get_item_source_max_length() ); ?>"
		       placeholder="<?php esc_attr_e( 'http://', 'snax' ) ?>"/>
	</p>

	<p class="snax-new-item-row-description">
		<label><?php esc_html_e( 'Description', 'snax' ); ?></label>
		<textarea name="snax-item-description"
		          rows="3"
		          cols="40"
		          maxlength="<?php echo esc_attr( snax_get_item_content_max_length() ); ?>"
		          placeholder="<?php esc_attr_e( 'Enter some description&hellip;', 'snax' ); ?>"></textarea>
	</p>

	<?php if ( snax_legal_agreement_required() ) : ?>
	<p class="snax-new-item-row-legal">
		<label>
			<input type="checkbox" name="snax-item-legal" required autocomplete="off" /> <?php esc_html_e( 'I agree with the terms and conditions.', 'snax' ); ?>
		</label>

		<span class="snax-validation-tip"><?php esc_html_e( 'This field is required', 'snax' ); ?></span>

		<?php snax_render_legal_page_link(); ?>
	</p>
	<?php endif; ?>

	<p class="snax-new-item-row-actions">

		<?php if ( current_user_can( 'snax_publish_items' ) ) : ?>

			<input type="submit" id="snax-add-image-item" value="<?php esc_attr_e( 'Publish', 'snax' ); ?>"/>

		<?php else : ?>

			<input type="submit" id="snax-add-image-item" value="<?php esc_attr_e( 'Submit for Review', 'snax' ); ?>"/>

		<?php endif; ?>
	</p>

</form>

