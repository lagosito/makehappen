<?php
/**
 * Result template part
 *
 * @package snax
 * @subpackage Forms
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>

<div class="quizzard-result">
	<div class="quizzard-result-header">
		<div class="quizzard-result-range"><span class="quizzard-result-range-low"><%- range.low %></span>&ndash;<span class="quizzard-result-range-high"><%- range.high %></span></div>
		<div class="quizzard-result-range-edit">
			<input type="number" min="0" max="100" class="quizzard-result-range-low" value="<%- range.low %>" size="3" />
			&ndash;
			<input type="number" min="0" max="100" class="quizzard-result-range-high" value="<%- range.high %>" size="3" />
		</div>

		<div class="quizzard-result-thumbnail">
			<%= media.image  %>
		</div>

		<h3 class="quizzard-result-title-yo"><%= title %></h3>
		<input class="quizzard-result-title" type="text" value="<%- title  %>" placeholder="<?php echo esc_html_x( 'Enter result here', 'Placeholder', 'snax' ); ?>" />

		<a class="quizzard-icon quizzard-icon-delete quizzard-result-delete" href="#" title="<?php esc_attr_e( 'Delete', 'snax' ); ?>"><?php esc_html_e( 'Delete', 'snax' ); ?></a>
		<a class="quizzard-icon quizzard-icon-toggle quizzard-result-toggle-state" href="#" title="<?php esc_attr_e( 'Collapse | Expand', 'snax' ); ?>"><?php esc_html_e( 'Collapse | Expand', 'snax' ); ?></a>
	</div>

	<div class="quizzard-result-body">
		<div class="quizzard-result-media <% print(media.id ? 'quizzard-result-with-media' : 'quizzard-result-without-media') %>">
			<%= media.image  %>
			<a class="quizzard-icon quizzard-icon-delete quizzard-result-delete-media" href="#" title="<?php esc_attr_e( 'Delete', 'snax' ); ?>"><?php esc_html_e( 'Delete', 'snax' ); ?></a>
			<input type="hidden" class="quizzard-result-media-id" value="<%- media.id  %>" />
		</div>

		<p>
			<textarea class="quizzard-result-description" rows="4" cols="40" placeholder="<?php echo esc_attr_e( 'Type some description', 'bimber' ); ?>"><%= description %></textarea>
		</p>
	</div>
</div>
