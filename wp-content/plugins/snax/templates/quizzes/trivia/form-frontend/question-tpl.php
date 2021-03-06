<?php
/**
 * Question template part
 *
 * @package snax
 * @subpackage Forms
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>
<div class="quizzard-question">
	<div class="quizzard-question-header">
		<div class="quizzard-question-position"></div>

		<div class="quizzard-question-thumbnail">
			<%= media.image  %>
		</div>

		<h3 class="quizzard-question-title-yo"><%= title %></h3>
		<input class="quizzard-question-title" type="text" value="<%- title  %>" placeholder="<?php echo esc_html_x( 'Enter question here', 'Placeholder', 'snax' ); ?>" />

		<a class="quizzard-icon quizzard-icon-delete quizzard-question-delete" href="#" title="<?php esc_attr_e( 'Delete', 'snax' ); ?>"><?php esc_html_e( 'Delete', 'snax' ); ?></a>
		<a class="quizzard-icon quizzard-icon-toggle quizzard-question-toggle-state" href="#" title="<?php esc_attr_e( 'Collapse | Expand', 'snax' ); ?>"><?php esc_html_e( 'Collapse | Expand', 'snax' ); ?></a>
	</div>

	<div class="quizzard-question-body">


		<div class="quizzard-question-media <% print(media.id ? 'quizzard-question-with-media' : 'quizzard-question-without-media') %>">
			<%= media.image  %>
			<a class="quizzard-icon quizzard-icon-delete quizzard-question-delete-media" href="#" title="<?php esc_attr_e( 'Delete', 'snax' ); ?>"><?php esc_html_e( 'Delete', 'snax' ); ?></a>
			<input type="hidden" class="quizzard-question-media-id" value="<%- media.id  %>" />

			<div>
				<input type="checkbox" class="quizzard-question-title-hide"<%- title_hide ? ' checked="checked"' : ''  %> />
				<?php esc_html_e( 'Hide question title, it is presented on this image', 'snax' ); ?>
			</div>
		</div>

		<div class="quizzard-answers <% print('text' === answers_tpl ? 'quizzard-answers-without-media' : 'quizzard-answers-with-media') %>">
			<div class="quizzard-answers-header">
				<h3><?php esc_html_e( 'Answers', 'snax' ); ?></h3>

				<div class="snax-icon-radios">
					<label class="snax-icon-radio quizzard-answers-label-text"><input type="radio" name="snax_answers_tpl<%- id  %>" value="text" class="quizzard-question-answers-tpl" <% print('text' === answers_tpl ? 'checked="checked"' : '') %> /> <span><?php esc_html_e( 'Text', 'snax' ); ?></span></label>
					<label class="snax-icon-radio quizzard-answers-label-grid-2"><input type="radio" name="snax_answers_tpl<%- id  %>" value="grid-2" class="quizzard-question-answers-tpl" <% print('grid-2' === answers_tpl ? 'checked="checked"' : '') %> /> <span><?php esc_html_e( '2 images', 'snax' ); ?></span></label>
					<label class="snax-icon-radio quizzard-answers-label-grid-3"><input type="radio" name="snax_answers_tpl<%- id  %>" value="grid-3" class="quizzard-question-answers-tpl" <% print('grid-3' === answers_tpl ? 'checked="checked"' : '') %> /> <span><?php esc_html_e( '3 images', 'snax' ); ?></span></label>
				</div>
			</div>

			<p>
				<label>
					<input type="checkbox" class="quizzard-answers-labels-hide"<%- answers_labels_hide ? ' checked="checked"' : ''  %> />
					<?php esc_html_e( 'Hide answers labels, they are presented on images', 'snax' ); ?>
				</label>
			</p>

			<ul class="quizzard-items">
				<li class="quizzard-item quizzard-next-item">
					<?php snax_get_template_part( 'quizzes/trivia/form-frontend/answer-next-tpl' ); ?>
				</li>
			</ul>
		</div><!-- .quizzard-answers -->
	</div>
</div>
